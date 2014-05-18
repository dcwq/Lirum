<?php

namespace Engine;

use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Registry;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Application as PhalconApplication;
use Phalcon\Mvc\Router\Annotations as RouterAnnotations;
use Phalcon\Session\Adapter as SessionAdapter;
use Phalcon\Session\Adapter\Files as SessionFiles;
use Phalcon\Logger\Adapter\File;
use Phalcon\Logger\Formatter\Line as FormatterLine;
use Phalcon\Mvc\Dispatcher;

class Application extends PhalconApplication
{
    public function __construct()
    {
        //create DI
        $di = new \Phalcon\DI\FactoryDefault();

        parent::__construct($di);

        $this->_initException();
        $this->_initConfig();
        $this->_initRegistry();
        $this->_initLogger();
    }

    public function run()
    {
        $di = DI::getDefault();
        $config = $di->get('config');
        $eventsManager = new EventsManager();
        $this->setEventsManager($eventsManager);

        $this->_initDispatcher();
        $this->_initLoader();
        $this->_initAnnotations();
        $this->_initSession();
        $this->_initRepositories();
        $this->_initRouter();
    }

    public function registerModules($modules, $merge = NULL)
    {
        foreach ($modules as $moduleName => $moduleClass)
        {
            //var_dump($modules);

            if (isset($this->_modules[$moduleName])) {
                //continue;
            }

            $bootstrap = new $moduleClass($this->getDI(), $this->getEventsManager());

            $bootstraps[$moduleName] = function () use ($bootstrap)
            {
                $bootstrap->registerServices();
                return $bootstrap;
            };
        }

        return parent::registerModules($bootstraps, $merge);
    }

    public function getOutput()
    {
        return $this->handle()->getContent();
    }

    private function _initException()
    {
        $di = $this->getDI();

        set_error_handler(
            function ($errorCode, $errorMessage, $errorFile, $errorLine) {
                throw new \ErrorException($errorMessage, $errorCode, 1, $errorFile, $errorLine);
            }
        );

        set_exception_handler(
            function ($e) use ($di) {

                if (APPLICATION_STAGE == APPLICATION_STAGE_DEVELOPMENT)
                {

                    $errorId = Exception::logException($e);
                    //$errorId = 1;

//        if ($di->get('app')->isConsole())
//        {
//            echo 'Error <' . $errorId . '>: ' . $e->getMessage();
//            return true;
//        }

                    //if (APPLICATION_STAGE == APPLICATION_STAGE_DEVELOPMENT)
                    //{
                    $p = new \Engine\Exception\PrettyExceptions($di);
                    $p->setBaseUri('pretty-exceptions/');
                    return $p->handleException($e);
                    //}
                }

                return true;
            }
        );
    }

    private function _initDispatcher()
    {
        $di = $this->di;

        $di->set(
            'dispatcher',
            function() use ($di) {

                $evManager = $di->getShared('eventsManager');

                $evManager->attach(
                    "dispatch:beforeException",
                    function($event, $dispatcher, $exception)
                    {
                        switch ($exception->getCode()) {
                            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                                $dispatcher->forward(
                                    array(
                                        'controller' => 'error',
                                        'action'     => 'show404',
                                    )
                                );
                                return false;
                        }
                    }
                );
                $dispatcher = new Dispatcher();
                $dispatcher->setEventsManager($evManager);
                return $dispatcher;
            },
            true
        );
    }

    private function _initConfig()
    {
        $this->di->set('config', require(ROOT_PATH . '/app/config/'.APPLICATION_STAGE.'/config.php'));
    }

    private function _initRegistry()
    {
        $registry = new \Phalcon\Registry();
        $registry->modules = ['core'];

        $registry->directories = (object)[
            'engine' => ROOT_PATH . '/app/engine/',
            'modules' => ROOT_PATH . '/app/modules/',
            'libraries' => ROOT_PATH . '/app/libraries/',
            'repositories' => ROOT_PATH . '/app/repositories/'
        ];

        $this->di->set('registry', $registry);
    }

    protected function _initLoader()
    {
        $di = $this->getDI();

        // Add all required namespaces and modules.
        $registry = $di->get('registry');
        $namespaces = [];
        $bootstraps = [];

        foreach ($registry->modules as $module) {
            $moduleName = ucfirst($module);
            $namespaces[$moduleName] = $registry->directories->modules . $moduleName;
            $bootstraps[$module] = $moduleName . '\Bootstrap';
        }

        $namespaces['Engine'] = $registry->directories->engine;
        $namespaces['Library'] = $registry->directories->libraries;

        $loader = new Loader();
        $loader->registerNamespaces($namespaces);

        $loader->registerNamespaces(array(
            'Engine' => ROOT_PATH . '/app/engine/',
            'Services' => ROOT_PATH . '/app/services/',
            'Repository' => ROOT_PATH . '/app/repositories/',
            'Core' => ROOT_PATH . '/app/modules/Core/',
			'Core\Form' => ROOT_PATH . '/app/modules/Core/forms/',
            'Core\Controller' => ROOT_PATH . '/app/modules/Core/controllers/'
        ));

        $loader->register();

        $this->registerModules($bootstraps);

        $di->set('loader', $loader);

        return $loader;
    }

    protected function _initLogger()
    {
        $this->di->set(
            'logger',
            function ($file = 'main', $format = null) {

                $config = $this->di->get('config');

                $logger = new File($config->application->logger->path . APPLICATION_STAGE . '.' . $file . '.log');
                $formatter = new FormatterLine(($format ? $format : $config->application->logger->format));
                $logger->setFormatter($formatter);

                return $logger;
            },
            false
        );
    }

    protected function _initAnnotations()
    {
        $this->getDI()->set(
            'annotations',
            function () {
                //if (!$config->application->debug && isset($config->application->annotations)) {
                if (1==1){
                    $annotationsAdapter = '\Phalcon\Annotations\Adapter\\' . $this->di->get('config')->application->annotations->adapter;
                    $adapter = new $annotationsAdapter($this->di->get('config')->application->annotations->toArray());
                } else {
                    $adapter = new AnnotationsMemory();
                }

                return $adapter;
            },
            true
        );
    }

    protected function _initRepositories()
    {
        $repositoryPrefix = 'lirum.repository.';

        // Get all file names.
        $files = scandir($this->getDI()->get('registry')->directories->repositories);

        // Iterate files.
        foreach ($files as $file)
        {
            if ($file == "." || $file == "..") {
                continue;
            }

            $repositoryName = substr($file, 0, strrpos($file, '.'));
            $className = 'Repository\\' . $repositoryName;

            $this->di->set($repositoryPrefix . strtolower($repositoryName), new $className());
        }
    }

    protected function _initRouter()
    {
        //router
        $this->di->set('router', function() {
            $router = new RouterAnnotations(true);

            //get default module name from config file
            $defaultModule = $this->getDI()->get('config')->application->defaultModule;

            $router->setDefaultModule($defaultModule);
            $router->setDefaultNamespace(ucfirst($defaultModule) . "\\Controller\\");

            $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);

            $router->removeExtraSlashes(TRUE);

            $modules = $this->getDI()->get('registry')->modules;

            // Read the annotations from controllers.
            foreach ($modules as $module) {
                $moduleName = ucfirst($module);

                // Get all file names.
                $files = scandir($this->getDI()->get('registry')->directories->modules . $moduleName . '/controllers');

                // Iterate files.
                foreach ($files as $file) {
                    if ($file == "." || $file == ".." || strpos($file, 'Controller.php') === false) {
                        continue;
                    }

                    $controller = $moduleName . '\Controller\\' . str_replace('Controller.php', '', $file);
                    $router->addModuleResource(strtolower($module), $controller);
                }
            }

            return $router;
        });
    }

    protected function _initSession()
    {
        $di = $this->getDI();
        $config = $di->get('config');

        if (!isset($config->application->session)) {
            $session = new SessionFiles();
        } else {
            $adapterClass = 'Phalcon\Session\Adapter\\' . $config->application->session->adapter;
            $session = new $adapterClass($config->application->session->toArray());
        }

        $session->start();
        $di->setShared('session', $session);
        return $session;

    }

}
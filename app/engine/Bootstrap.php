<?php

namespace Engine;

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Engine\Behaviour\DIBehaviour;

abstract class Bootstrap
{
    use DIBehaviour {
        DIBehaviour::__construct as protected __DIConstruct;
    }

    protected $_moduleName = "";

    public function __construct($di, $em)
    {
        $this->__DIConstruct($di);
        $this->_em = $em;
        $this->_config = $this->getDI()->get('config');
    }

    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Get events manager.
     *
     * @return Manager
     */
    public function getEventsManager()
    {
        return $this->_em;
    }

    /**
     * Get current module name.
     *
     * @return string
     */
    public function getModuleName()
    {
        return $this->_moduleName;
    }

    public function getModuleDirectory()
    {
        return $this->getDI()->get('registry')->directories->modules . $this->_moduleName;
    }

    /**
     * Register the services.
     *
     * @throws Exception
     * @return void
     */
    public function registerServices()
    {
        $di = $this->getDI();
        $moduleName = $this->getModuleName();

        /**
         * Setting up the view component
         */
        $di->set('view', function () use ($di, $moduleName) {

            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(ROOT_PATH . '/app/modules/'.$moduleName.'/views/');
            $view->registerEngines(array(".volt" => 'volt'));
            $view->setPartialsDir('../../'.ucfirst($di->getConfig()->application->defaultModule).'/views/');

            return $view;
        });

        $view = $di->get('view');

        /**
         * Setting up volt engine
         */
        $di->set('volt', function($view, $di) {

            $config = $di->get('config');
            //$view = $this->getDI()->get('view');

            $volt = new Volt($view, $di);

            $volt->setOptions(
                array(
                    'compiledPath'      => $config->volt->path,
                    'compiledExtension' => $config->volt->extension,
                    'compiledSeparator' => $config->volt->separator,
                    'stat'              => (bool)$config->volt->stat,
                    'compileAlways'     => true
                )
            );

            return $volt;
        });

    }
}
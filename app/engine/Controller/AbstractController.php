<?php
namespace Engine\Controller;

use Engine\Behaviour\DIBehaviour;
use Phalcon\Db\Column;
use Phalcon\DI;
use Phalcon\Mvc\Controller as PhalconController;
use Phalcon\Mvc\View;

/**
 * Base controller.
 */

abstract class AbstractController extends PhalconController
{
    /**
     * Initializes the controller.
     *
     * @return void
     */
    public function initialize()
    {
        if (!$this->request->isAjax()) {
            $this->_setupAssets();
        }

        // run init function
        if (method_exists($this, 'init')) {
            $this->init();
        }
    }

    public function renderContent($url = null, $controller = null, $type = null)
    {
        $page = false;

        if (!$page || !$page->isAllowed()) {
            return $this->dispatcher->forward(
                [
                    'controller' => 'Error',
                    'action' => 'show404'
                ]
            );
        }
    }

    /**
     * After route execution.
     *
     * @return void
     */
    public function afterExecuteRoute()
    {

    }

    /**
     * Setup assets.
     *
     * @return void
     */
    protected function _setupAssets()
    {

    }

}
<?php

namespace Core\Controller;

use Engine\Controller\AbstractController;
use Services\User;

/**
 * Class IndexController
 * @package Core\Controller
 *
 * RoutePrefix("/", name="invoice")
 */
class IndexController extends AbstractController
{

    public function indexAction()
    {
        $repository = $this->di->get('pshop.repository.product');

        try
        {
        	User::getService('User')->getLast();
        }
        catch (\Exception $e)
        {
        	$this->flash->error($e->getMessage());
        }
    }

    /**
     * @Route("/test", methods={"GET"}, name="test")
     */

    public function testAction()
    {
        $repository = $this->di->get('pshop.repository.product');

        try
        {
            User::getService('User')->getLast();
        }
        catch (\Exception $e)
        {
            $this->flash->error($e->getMessage());
        }
    }
}

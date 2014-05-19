<?php

namespace Core\Controller;

use Engine\Controller\AbstractController;
use Services\Test;
use Core\Form\Test as TestForm;

/**
 * Class IndexController
 * @package Core\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("", methods={"GET"}, name="homepage")
     */
    public function indexAction()
    {
        //$repository = $this->di->get('lirum.repository.test');
    }

    /**
     * @Route("/test", methods={"GET"}, name="test")
     */
    public function testAction()
    {

    }
}

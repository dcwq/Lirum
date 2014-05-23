<?php

namespace Core\Controller;

use Engine\Controller\AbstractController;
use Product\Model\Product;
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

    }

    /**
     * @Route("/test", methods={"GET"}, name="test")
     */
    public function testAction()
    {
        $product = new Product();
        $product->name = 'Test';
        $product->description = 'Description';
        $product->price = rand(1,30);
        $product->save();
    }
}

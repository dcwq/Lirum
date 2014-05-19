<?php

namespace Product\Controller;

use Engine\Controller\AbstractController;
use Product\Model\Product;
use Services\User;

/**
 * Class IndexController
 * @package Product\Controller
 *
 * @RoutePrefix("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/{id:[0-9].*}/{slug:.*}", methods={"GET"}, name="product-show")
     */
    public function showAction($id, $slug)
    {
        $this->view->setVar('id', $id);
        $this->view->setVar('slug', $slug);

        $a = new Product();
        $a->name = 'Nazwa ' . rand(1,999999);
        $a->save();
    }

}

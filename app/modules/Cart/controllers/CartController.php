<?php

namespace Cart\Controller;

use Engine\Controller\AbstractController;
use Services\User;

/**
 * Class IndexController
 * @package Cart\Controller
 *
 * @RoutePrefix("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/show", methods={"GET"}, name="cart-index")
     */
    public function indexAction()
    {

    }

}

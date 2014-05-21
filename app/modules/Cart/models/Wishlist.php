<?php

namespace Cart\Model;

use Engine\Db\AbstractModel;

/**
 * Cart
 *
 * @Source("wishlist")
 */

class Wishlist extends AbstractModel
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="id", size="11")
     */
    public $id;

    /**
     * @Column(type="string", nullable=false, column="name", size="255")
     */
    public $name;

    private $product_id;
    private $quantity;
    private $user_id;
}
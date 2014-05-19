<?php

namespace Product\Model;

use Engine\Db\AbstractModel;

/**
 * Product
 *
 * @Source("products")
 */

class Product extends AbstractModel
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
}

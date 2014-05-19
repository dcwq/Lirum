<?php

namespace Product\Model;

use Engine\Db\AbstractModel;

/**
 * Product
 *
 * @Source("product")
 */

class Product extends AbstractModel
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="id", size="11")
     */
    public $id;
}

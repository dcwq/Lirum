<?php

namespace Product\Model;

use Engine\Db\AbstractModel;

/**
 * Attribute
 *
 * @Source("attribute")
 */

class Attribute extends AbstractModel
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
    private $attribute_id;
    private $order;
    private $cost_difference;
}

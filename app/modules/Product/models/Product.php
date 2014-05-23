<?php

namespace Product\Model;

use Engine\Db\AbstractModel;

/**
 * Product
 *
 * @Source("product")
 * @HasMany("id", "ProductCategory", "category_id")
 */

class Product extends AbstractModel
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="id", size="11")
     */
    public $id;

    //relations

    /**
     * @Column(type="integer", nullable=true, column="image_id", size="11")
     */
    public $image_id;

    //

    /**
     * @Column(type="string", nullable=false, column="name", size="255")
     */
    public $name;

    /**
     * @Column(type="string", nullable=false, column="description", size="10000")
     */
    public $description;

    /**
     * @Column(type="decimal", nullable=false, column="price", size="10,2")
     */
    public $price;

    /**
     * @Column(type="decimal", nullable=true, column="stock", size="10,2")
     */
    public $stock;

    /**
     * @Column(type="decimal", nullable=true, column="weight", size="10,2")
     */
    public $weight;


    private $heading;
    private $metakeywords;
    private $metadescription;
    private $metarobots;
    private $active;
    private $secure;
    private $activeProduct;
}

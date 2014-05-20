<?php

namespace Category\Model;

use Engine\Db\AbstractModel;

/**
 * Category
 *
 * @Source("category")
 */

class Category extends AbstractModel
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

    private $registry;
    private $subcatsCache = 0;
    private $productsCache = 0;
    private $numSubcats=0;
    private $isValid = false;
    private $numProducts = 0;
    private $title;
    private $content;
    private $metakeywords;
    private $metadescription;
    private $metarobots;
    private $active;
    private $secure;
}
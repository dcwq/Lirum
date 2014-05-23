<?php

namespace Product\Model;

use Engine\Db\AbstractModel;

/**
 * Product
 *
 * @Source("product_category")
 *
 * @BelongsTo('product_id', 'Product\Model\Product', 'id', {
 *    'alias': 'products'
 * });
 * @BelongsTo('category_id', 'Category\Model\Category', 'id', {
 *    'alias': 'categories'
 * });
 */

class ProductCategory extends AbstractModel
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="id", size="11")
     */
    public $id;

    /**
     * @Column(type="integer", nullable=false, column="product_id")
     */
    public $product_id;

    /**
     * @Column(type="integer", nullable=false, column="category_id")
     */
    public $category_id;
}
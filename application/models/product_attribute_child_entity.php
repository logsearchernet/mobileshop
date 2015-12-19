<?php

class Product_Attribute_Child_Entity extends MY_Model {
    
    const DB_TABLE = 'ms_product_attribute_child';
    const DB_TABLE_PK = 'id';
    
    /**
     * Product_Attribute_Child_Entity unique identifier.
     * @var int 
     */
    public $id;
    
    /**
     * @var int 
     */
    public $attribute_group;
    
    /**
     * @var string 
     */
    public $value;
    
    /**
     * @var int 
     */
    public $position;
    
    /**
     * @var string 
     */
    public $color;
    
    /**
     * @var date 
     */
    public $created_date;
    
    /**
     * @var date 
     */
    public $modified_date;
    
}
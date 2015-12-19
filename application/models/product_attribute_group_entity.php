<?php

class Product_Attribute_Group_Entity extends MY_Model {
    
    const DB_TABLE = 'ms_product_attribute_group';
    const DB_TABLE_PK = 'id';
    
    /**
     * Product_Attribute unique identifier.
     * @var int 
     */
    public $id;
    
    /**
     * @var string 
     */
    public $name;
    
    /**
     * @var string 
     */
    public $public_name;
    
    /**
     * @var boolean 
     */
    public $attribute_type;
    
    /**
     * @var int 
     */
    public $position;
    
    /**
     * @var date 
     */
    public $created_date;
    
    /**
     * @var date 
     */
    public $modified_date;
    
}
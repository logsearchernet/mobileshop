<?php

class Product_Entity extends MY_Model {
    
    const DB_TABLE = 'ms_product';
    const DB_TABLE_PK = 'id';
    
    /**
     * Category unique identifier.
     * @var int 
     */
    public $id;
    
    /**
     * @var string 
     */
    public $name;
    
    /**
     * @var int 
     */
    public $quantity;
    
    /**
     * @var boolean 
     */
    public $displayed;
    
    /**
     * @var int 
     */
    public $position;
    
    /**
     * @var string 
     */
    public $description;
    
    /**
     * @var double 
     */
    public $price;
    
    /**
     * @var date 
     */
    public $created_date;
    
    /**
     * @var date 
     */
    public $modified_date;
    
    /**
     * @var int 
     */
    public $category_id;
}
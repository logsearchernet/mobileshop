<?php

class Category_Entity extends MY_Model {
    
    const DB_TABLE = 'ms_category';
    const DB_TABLE_PK = 'id';
    
    /**
     * Category unique identifier.
     * @var int 
     */
    public $id;
    
    /**
     * @var int
     */
    public $parent_category;
    
    /**
     * @var string 
     */
    public $name;
    
    /**
     * @var string 
     */
    public $description;
    
    /**
     * @var boolean 
     */
    public $displayed;
    
    /**
     * @var date 
     */
    public $created_date;
    
    /**
     * @var date 
     */
    public $modified_date;
    
}
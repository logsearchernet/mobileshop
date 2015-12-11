<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_Attribute extends MY_Controller {
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for Dashboard controller.
     */
    public function index() {
        $this->content = 'product_attribute';
        $this->layout();
    }
}

?>
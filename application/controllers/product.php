<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MY_Controller {
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for Dashboard controller.
     */
    public function index() {
        $this->content = 'product';
        $this->layout();
    }
    
    public function product_edit() {
        $this->content = 'product_edit';
        $this->layout();
    }
}

?>
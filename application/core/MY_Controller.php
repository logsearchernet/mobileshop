<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
 { 
   var $limit = 10;
   var $geoCity = "Asia/Kuala_Lumpur";
        
   //set the class variable.
   var $template  = array();
   var $data      = array();
   
   public function __construct() {       
        parent::__construct();
    }
   
   //Load layout    
   public function layout() {
        $this->load->helper('url');
         // making temlate and send data to view.
         $this->template['header']   = $this->load->view('layout/header', $this->data, true);
         $this->template['content'] = $this->load->view($this->content, $this->data, true);
         $this->template['menubar'] = $this->load->view('layout/menubar', $this->data, true);
         $this->template['offcanvas'] = $this->load->view('layout/offcanvas', $this->data, true);
         $this->load->view('layout/index', $this->template);
   }
   
}
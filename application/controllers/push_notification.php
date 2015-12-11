<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Push_Notification extends MY_Controller {
    
    public function __construct() {        
        parent::__construct();
    }
  
    public function index() {
        $this->content = 'notification_send';
        $this->layout();
    }
    
    public function notification_user() {
        $this->content = 'notification_user';
        $this->layout();
    }
    
    public function notification_history() {
        $this->content = 'notification_history';
        $this->layout();
    }
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sample_Demo extends MY_Controller {
    
    
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for controller.
     */
    public function sample_tree() {
        $this->content = 'sample_tree';
        $this->layout();
    }   
    
    public function sample_dragdrop_sort() {
        $this->content = 'sample_dragdrop_sort';
        $this->layout();
    }  
    
    public function ajax_tree(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $cats = NULL;
        $id_parent = intval($data->id_parent);
        $this->load->model('Category_Entity');
        if (isset($id_parent)) {
            $where = "parent_category = ". $id_parent;
            $cats = $this->Category_Entity->getByWhere($where);
        }
        $categories = array();
        $categories2 = array();
        foreach ($cats as $cat) {
            $isLastChild = FALSE;
            $where2 = "parent_category = ". $cat->id;
            $cats2 = $this->Category_Entity->getByWhere($where2);
            if (empty($cats2)) {
                $isLastChild = TRUE;
            }
            $categories[] = array(
                "name" => $cat->name,
                "parent_category" => $cat->parent_category,
                "id" => $cat->id,
                "lastChild" => $isLastChild,
            );
        }
        $data = new stdClass();
        $data->data = $categories;
        
        $data = new stdClass();
        $data->data = $categories;
        echo json_encode($data);
    }
}
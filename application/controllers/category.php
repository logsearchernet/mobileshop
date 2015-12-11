<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category extends MY_Controller {
    
    
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for Dashboard controller.
     */
    public function index() {
        $success = $this->input->get('success');
        $this->load->model('Category_Entity');
        $where = NULL;
        $count = $this->Category_Entity->count_by($where);
        
        $this->data = array('count' => $count,
                            'limit' => $this->limit,
                            'success' => $success);
        $this->content = 'category';
        $this->layout();
    }
    
    public function ajax_category_displayed(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $id = $data->id;
        if (!empty($id)) {
            $this->load->helper('date');
            date_default_timezone_set($this->geoCity); 
            $displayed = $data->displayed;
            $this->load->model('Category_Entity');
            $category = new Category_Entity();
            $category->load($id);
            $category->modified_date = date('Y-m-d h:i:sa', now());
            $category->displayed = $displayed;
            $category->save();
        }
        echo json_encode($category);
    }
    
    public function ajax_category_table(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $offset = $data->offset;
        $filterName = $data->filterName;
        $filter = $data->filter;
        $deleteItems = $data->deleteItems;
        $filterNameArr = explode('|', $filterName);
        $filterArr = explode('|', $filter);
        $deleteItemArr = explode('|', $deleteItems);
        
        $this->load->model('Category_Entity');
        $where = NULL;
        if (isset($filterName) && !empty($filterName) && strlen($filterName) > 0) {
            $where = "";
            $length = count($filterNameArr);
            
            for ($i = 0; $i < $length; $i++) {
                $fn = $filterNameArr[$i];
                $f = $filterArr[$i];
                $where .= $fn ." LIKE '%".$f."%' ";
                if ($i != $length - 1){
                    $where .= "AND ";
                }
            }
        }
        if (isset($deleteItems) && !empty($deleteItems) && strlen($deleteItems) > 0) {
            $length = count($deleteItemArr);
            for ($i = 0; $i < $length; $i++) {
                $id = $deleteItemArr[$i];
                $this->load->model('Category_Entity');
                $category = new Category_Entity();
                $category->id = $id;
                $category->delete();
            }
        }
        
        $orderBy = "position asc";
        $count = $this->Category_Entity->count_by($where);
        $categories = $this->load_all($where, $this->limit, $offset, $orderBy);
        $categories->totalCount = $count;
        
        echo json_encode($categories);
    }
    
    public function category_form($id = NULL) {
        $this->load->helper('form');
        
        $this->load->model('Category_Entity');
        $category = new Category_Entity();
        if (isset($id)){
            $category->load($id);
        } 
        
        $this->data = array('category' => $category);
        $this->content = 'category_form';
        $this->layout();
    }
    
    public function category_edit() {
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $category = $this->save_category($this);
        $this->data = array('category' => $category);
        
        redirect('/category/?success=1', 'refresh');
    }
    
    /*public function category_remove($id = NULL) {
        $this->load->helper('url');
        if (isset($id)){
            $this->load->model('Category_Entity');
            $category = new Category_Entity();
            $category->id = $id;
            $category->delete();
            redirect('/category/?success=1', 'refresh');
        } else {
            redirect('/category/?fail=1', 'refresh');
        }
    }*/
    
    private function save_category(){
        $maxPosition = 0;
        $this->load->helper('date');
        $this->load->model('Category_Entity');
        
        date_default_timezone_set($this->geoCity); 
        $category = new Category_Entity();
        $id  = $this->input->post('id');
        if (!empty($id)) {
            $category->load($id);
        } else {
            $category->created_date = date('Y-m-d h:i:sa', now());
            $maxPosition = $category->max('position');
            $category->position = intval($maxPosition) + 1;
        }
        
        $category->name = $this->input->post('name');
        $category->parent_category = intval($this->input->post('parent_category'));
        $category->description = $this->input->post('description');
        $category->displayed = $this->input->post('displayed') === 'true'? true: false;
        $category->modified_date = date('Y-m-d h:i:sa', now());
        $category->save();
        
        return $category;
    }
    
    private function load_all($where, $limit, $offset, $orderBy){
        $categories = array();
        $this->load->model(array('Category_Entity'));
        
        $cats = $this->Category_Entity->get($limit, $offset, $where, $orderBy);
        foreach ($cats as $cat) {
            $categories[] = array(
                "name" => $cat->name,
                "description" => $cat->description,
                "displayed" => $cat->displayed,
                "parent_category" => $cat->parent_category,
                "id" => $cat->id,
                "position" => $cat->position,
            );
        }
        $data = new stdClass();
        $data->data = $categories;
        return $data;
    }
}

?>
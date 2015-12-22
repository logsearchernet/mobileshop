<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_Attribute_Group extends MY_Controller {
    
    var $limit = 0;
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for Dashboard controller.
     */
    public function index($id = 0) {
        $success = $this->input->get('success');
        $this->load->model('Product_Attribute_Group_Entity');
        $where = NULL;
        $count = $this->Product_Attribute_Group_Entity->count_by($where);
        
        $this->data = array('count' => $count,
                            'limit' => $this->limit,
                            'id' => $id,
                            'success' => $success);
        $this->content = 'product_attribute_group';
        $this->layout();
    }
    
    public function ajax_attribute_group_table() {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $orderby = $data->orderby;
        $orderway = $data->orderway;
        $offset = $data->offset;
        $filterName = $data->filterName;
        $filter = $data->filter;
        $deleteItems = $data->deleteItems;
        $filterNameArr = explode('|', $filterName);
        $filterArr = explode('|', $filter);
        $deleteItemArr = explode('|', $deleteItems);
        
        $this->load->model('Product_Attribute_Group_Entity');
        $this->load->model('Product_Attribute_Child_Entity');
        $where = NULL;
        if (isset($filterName) && !empty($filterName) && strlen($filterName) > 0) {
            //$where .= " AND ";
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
                if (empty($id)){
                    continue;
                }
                $this->load->model('Product_Attribute_Group_Entity');
                $attribute_group = new Product_Attribute_Group_Entity();
                $attribute_group->id = $id;
                
                $attribute_child = new Product_Attribute_Child_Entity();
                $children = $this->Product_Attribute_Child_Entity->getByWhere('attribute_group = '. $attribute_group->id);
                if (isset($children)) {
                    foreach ($children as $child) {
                        if (isset($child)){
                            $child->delete();
                        }
                    }
                }
                $attribute_group->delete();
            }
        }
        $orderStr = "position asc";
        if (isset($orderby) && !empty($orderby)){
            $orderStr = $orderby ." ". $orderway;
        } 
        $count = $this->Product_Attribute_Group_Entity->count_by($where);
        $attributes = $this->load_all($where, $this->limit, $offset, $orderStr);
        /*foreach ($attributes->data as $attr){
            if (isset($attribute)){
                $whereChild = "attribute_group = ". ($attr->id);
                $countChild = $this->Product_Attribute_Child_Entity->count_by($whereChild);
                //$attr->countChild = $countChild;
                $attr->countChild = 100;
            }
            
        }*/
        
        $attributes->totalCount = $count;
        
        echo json_encode($attributes);
    }
    
    public function ajax_attribute_group_sort_position(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $this->load->model('Product_Attribute_Group_Entity');
        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            $attr = $data[$i];
            $id = $attr->categoryid;
            $sortNum = $attr->sortNum;
            
            $attribute = new Product_Attribute_Group_Entity();
            $attribute->load($id);
            $attribute->position = $i + 1;
            
            $attribute->save();
        }
        $success = 1;
        echo json_encode($success);
    }
    
    public function attribute_group_form($id = NULL){
        $this->load->helper('form');
        
        $this->load->model('Product_Attribute_Group_Entity');
        $attribute = new Product_Attribute_Group_Entity();
        
        if (isset($id)){
            $attribute->load($id);
        } 
        
        $this->data = array('attribute' => $attribute,
                            'id' => $id);
        $this->content = 'product_attribute_group_form';
        $this->layout();
    }
    
    public function attribute_group_edit(){
        $maxPosition = 0;
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->load->helper('date');
        $this->load->model('Product_Attribute_Group_Entity');
        date_default_timezone_set($this->geoCity); 
        $attribute = new Product_Attribute_Group_Entity();
        $id  = $this->input->post('id');
        $where = NULL;
        $maxPosition = $attribute->max('position', $where);
        if (!empty($id)) {
            $attribute->load($id);
        } else {
            $attribute->created_date = date('Y-m-d h:i:sa', now());
            $where = "id =". $id;
            $attribute->position = intval($maxPosition) + 1;
        }
        
        $attribute->name = $this->input->post('name');
        $attribute->public_name = $this->input->post('public_name');
        $attribute->attribute_type = $this->input->post('attribute_type');
        
        $attribute->position = intval($this->input->post('position'));
        $attribute->modified_date = date('Y-m-d h:i:sa', now());
        $attribute->save();
        
        redirect('/product_attribute_group/index/?success=1', 'refresh');
    }
    private function load_all($where, $limit, $offset, $orderBy){
        $attributes = array();
        $this->load->model(array('Product_Attribute_Group_Entity'));
        
        $attrs = $this->Product_Attribute_Group_Entity->get($limit, $offset, $where, $orderBy);
        foreach ($attrs as $att) {
            $attributes[] = array(
                "name" => $att->name,
                "public_name" => $att->public_name,
                "id" => $att->id,
                "position" => $att->position,
            );
        }
        $data = new stdClass();
        $data->data = $attributes;
        return $data;
    }
    
}

?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_Attribute_Child extends MY_Controller {
    
    var $limit = 0;
    
    public function __construct() {        
        parent::__construct();
    }
  
    
    /**
     * Index page for Product_Attribute_Child controller.
     */
    public function index($parentId = null) {
        $success = $this->input->get('success');
        $this->load->model('Product_Attribute_Child_Entity');
        
        $where = NULL;
        if (isset($parentId)){
            $where = 'attribute_group = '. $parentId;
        }
        $count = $this->Product_Attribute_Child_Entity->count_by($where);
        
        $this->data = array('count' => $count,
                            'limit' => $this->limit,
                            'success' => $success,
                            'parentId' => $parentId);
        $this->content = 'product_attribute_child';
        $this->layout();
    }
    
    public function ajax_attribute_child_table() {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $orderby = $data->orderby;
        $orderway = $data->orderway;
        $parentId = $data->parent;
        $offset = $data->offset;
        $filterName = $data->filterName;
        $filter = $data->filter;
        $deleteItems = $data->deleteItems;
        $filterNameArr = explode('|', $filterName);
        $filterArr = explode('|', $filter);
        $deleteItemArr = explode('|', $deleteItems);
        
        $this->load->model('Product_Attribute_Child_Entity');
        $where = 'attribute_group = '. $parentId;
        if (isset($filterName) && !empty($filterName) && strlen($filterName) > 0) {
            $where .= " AND ";
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
                $this->load->model('Product_Attribute_Child_Entity');
                $attribute_group = new Product_Attribute_Child_Entity();
                $attribute_group->id = $id;
                $attribute_group->delete();
            }
        }
        
        $orderStr = "position asc";
        if (isset($orderby) && !empty($orderby)){
            $orderStr = $orderby ." ". $orderway;
        } 
        $count = $this->Product_Attribute_Child_Entity->count_by($where);
        $attributes = $this->load_all($where, $this->limit, $offset, $orderStr);
        $attributes->totalCount = $count;
        
        $sql = $this->db->last_query();
        $attributes->sql = $sql;
        
        echo json_encode($attributes);
    }
    
    public function ajax_attribute_child_sort_position(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $this->load->model('Product_Attribute_Child_Entity');
        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            $attr = $data[$i];
            $id = $attr->categoryid;
            $sortNum = $attr->sortNum;
            
            $attribute = new Product_Attribute_Child_Entity();
            $attribute->load($id);
            $attribute->position = $i + 1;
            
            $attribute->save();
        }
        $success = 1;
        echo json_encode($success);
    }
    
    public function attribute_child_form($id = NULL, $parentid = NULL){
        $this->load->helper('form');
        
        $this->load->model('Product_Attribute_Group_Entity');
        $this->load->model('Product_Attribute_Child_Entity');
        $attribute = new Product_Attribute_Child_Entity();
        
        if (isset($id) && $id != 0){
            $attribute->load($id);
            $parentid = $attribute->attribute_group;
        } 
        $where = NULL;
        $groups = $this->Product_Attribute_Group_Entity->getByWhere($where);
        $options = array();
        foreach ($groups as $group) {
            $options[$group->id] = $group->name;
        }
        
        $this->data = array('attribute' => $attribute,
                            'options' => $options,
                            'id' => $id,
                            'parentid' => $parentid);
        $this->content = 'product_attribute_child_form';
        $this->layout();
    }
    
    public function attribute_child_edit(){
        $maxPosition = 0;
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $this->load->helper('date');
        $this->load->model('Product_Attribute_Child_Entity');
        date_default_timezone_set($this->geoCity); 
        $attribute = new Product_Attribute_Child_Entity();
        
        $attribute_group = $this->input->post('attribute_group');
        $id  = $this->input->post('id');
        $where = NULL;
        $maxPosition = $attribute->max('position', $where);
        if (!empty($id)) {
            $attribute->load($id);
            $attribute->position = intval($this->input->post('position'));
        } else {
            $attribute->created_date = date('Y-m-d h:i:sa', now());
            $where = "id =". $id;
            $attribute->position = intval($maxPosition) + 1;
        }
        
        $attribute->value = $this->input->post('value');
        $attribute->color = $this->input->post('color');
        $attribute->attribute_group = $this->input->post('attribute_group');
        
        
        $attribute->modified_date = date('Y-m-d h:i:sa', now());
        $attribute->save();
        
        redirect('/product_attribute_child/index/'. $attribute_group .'?success=1', 'refresh');
    }
    private function load_all($where, $limit, $offset, $orderBy){
        $attributes = array();
        $this->load->model(array('Product_Attribute_Child_Entity'));
        
        $attrs = $this->Product_Attribute_Child_Entity->get($limit, $offset, $where, $orderBy);
        foreach ($attrs as $att) {
            $attributes[] = array(
                "value" => $att->value,
                "color" => $att->color,
                "attribute_group" => $att->attribute_group,
                "id" => $att->id,
                "position" => $att->position,
            );
        }
        $data = new stdClass();
        $data->data = $attributes;
        return $data;
    }
}
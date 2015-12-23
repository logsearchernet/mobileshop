<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product extends MY_Controller {
    
    public function __construct() {        
        parent::__construct();
    }
  
    /**
     * Index page for Dashboard controller.
     */
    public function index($categoryid = 0) {
        $success = $this->input->get('success');
        $this->load->model('Product_Entity');
        $where = "category_id = ". $categoryid;
        $count = $this->Product_Entity->count_by($where);
        
        $this->data = array('count' => $count,
                            'limit' => $this->limit,
                            'category_id' => $categoryid,
                            'success' => $success);
        $this->content = 'product';
        $this->layout();
    }
    
    public function ajax_expandselected_tree(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $this->load->model('Category_Entity');
        $list = array();
        $i = 0;
        $parentTemp = $data->id;
        do {
            $list[$i] = intval($parentTemp);
            $category = new Category_Entity();
            $category->load($parentTemp);
            $parentTemp = $category->parent_category;
            $i++;
        } while ($parentTemp != 0);
        
        
        $list[$i++] = 0;
        $reversed = array_reverse($list);
        echo json_encode($reversed);
    }
    
    public function ajax_tree(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $cats = NULL;
        $id_parent = intval($data->id);
        $current_cat_id = $data->current_cat_id;
        $this->load->model('Category_Entity');
        if (isset($id_parent)) {
            $where = "parent_category = ". $id_parent;
            $cats = $this->Category_Entity->getByWhere($where);
        }
        
        //$current_cat = new Category_Entity();
        //$current_cat->load($current_cat_id);
        
        $categories = array();
        foreach ($cats as $cat) {
            $isLastChild = FALSE;
            $checked = ($cat->id == $current_cat_id)?TRUE:FALSE;
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
                "checked" => $checked,
            );
        }
        $data = new stdClass();
        $data->data = $categories;
        
        $data = new stdClass();
        $data->data = $categories;
        echo json_encode($data);
    }
    
    public function ajax_product_displayed(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $id = $data->id;
        if (!empty($id)) {
            $this->load->helper('date');
            date_default_timezone_set($this->geoCity); 
            $displayed = $data->displayed;
            $this->load->model('Product_Entity');
            $product = new Product_Entity();
            $product->load($id);
            $product->modified_date = date('Y-m-d h:i:sa', now());
            $product->displayed = $displayed;
            $product->save();
        }
        echo json_encode($product);
    }
    
    public function ajax_product_sort_position(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $this->load->model('Product_Entity');
        $length = count($data);
        for ($i = 0; $i < $length; $i++) {
            $cat = $data[$i];
            $id = $cat->productid;
            $sortNum = $cat->sortNum;
            
            $product = new Product_Entity();
            $product->load($id);
            $product->position = $i + 1;
            
            $product->save();
        }
        $success = 1;
        echo json_encode($success);
    }
    
    public function ajax_product_table(){
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body);
        $this->output->set_content_type('application/json');
        
        $categoryid =  intval($data->parent);
        $offset = $data->offset;
        $filterName = $data->filterName;
        $filter = $data->filter;
        $deleteItems = $data->deleteItems;
        $filterNameArr = explode('|', $filterName);
        $filterArr = explode('|', $filter);
        $deleteItemArr = explode('|', $deleteItems);
        
        $this->load->model('Product_Entity');
        $this->load->model('Category_Entity');
        $where = NULL;
        if (isset($categoryid) && $categoryid >= 0) {
            $where = "category_id = ". $categoryid;
        }
        
        if (isset($filterName) && !empty($filterName) && strlen($filterName) > 0) {
            if (isset($where)){
                $where .= " AND ";
            }
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
                $this->load->model('Product_Entity');
                $product = new Product_Entity();
                $product->id = $id;
                $product->delete();
            }
        }
        
        $orderBy = "position asc";
        $count = $this->Product_Entity->count_by($where);
        $products = $this->load_all($where, $this->limit, $offset, $orderBy);
        $products->totalCount = $count;
        
        echo json_encode($products);
    }
    
    public function product_form($id = 0, $currentCategoryId = 0) {
        $this->load->helper('form');
        
        $this->load->model('Product_Entity');
        $this->load->model('Category_Entity');
        $product = new Product_Entity();
        $category= new Category_Entity();
        $categoryParentId = 0;
        if ($id > 0){
            $product->load($id);
            $currentCategoryId = $product->category_id;
            $catId = $product->category_id;
            $category->load($catId);
            $categoryParentId = $category->parent_category;
        } 
        $this->data = array('product' => $product,
                            'currentCategoryId' => $currentCategoryId,
                            'categoryParentId' => $categoryParentId,
                            'id' => $id);
        $this->content = 'product_form';
        $this->layout();
    }
    
    public function product_view($parent = 0) {
        $success = $this->input->get('success');
        $this->load->model('Product_Entity');
        $where = "parent_product = ". $parent;
        $count = $this->Product_Entity->count_by($where);
        
        $productNames = array();
        $parentTemp = $parent;
        $i = 0;
        do {
            $product = new Product_Entity();
            $product->load($parentTemp);
            $productNames[$product->id] = $product->name;
            $i++;
            $parentTemp = $product->parent_product;
        } while ($parentTemp != 0);
        
        $reversed = array_reverse($productNames, true);
        
        $this->data = array('count' => $count,
                            'limit' => $this->limit,
                            'success' => $success,
                            'parent' => $parent,
                            'productNames' => $reversed);
        
        $this->content = 'product';
        $this->layout();
    }
    
    public function product_edit() {
        $this->load->helper('date');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('form_validation');
        
        $product = $this->save_product($this);
        $this->data = array('product' => $product);
        
        redirect('/product/index/'. $product->category_id .'?success=1', 'refresh');
    }
    
    /*public function product_remove($id = NULL) {
        $this->load->helper('url');
        if (isset($id)){
            $this->load->model('Product_Entity');
            $product = new Product_Entity();
            $product->id = $id;
            $product->delete();
            redirect('/product/?success=1', 'refresh');
        } else {
            redirect('/product/?fail=1', 'refresh');
        }
    }*/
    
    private function save_product(){
        $maxPosition = 0;
        $this->load->helper('date');
        $this->load->model('Product_Entity');
        
        date_default_timezone_set($this->geoCity); 
        $product = new Product_Entity();
        $id  = $this->input->post('id');
        $category_id  = $this->input->post('parent_category');
        $where = "category_id =". $category_id;
        $maxPosition = $product->max('position', $where);
        if (!empty($id)) {
            $product->load($id);
        } else {
            $product->created_date = date('Y-m-d h:i:sa', now());
            $product->position = intval($maxPosition) + 1;
        }
        
        $product->name = $this->input->post('name');
        $product->category_id = intval($this->input->post('parent_category'));
        $product->description = $this->input->post('description');
        $product->price = $this->input->post('price');
        $product->quantity = $this->input->post('quantity');
        $product->displayed = $this->input->post('displayed') === 'true'? true: false;
        $product->modified_date = date('Y-m-d h:i:sa', now());
        $product->save();
        
        return $product;
    }
    
    private function load_all($where, $limit, $offset, $orderBy){
        $productArr = array();
        $this->load->model(array('Product_Entity'));
        $this->load->model(array('Category_Entity'));
        
        $products = $this->Product_Entity->get($limit, $offset, $where, $orderBy);
        
        foreach ($products as $product) {
            $categoryName = 'Home';
            $catId = $product->category_id;
            if ($product->category_id != 0){
                $cat = new Category_Entity();
                $cat->load($catId);
                $categoryName = $cat->name;
            }
            
            $productArr[] = array(
                "name" => $product->name,
                "displayed" => $product->displayed,
                "id" => $product->id,
                "position" => $product->position,
                "category" => $categoryName,
                "price" => $product->price,
                "quantity" => $product->quantity,
            );
        }
        $data = new stdClass();
        $data->data = $productArr;
        return $data;
    }
}

?>
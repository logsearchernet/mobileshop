<div class="row">
    <div class="col-lg-6">

        <ul class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-container">
                <a href="<?php echo site_url('product') ?>">Catalog</a>				
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('product') ?>">Products</a>
            </li>
        </ul>
    </div>
</div>
<br/>
<div class="col-lg-offset-1 col-md-8">
<?php echo validation_errors(); ?>
<?php
$formAttributes = array('class' => 'form-horizontal');
$labelAttributes = array(
'class' => 'col-sm-2 control-label',
);
$inputAttributes = 'class="form-control"';
?>
<?php echo form_open('product/product_edit', $formAttributes); ?>
        <div class="card">
            <div class="card-head style-primary">
                <header>Create a product</header>
            </div>
            <div class="card-body floating-label">
                
                <div class="form-group">
                    <?php echo form_label('Category', 'category', $labelAttributes); ?>
                    <div class=" col-sm-10">
                        <ul id="categories-tree" class="tree">
                            <li class="tree-folder">
                                <span class="tree-folder-name tree-selected" catid="">
                                    <input type="radio" name="parent_category" value="0" checked="checked">
                                    <i class="fa fa-folder"></i>
                                    <label class="tree-toggler">Home</label>
                                </span>

                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <?php echo form_label('Name', 'name', $labelAttributes); ?>
                    <div class="col-sm-10">
                        <?php echo form_input('name', $product->name, $inputAttributes); ?><div class="form-control-line"></div>
                    </div>
                </div> 
                
                <div class="form-group">
                    <?php echo form_label('Price', 'price', $labelAttributes); ?>
                    <div class="col-sm-10">
                        <?php echo form_input('price', $product->price, $inputAttributes); ?><div class="form-control-line"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <?php echo form_label('Quantity', 'quantity', $labelAttributes); ?>
                    <div class="col-sm-10">
                        <?php echo form_input('quantity', $product->quantity, $inputAttributes); ?><div class="form-control-line"></div>
                    </div>
                </div>
                
                
                
              <div class="form-group">
                    <?php echo form_label('Description', 'description', $labelAttributes); ?>
                    <div class="col-sm-10">                        
                        <?php echo form_textarea('description', $product->description, $inputAttributes); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo form_label('Display Product', 'displayed', $labelAttributes); ?>
                    <?php echo form_checkbox('displayed', 'true', $product->displayed);?>
                    <?php echo form_hidden('id', $product->id);?>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 text-left">
                        <a href="<?php echo site_url('product/') ?>" class="btn btn-primary ink-reaction">Cancel</a>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button type="submit" class="btn btn-primary ink-reaction"><?php echo (isset($product->id)?"Update product":"Create product"); ?></button>
                    </div>
                </div>
            </div><!--end .card-body -->
            
        </div><!--end .card -->
    <?php echo form_close(); ?>
</div>
<script>
var basePath = "<?php echo site_url('')?>";
var url = basePath+"product/ajax_tree";
var urlExpandAll = basePath+"product/ajax_expandselected_tree";
var expandselectedTree;
var currentArrIndex = 0;
var current_cat_id = <?php echo $product->category_id?>;
var urlTree = basePath+"category/ajax_tree";
var callbackTree = "category-tree";
var callbackExpandselectedTree = "category-expandselected-tree";
var templateTree = "template/categoryTree.ejs";
var callbackTableInit = "productTableInit";
var callbackTable = "productTable";
var templateTable = "template/productTable.ejs";

$(document).ready(function(){
    initTreeLoad(current_cat_id);
    
    $("[name='displayed']").bootstrapSwitch();
    
    $("[name='description']").summernote({
        height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });
    
    $(document).on('click','.tree-folder-name', function(e) {
        openFolder(e, $(this));
    });
});
/*
function initLoad(id){
    var obj = new Object();
    obj.id = id; 
    callbackName = "product-expandselected-tree";
    callAjax(obj, urlExpandAll, callbackName); 
}

function openFolderWithId(e, id){
    
    var thisOne = $(".tree-folder-name[catid='"+id+"']");
    var id_parent = thisOne.find('input[name="parent_category"]').val();
    if (id_parent == undefined){
        return;
    }
    thisOne.siblings('.tree').remove();
    var id = thisOne.attr('catid');
    var obj = new Object();
    obj.parent_category = id_parent;
    obj.id = id;  
    obj.current_cat_id = current_cat_id;

    if (id == current_cat_id){
        return;
    }
    callbackName = "category-tree";
    callAjaxWithThis(obj, url, callbackName, thisOne);
}

function openFolder(e, thisOne){
    if($(e.target).is(':input')){
        return;
    } 
    
    if (thisOne.siblings('.tree').is(':visible')){
        thisOne.children('i').toggleClass('fa-folder-open fa-folder');
        thisOne.siblings('.tree');
        thisOne.siblings('.tree').hide('fast');
    } else {
        thisOne.siblings('.tree').remove();
        var id_parent = thisOne.find('input[name="parent_category"]').val();
        var id = thisOne.attr('catid');
        var obj = new Object();
        obj.parent_category = id_parent;
        obj.id = id;    
        obj.current_cat_id = current_cat_id;

        callbackName = "category-tree";
        callAjaxWithThis(obj, url, callbackName, thisOne);
    }
}

function callback(name, data, thisOne) {
    if (name == 'category-tree'){   
        //alert(JSON.stringify(data));
        var content = new EJS({url: basePath+'template/categoryTree.ejs'}).render(data);
        thisOne.parent().append(content);
        thisOne.find('.fa').toggleClass('fa-folder fa-folder-open');
        openFolderWithId(this.event, expandselectedTree[++currentArrIndex]);
    } else if (name = 'product-expandselected-tree'){
        data.current_cat_id = current_cat_id;
        expandselectedTree = data;
        openFolderWithId(this.event, "");
    }
}*/
</script>
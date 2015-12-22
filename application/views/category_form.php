<div class="row">
    <div class="col-lg-6">

        <ul class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-container">
                <a href="<?php echo site_url('product') ?>">Catalog</a>				
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('category') ?>">Categories</a>
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
<?php echo form_open('category/category_edit', $formAttributes); ?>
        <div class="card">
            <div class="card-head style-primary">
                <header>Create a category</header>
            </div>
            <div class="card-body floating-label">
                
                <div class="form-group">
                    <?php echo form_label('Parent Category', 'parent_category', $labelAttributes); ?>
                    <div class=" col-sm-10">
                        <ul id="categories-tree" class="tree">
                            <li class="tree-folder" catid="0">
                                <span class="tree-folder-name tree-selected">
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
                        <?php echo form_input('name', $category->name, $inputAttributes); ?><div class="form-control-line"></div>
                    </div>
                </div> 
              <div class="form-group">
                    <?php echo form_label('Description', 'description', $labelAttributes); ?>
                    <div class="col-sm-10">                        
                        <?php echo form_textarea('description', $category->description, $inputAttributes); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo form_label('Display Category', 'displayed', $labelAttributes); ?>
                    <?php echo form_checkbox('displayed', 'true', $category->displayed);?>
                    <?php echo form_hidden('id', $category->id);?>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 text-left">
                        <a href="<?php echo site_url('category/category_view/'. $category->parent_category .'/') ?>" class="btn btn-primary ink-reaction">Cancel</a>
                    </div>
                    <div class="col-lg-6 text-right">
                        <button type="submit" class="btn btn-primary ink-reaction"><?php echo (isset($category->id)?"Update category":"Create category"); ?></button>
                    </div>
                </div>
            </div><!--end .card-body -->
            
        </div><!--end .card -->
    <?php echo form_close(); ?>
</div>
<script>
var basePath = "<?php echo site_url('')?>";
var currentCategoryId = <?php echo $parentId?>;
var parentId = <?php echo $id?>;
var urlExpandAll = basePath+"category/ajax_expandselected_tree";
var urlTree = basePath+"category/ajax_tree";
var callbackTree = "category-tree";
var callbackSingleLevelTree = "category-single-level-tree";
var callbackExpandselectedTree = "category-expandselected-tree";
var templateTree = basePath+"template/categoryTree.ejs";

$(document).ready(function(){
    
    var tree = new Tree(currentCategoryId,parentId);
    tree.init(currentCategoryId, urlExpandAll, urlTree, callbackTree, callbackExpandselectedTree, callbackSingleLevelTree, templateTree);
    tree.callTreeAjax(urlExpandAll, callbackExpandselectedTree);
    
    $(document).on('click','.tree-folder-name', function(e) {
        var currentCategoryId = $(this).closest('li.tree-folder').attr('catid');
        tree.openFolderSingleLevel(currentCategoryId);
    });
    
    $("[name='displayed']").bootstrapSwitch();
    
    $("[name='description']").summernote({
        height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    });
    
    
});

</script>

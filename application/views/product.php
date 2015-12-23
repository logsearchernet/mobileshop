
    
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
    <div class="col-lg-6">
        <div class="btn-toolbar">
            <a href="#" class="toolbar_btn dropdown-toolbar navbar-toggle" data-toggle="collapse" data-target="#toolbar-nav"><i class="process-icon-dropdown"></i><div>Menu</div></a>
            <ul id="toolbar-nav" class="nav nav-pills pull-right collapse navbar-collapse">
                <li>
                    <a class="toolbar_btn  pointer text-center" href="<?php echo site_url('product/product_form/0/'. $category_id .'/') ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                        <div>Add new product</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

<div class="row">
    <div class="form-group">
        <div class=" col-sm-10">
            <div>Category Tree</div>
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
</div>

<div class="card card-underline">
    <div class="card-head"><header>Products<sup class="badge"><?php echo $count?></sup></header></div>
    <form class="form">
        <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 5%;">&nbsp;</th>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">
                    Name
                    <span class="sort-col" orderby="name" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="name" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
                <th style="width: 20%;">
                    Category
                </th>
                <th style="width: 10%;">
                    Price
                    <span class="sort-col" orderby="price" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="price" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
                <th style="width: 10%;">
                    Quantity
                    <span class="sort-col" orderby="quantity" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="quantity" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
                <th style="width: 5%;">
                    Position
                    <span class="sort-col" orderby="position" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="position" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
                <th style="width: 5%;">
                    Displayed
                </th>
            </tr>
            <tr class="style-default-light">
                <th></th>
                <th></th>
                <th>
                    <div class="row input-outer"> 
                        <input type="text" class="filterColumn" id="name" autocomplete="off">
                        <i class="fa fa-close filter-clear"></i>
                    </div>
                </th>
                <th>
                </th>
                <th>
                    <div class="row input-outer"> 
                        <input type="text" class="filterColumn" id="price" autocomplete="off">
                        <i class="fa fa-close filter-clear"></i>
                    </div>
                </th>
                <th>
                    <div class="row input-outer"> 
                        <input type="text" class="filterColumn" id="quantity" autocomplete="off">
                        <i class="fa fa-close filter-clear"></i>
                    </div>
                </th>
                <th>
                </th>
                <th>
                    <div class="row input-outer"> 
                        <select class="form-control filterColumn" id="displayed">
                            <option value="">---  All  ---</option>
                            <option value="1"> ON </option>
                            <option value="0"> OFF </option>
                        </select> 
                    </div>
                </th>
            </tr>
        </thead>
        <tbody id="table-render">
            <!-- LOAD AJAX With CONTENT -->
        </tbody>
    </table>
    </form>
    <div class="row">
        <div class="col-lg-6">
            <div class="btn-group dropup">
                <button type="button" class="btn ink-reaction btn-default-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Bulk action <i class="fa fa-caret-up text-default-light"></i>
                </button>
                <ul class="dropdown-menu animation-expand" role="menu">
                    <li><a href="#" id="selectAll">Select all</a></li>
                    <li><a href="#" id="unselectAll">Unselect all</a></li>
                    <li class="divider"></li>
                    <li><a href="#" id="removeChecked"><i class="fa fa-fw fa-times text-danger"></i> Remove</a></li>
                </ul>
            </div>											
        </div>
    </div>
    <div id="page-selection"></div>
    <div class="card-body"></div>
</div>
<div id="show-sql"></div>
<div id="alert-status-updated" class="alert alert-success hidden">
    <i class="fa fa-check-circle"> </i> The status has been updated successfully
</div>

<div id="alert-updated" class="alert alert-success hidden">
    <i class="fa fa-check-circle"> </i> Successful update
</div>


<div id="alert-fail" class="alert alert-danger hidden">
    <i class="fa fa-check-circle"> </i> Failed update
</div>
<script>
// Begin Catelogy Tree    
var basePath = "<?php echo site_url('')?>";
var currentCategoryId = <?php echo $category_id?>;
var urlExpandAll = basePath+"category/ajax_expandselected_tree";
var urlTree = basePath+"category/ajax_tree";
var callbackTree = "category-tree";
var callbackSingleLevelTree = "category-single-level-tree";
var callbackExpandselectedTree = "category-expandselected-tree";
var templateTree = basePath+"template/categoryTree.ejs";
// End Catelogy Tree  

var urlRenderTable = basePath+"product/ajax_product_table";
var updateSortPosition = basePath+"product/ajax_product_sort_position";
var offset = 0;
var totalCount = <?php echo $count?>;
var limit = <?php echo $limit?>;
var parent = <?php echo $category_id?>;
var current_cat_id = 0;
var expandselectedTree;
var currentArrIndex = 0;
var callbackTree = "category-tree";
var callbackExpandselectedTree = "category-expandselected-tree";
var callbackTableInit = "productTableInit";
var callbackTable = "productTable";
var templateTable = basePath+"template/productTable.ejs";
var urlDisplay = basePath+"product/ajax_product_displayed";

$(document).ready(function(){
    
    var tree = new Tree(currentCategoryId,0);
    tree.init(currentCategoryId, urlExpandAll, urlTree, callbackTree, callbackExpandselectedTree, callbackSingleLevelTree, templateTree);
    tree.callTreeAjax(urlExpandAll, callbackExpandselectedTree);
    
    $(document).on('click','.tree-folder-name', function(e) {
        var currentCategoryId = $(this).closest('li.tree-folder').attr('catid');
        tree.openFolderSingleLevel(currentCategoryId);
    });
    $(window).load(function(){
        
        var success = '<?php echo $success?>';
        
        var table = new Table('', '', parent, '', '', '', '', '');
        table.init(urlRenderTable, updateSortPosition,urlDisplay, callbackTableInit, callbackTable, templateTable);
        table.renderTable(success);
        table.doSortTableRow();
        $('.filter-clear').hide();
    });
    
    $(document).on('click','input[name="parent_category"]', function(e) {
        var table = new Table('', '', $(this).val(), '', '', '', '', '');
        table.init(urlRenderTable, updateSortPosition,urlDisplay, callbackTableInit, callbackTable, templateTable);
        table.renderTable(0);
        
        parent = $(this).val();
        $('.toolbar_btn').attr('href', basePath+'product/product_form/0/'+$(this).val());
    });
    
    $(document).on('click','.sort-col', function(e) {
        var orderby = $(this).attr('orderby');
        var orderway = $(this).attr('orderway');
        offset = (offset!= 0 && (offset%limit)==0)?(offset - limit):offset;
        var filter = "";
        var filterName = "";
        var deleteItems = "";
        var displayed = "";
        var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed)
        
        table.callAjax(urlRenderTable, callbackTable);
    });
    
    $(document).on('keyup','.filterColumn', function(e) {
        if ($(this).val() != ''){
            $(this).siblings('.filter-clear').show();
        } else {
            $(this).siblings('.filter-clear').hide();
        }
        
        Table.prototype.filterByName(e, parent);
    });
    
    $( "#displayed").change(function(e) {
        Table.prototype.filterByName(e, parent);
    });
    
    $(document).on('click','.filter-clear', function(e) {
        $(this).siblings('.filterColumn').val('');
        $(this).hide();
        Table.prototype.filterByName(e, parent);
        
    });
    
    $(document).on('click','#selectAll', function(e) {
        $(':checkbox.checkItem').each(function(){
            $(this).attr('checked', 'checked');
        }); 
    });
    
    $(document).on('click','#unselectAll', function(e) {
        $(':checkbox.checkItem').each(function(){
            $(this).removeAttr('checked');
        }); 
    });
    
    $(document).on('click','.submitdelete', function(e) {
        var deleteItems = $(this).attr('id');
        offset = (offset!= 0 && (offset%limit)==0)?(offset - limit):offset;
        var orderby = '';
        var orderway = '';
        var filter = "";
        var filterName = "";
        var displayed = '';
        var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
        var callbackName = callbackTable;
        table.callAjax(urlRenderTable, callbackName);
    });
    
    $(document).on('click','#removeChecked', function(e) {
        var deleteItems = "";
        var total = $(':checkbox.checkItem').length;
        var totalDel = 0;
        $(':checkbox.checkItem').each(function(index){
            if ($(this).is(':checked')) {
                deleteItems += ($(this).val());
                totalDel++;
            }
            if (index != total - 1){
                deleteItems += "|";
            }
        }); 
        
        offset = (offset!= 0 && (offset%limit)==0)?(offset - limit):offset;
        
        var orderby = '';
        var orderway = '';
        var filter = "";
        var filterName = "";
        var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
        var callbackName = callbackTable;
        table.callAjax(urlRenderTable, callbackName);
    });
});

</script>
  
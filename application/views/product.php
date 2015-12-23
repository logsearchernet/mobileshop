
    
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


<ul class="breadcrumb">
    <li>
        <a href="<?php echo site_url('/product/product_view/');?>"><i class="fa fa-home"></i>Home</a>
    </li>
    <?php if (isset($productNames)): ?>
    <?php foreach ($productNames as $id => $name):?>
    <li>
        <a href="<?php echo site_url('/product/product_view/'. $id); ?>"><?php echo $name;?></a>
    </li>
    <?php endforeach;?>
    <?php endif; ?>
</ul>

<div class="row">
    <div class="form-group">
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
</div>

<div class="card card-underline">
    <div class="card-head"><header>Products<sup class="badge"><?php echo $count?></sup></header></div>
    <form class="form">
        <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 10%;">&nbsp;</th>
                <th style="width: 10%;">#</th>
                <th style="width: 30%;">Name</th>
                <th style="width: 30%;">Category</th>
                <th style="width: 30%;">Price</th>
                <th style="width: 30%;">Quantity</th>
                <th style="width: 10%;">Displayed</th>
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
    /*
    $(window).load(function(){
        var success = '<?php echo $success?>';
        var callbackName = callbackTableInit;
        if (success == 1){
            callbackName = callbackTable;
        }
        renderTable(urlRenderTable, callbackName);
        $('.filter-clear').hide();
    });
    
    $(document).on('click','.tree-folder-name', function(e) {
        openFolder(e, $(this));
    });
    
    $(document).on('keyup','.filterColumn', function(e) {
        if ($(this).val() != ''){
            $(this).siblings('.filter-clear').show();
        } else {
            $(this).siblings('.filter-clear').hide();
        }
        
        filterByName(e);
    });
    
    $( "#displayed").change(function(e) {
        filterByName(e);
    });
    
    $(document).on('click','.filter-clear', function(e) {
        $(this).siblings('.filterColumn').val('');
        $(this).hide();
        filterByName(e);
        
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
        var obj = new Object();
        offset = (offset!= 0 && (offset%limit)==0)?(offset - limit):offset;
        obj.categoryid = "";
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "productTable";
        callAjax(obj, url, callbackName);
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
        var obj = new Object();
        obj.categoryid = "";
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "productTable";
        callAjax(obj, url, callbackName);
    });
        */
    
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
    callAjaxWithThis(obj, urlTree, callbackName, thisOne);
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
        callAjaxWithThis(obj, urlTree, callbackName, thisOne);
    }
}

function renderTable(success){
    var callbackName = "productTableInit";
    if (success == 1){
        callbackName = "productTable";
    }
    var obj = new Object();
    obj.categoryid = categoryid;
    obj.offset = 0;
    obj.filter = "";
    obj.filterName = "";
    obj.deleteItems = "";
    callAjax(obj, url, callbackName);
}
function callback(name, data, thisOne) {
    if (name == 'productTableInit'){
        var content = new EJS({url: basePath+'template/productTable.ejs'}).render(data);
        $("#product-table").html(content);
         $('.badge').html(data.data.length);
           
        if (limit > 0) {
            $('#page-selection').bootpag({
                total: Math.ceil(data.totalCount / limit),
                maxVisible: 5,
                page: (offset / limit) + 1
            }).on("page", function(event,num){
                $('#alert-updated').hide();
                var obj = new Object();
                offset = (num - 1) * limit;
                obj.categoryid = "";
                obj.offset = offset;
                obj.filter = "";
                obj.filterName = "";
                obj.deleteItems = "";
                var callbackName = "productTableInit";
                callAjax(obj, url, callbackName);
            });
        }
    } else if (name == 'productTable') {
        var content = new EJS({url: basePath+'template/productTable.ejs'}).render(data);
        $("#product-table").html(content); 
        $('#alert-updated').removeClass("hidden");
        $('#alert-updated').fadeIn(500);
        $('#alert-updated').fadeOut(3000);
        $('.badge').html(data.data.length);
        
        if (limit > 0) {
            $('#page-selection').bootpag({
                total: Math.ceil(data.totalCount / limit),
                maxVisible: 5,
                page: (offset / limit) + 1
            }).on("page", function(event,num){
                $('#alert-updated').hide();
                var obj = new Object();
                offset = (num - 1) * limit;
                obj.categoryid = "";
                obj.offset = offset;
                obj.filter = "";
                obj.filterName = "";
                obj.deleteItems = "";
                var callbackName = "productTableInit";
                callAjax(obj, url, callbackName);
            });
        }
    } else if (name == 'productDisplay'){
        $('#alert-status-updated').removeClass("hidden");
        $('#alert-status-updated').fadeIn(500);
        $('#alert-status-updated').fadeOut(3000);
    } else if (name == 'updateSortPosition') {
        //alert(JSON.stringify(data));
        renderTable(1);
    } else if (name == 'category-tree'){   
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
}

var requestDelay;
var proname;

function filterByName(e){

    var thisProname = "";
    var filterName = "";
    var total = $('.filterColumn').length;
    $('.filterColumn').each(function(index){
        thisProname += $(this).val();
        filterName +=  $(this).attr('id');
        if (index != total - 1){
            thisProname += "|";
            filterName += "|";
        }
    });

    if(e.which == 13 || thisProname == proname) {
          return;
    }

   proname = thisProname;

   // postpone the submit another 300 ms upon every new character
   window.clearTimeout(requestDelay);  

   requestDelay = window.setTimeout(function() {
        var obj = new Object();
        obj.categoryid = "";
        obj.offset = offset;
        obj.filter = proname;
        obj.filterName = filterName;
        obj.deleteItems = "";
        var callbackName = "productTable";
        callAjax(obj, url, callbackName)
   }, 500);
}

*/


</script>
  
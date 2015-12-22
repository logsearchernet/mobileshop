<div class="row">
    <div class="col-lg-6">

        <ul class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-container">
                <a href="<?php echo site_url('product') ?>">Catalog</a>				
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('product_attribute_group') ?>">Product Attributes</a>
            </li>
        </ul>
    </div>
    <div class="col-lg-6">
        <div class="btn-toolbar">
            <a href="#" class="toolbar_btn dropdown-toolbar navbar-toggle" data-toggle="collapse" data-target="#toolbar-nav"><i class="process-icon-dropdown"></i><div>Menu</div></a>
            <ul id="toolbar-nav" class="nav nav-pills pull-right collapse navbar-collapse">
                <li>
                    <a class="toolbar_btn  pointer text-center" href="<?php echo site_url('product_attribute_child/attribute_child_form/0/'. $parentId) ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                        <div>Add new value</div>
                    </a>
                </li>   
            </ul>
        </div>
    </div>

</div>




<div class="card card-underline">
    <div class="card-head"><header>Product Attribute Values<sup class="badge"><?php echo $count?></sup></header></div>
    <form class="form">
        <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 10%;">&nbsp;</th>
                <th style="width: 10%;">#</th>
                <th style="width: 70%;">
                    Value
                    <span class="sort-col" orderby="value" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="value" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
                <th style="width: 10%;">
                    Position
                    <span class="sort-col" orderby="position" orderway="asc"><i class="fa fa-caret-up"></i></span>
                    <span class="sort-col"  orderby="position" orderway="desc"><i class="fa fa-caret-down"></i></span>
                </th>
            </tr>
            <tr class="style-default-light">
                <th></th>
                <th></th>
                <th>
                    <div class="row input-outer"> 
                        <input type="text" class="filterColumn" id="value" autocomplete="off">
                        <i class="fa fa-close filter-clear"></i>
                    </div>
                </th>
                <th>
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
var basePath = "<?php echo site_url('')?>";
var urlRenderTable = basePath+"product_attribute_child/ajax_attribute_child_table";
var updateSortPosition = basePath+"product_attribute_child/ajax_attribute_child_sort_position";
var offset = 0;
var totalCount = <?php echo $count?>;
var limit = <?php echo $limit?>;
var parent = <?php echo $parentId?>;
var callbackTableInit = "attributeChildTableInit";
var callbackTable = "attributeChildTable";
var templateTable = basePath+"template/attributeChildTable.ejs";
var urlDisplay = "";
$(document).ready(function(){
    
    $(window).load(function(){
        
        var success = '<?php echo $success?>';
        
        var table = new Table('', '', parent, '', '', '', '', '');
        table.init(urlRenderTable, updateSortPosition,urlDisplay, callbackTableInit, callbackTable, templateTable);
        table.renderTable(success);
        table.doSortTableRow();
        $('.filter-clear').hide();
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
        var displayed = "";
        var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
        var callbackName = callbackTable;
        table.callAjax(urlRenderTable, callbackName);
    });
    
});

</script>
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
                    <a class="toolbar_btn  pointer text-center" href="<?php echo site_url('product_attribute_group/attribute_group_form') ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                        <div>Add new attribute</div>
                    </a>
                </li> 
                <li>
                    <a class="toolbar_btn  pointer text-center" href="<?php echo site_url('product_attribute_child/attribute_child_form') ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                        <div>Add new value</div>
                    </a>
                </li> 
            </ul>
        </div>
    </div>

</div>




<div class="card card-underline">
    <div class="card-head"><header>Product Attributes<sup class="badge"><?php echo $count?></sup></header></div>
    <form class="form">
        <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 10%;">&nbsp;</th>
                <th style="width: 10%;">#</th>
                <th style="width: 70%;">Name</th>
                <th style="width: 10%;">Position</th>
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
            </tr>
        </thead>
        <tbody id="attribute-table">
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
var url = basePath+"product_attribute_group/ajax_attribute_group_table";
var updateSortPosition = basePath+"product_attribute_group/ajax_attribute_group_sort_position";
var offset = 0;
var totalCount = <?php echo $count?>;
var limit = <?php echo $limit?>;
var parent = 0;;
$(document).ready(function(){
    
    $(window).load(function(){
        
        var success = '<?php echo $success?>';
        renderTable(success);
        $('.filter-clear').hide();
    });
    
    $(document).on('keyup','.filterColumn', function(e) {
        if ($(this).val() != ''){
            $(this).siblings('.filter-clear').show();
        } else {
            $(this).siblings('.filter-clear').hide();
        }
        
        filterByName(e, parent);
    });
    
    $(document).on('click','.filter-clear', function(e) {
        $(this).siblings('.filterColumn').val('');
        $(this).hide();
        filterByName(e, parent);
        
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
        obj.parent = parent;
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "attributeGroupTable";
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
        obj.parent = parent;
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "attributeGroupTable";
        callAjax(obj, url, callbackName);
    });
});

function renderTable(success){
    var callbackName = "attributeGroupTableInit";
    if (success == 1){
        callbackName = "attributeGroupTable";
    }
    var obj = new Object();
    obj.offset = 0;
    obj.filter = "";
    obj.filterName = "";
    obj.deleteItems = "";
    callAjax(obj, url, callbackName);
}

function callback(name, data) {
    if (name == 'attributeGroupTableInit'){
        var content = new EJS({url: basePath+'template/attributeGroupTable.ejs'}).render(data);
        $("#attribute-table").html(content);
        
        $('#page-selection').bootpag({
            total: Math.ceil(data.totalCount / limit),
            maxVisible: 5,
            page: (offset / limit) + 1
        }).on("page", function(event,num){
            $('#alert-updated').hide();
            var obj = new Object();
            offset = (num - 1) * limit;
            obj.parent = parent;
            obj.offset = offset;
            obj.filter = "";
            obj.filterName = "";
            obj.deleteItems = "";
            var callbackName = "attributeTableInit";
            callAjax(obj, url, callbackName);
        });
    } else if (name == 'attributeGroupTable'){
        var content = new EJS({url: basePath+'template/attributeGroupTable.ejs'}).render(data);
        $("#attribute-table").html(content); 
        $('#alert-updated').removeClass("hidden");
        $('#alert-updated').fadeIn(500);
        $('#alert-updated').fadeOut(3000);
        
        $('#page-selection').bootpag({
            total: Math.ceil(data.totalCount / limit),
            maxVisible: 5,
            page: (offset / limit) + 1
        }).on("page", function(event,num){
            $('#alert-updated').hide();
            var obj = new Object();
            offset = (num - 1) * limit;
            obj.parent = parent;
            obj.offset = offset;
            obj.filter = "";
            obj.filterName = "";
            obj.deleteItems = "";
            var callbackName = "attributeTableInit";
            callAjax(obj, url, callbackName);
        });
    }
}

var requestDelay;
var proname;

function filterByName(e, parent){

    var thisProname = "";
    var filterName = "";
    var parentId = parent;
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
        obj.parent = parentId;
        obj.offset = offset;
        obj.filter = proname;
        obj.filterName = filterName;
        obj.deleteItems = "";
        var callbackName = "attributeGroupTable";
        callAjax(obj, url, callbackName)
   }, 500);
}
</script>
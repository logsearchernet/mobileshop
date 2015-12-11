
<div class="row">
    <div class="col-lg-4">

        <ul class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-container">
                <a href="<?php echo site_url('product') ?>">Catalog</a>				
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('category/category') ?>">Categories</a>
            </li>
        </ul>
    </div>
    <div class="col-lg-4">
        <div id="ajax-message" class="alert alert-success">
        <i class="fa fa-check-circle"> </i> The status has been updated successfully
    </div>
    </div>
    <div class="col-lg-4">
        <div class="btn-toolbar">
            <a href="#" class="toolbar_btn dropdown-toolbar navbar-toggle" data-toggle="collapse" data-target="#toolbar-nav"><i class="process-icon-dropdown"></i><div>Menu</div></a>
            <ul id="toolbar-nav" class="nav nav-pills pull-right collapse navbar-collapse">
                <li>
                    <a class="toolbar_btn  pointer text-center" href="<?php echo site_url('category/category_form') ?>">
                        <i class="fa fa-plus-circle fa-2x"></i>
                        <div>Add new category</div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>

    

    <div id="alert-success" class="alert alert-success">
        <i class="fa fa-check-circle"> </i> Successful update
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>


    <div id="alert-fail" class="alert alert-danger">
        <i class="fa fa-check-circle"> </i> Failed update
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>



<div class="card card-underline">
    <div class="card-head"><header>Categories<sup class="badge"><?php echo $count?></sup></header></div>
    <form class="form">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 10px;">&nbsp;</th>
                <th style="width: 70px;">#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Position</th>
                <th>Displayed</th>
            </tr>
            <tr class="style-default-light">
                <th><button id="clearFilter" class="btn btn-default">Clear</button></th>
                <th>
                    <input type="text" class="form-control clearfix filterColumn" id="id">
                </th>
                <th>
                    <input type="text" class="form-control clearfix filterColumn" id="name">
                </th>
                <th>
                    <input type="text" class="form-control clearfix filterColumn" id="description">
                </th>
                <th>
                    <input type="text" class="form-control clearfix filterColumn" id="position">
                </th>
                <th>
                    <select class="form-control clearfix filterColumn" id="displayed">
                        <option value="">---  All  ---</option>
                        <option value="1"> ON </option>
                        <option value="0"> OFF </option>
                    </select>  
                </th>
            </tr>
        </thead>
        <tbody id="categoryTable">
            
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
<script>
var basePath = "<?php echo site_url('')?>";
var url = basePath+"category/ajax_category_table";
var offset = 0;

$(document).ready(function(){
    
    
    
    
    $(window).load(function(){
        $('#ajax-message').hide();
        $('#alert-success').hide();
        $('#alert-fail').hide();
        
        var callbackName = "categoryTableInit";
        var obj = new Object();
        obj.offset = 0;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = "";
        callAjax(obj, url, callbackName);
    });
    
    
    
    $('#page-selection').bootpag({
        total: Math.ceil(<?php echo $count?> / <?php echo $limit?>),
        maxVisible: 5
    }).on("page", function(event,num){
        $('.alert-success').hide();
        var obj = new Object();
        offset = (num - 1) * <?php echo $limit?>;
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = "";
        callAjax(obj, url, callbackName);
    });
    
    $(document).on('keyup','.filterColumn', function(e) {
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
        filterByName(e, filterName, thisProname)
    });
    
    $( "#displayed").change(function(e) {
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
        filterByName(e, filterName, thisProname)
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
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "categoryTable";
        callAjax(obj, url, callbackName);
    });
    
    $(document).on('click','#removeChecked', function(e) {
        var deleteItems = "";
        var total = $(':checkbox.checkItem').length;
        $(':checkbox.checkItem').each(function(index){
            if ($(this).is(':checked')) {
                deleteItems += ($(this).val());
            }
            if (index != total - 1){
                deleteItems += "|";
            }
        }); 
        var obj = new Object();
        obj.offset = offset;
        obj.filter = "";
        obj.filterName = "";
        obj.deleteItems = deleteItems;
        var callbackName = "categoryTable";
        callAjax(obj, url, callbackName);
    });
        
    $('#clearFilter').click(function (){
        $('.filterColumn').val('');
    });
});
function callback(name, data) {
    if (name == 'categoryTableInit'){
        var content = new EJS({url: basePath+'template/categoryTable.ejs'}).render(data);
        $("#categoryTable").html(content);
    } else if (name == 'categoryTable') {
        var content = new EJS({url: basePath+'template/categoryTable.ejs'}).render(data);
        $("#categoryTable").html(content); 
        $('#alert-success').fadeIn(1000);
        $('#alert-success').fadeOut(3000);
    } else if (name == 'categoryDisplay'){
        $('#ajax-message').fadeIn(1000);
        $('#ajax-message').fadeOut(2000);
    }

}

var requestDelay;
var proname;
function filterByName(e, filterName, thisProname, proname){
    if(e.which == 13 || thisProname == proname) {
          return;
    }

   proname = thisProname;

   // postpone the submit another 300 ms upon every new character
   window.clearTimeout(requestDelay);  

   requestDelay = window.setTimeout(function() {
        var obj = new Object();
        obj.offset = offset;
        obj.filter = proname;
        obj.filterName = filterName;
        obj.deleteItems = "";
        var callbackName = "categoryTable";
        callAjax(obj, url, callbackName)
   }, 500);
}
</script>
  

$(document).ready(function(){
    jQuery.ajaxSetup({
        beforeSend: function(){
            displayLoadIndc();
        },
        complete: function(){
            hideLoadIndc();
        },
        success: function(){
        }
    });
    
    
    
});

/*
var timeoutSetting = 70000;

function callAjax(obj, urlAjax, callbackName) {
	var input = JSON.stringify(obj);
	return $.ajax({
        type: "POST",
        url: urlAjax,
        data: input,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        timeout: timeoutSetting,
        success: function(data){
            callback(callbackName, data);
        },
        failure: function(errMsg) {
            alert("Falure:"+errMsg);
        },
        error: function (xhr, textStatus, errorThrown){
            alert("Error:"+textStatus);
        }
  });
}

function callAjaxWithThis(obj, urlAjax, callbackName, thisOne) {
	var input = JSON.stringify(obj);
	return $.ajax({
        type: "POST",
        url: urlAjax,
        data: input,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        timeout: timeoutSetting,
        success: function(data){
            callbackThis(callbackName, data, thisOne);
        },
        failure: function(errMsg) {
            alert("Falure:"+errMsg);
        },
        error: function (xhr, textStatus, errorThrown){
            alert("Error:"+textStatus);
        }
  });
}



function renderTable(urlRenderTable, callbackName, parent){
    var obj = new Object();
    obj.orderby = '';
    obj.orderway = '';
    obj.parent = parent;
    obj.offset = 0;
    obj.filter = "";
    obj.filterName = "";
    obj.deleteItems = "";
    callAjax(obj, urlRenderTable, callbackName);
}
function callback(name, data) {
    if (name == callbackTableInit){
        var content = new EJS({url: basePath+templateTable}).render(data);
        $("#table-render").html(content);
         
           
        if (limit > 0) {
            $('#page-selection').bootpag({
                total: Math.ceil(data.totalCount / limit),
                maxVisible: 5,
                page: (offset / limit) + 1
            }).on("page", function(event,num){
                $('#alert-updated').hide();
                var obj = new Object();
                offset = (num - 1) * limit;
                obj.orderby = '';
                obj.orderway = '';
                obj.parent = parent;
                obj.offset = offset;
                obj.filter = "";
                obj.filterName = "";
                obj.deleteItems = "";
                var callbackName = callbackTableInit;
                callAjax(obj, urlRenderTable, callbackName);
            });
        }
    } else if (name == callbackTable) {
        var content = new EJS({url: basePath+templateTable}).render(data);
        $("#table-render").html(content); 
        $('#alert-updated').removeClass("hidden");
        $('#alert-updated').fadeIn(500);
        $('#alert-updated').fadeOut(3000);
        
        if (limit > 0) {
            $('#page-selection').bootpag({
                total: Math.ceil(data.totalCount / limit),
                maxVisible: 5,
                page: (offset / limit) + 1
            }).on("page", function(event,num){
                $('#alert-updated').hide();
                var obj = new Object();
                offset = (num - 1) * limit;
                obj.orderby = '';
                obj.orderway = '';
                obj.parent = parent;
                obj.offset = offset;
                obj.filter = "";
                obj.filterName = "";
                obj.deleteItems = "";
                var callbackName = callbackTableInit;
                callAjax(obj, urlRenderTable, callbackName);
            });
        }
    } else if (name == 'statusDisplay'){
        $('#alert-status-updated').removeClass("hidden");
        $('#alert-status-updated').fadeIn(500);
        $('#alert-status-updated').fadeOut(3000);
    } else if (name == 'updateSortPosition') {
        //alert(JSON.stringify(data));
        //renderTable(urlRenderTable, callbackName);
        //renderTable(urlRenderTable,);
    } else if (name = callbackExpandselectedTree){
        data.current_cat_id = current_cat_id;
        expandselectedTree = data;
        openFolderWithId(this.event, "");
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
        if (  != total - 1){
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
        obj.orderby = '';
        obj.orderway = '';
        obj.parent = parentId;
        obj.offset = offset;
        obj.filter = proname;
        obj.filterName = filterName;
        obj.deleteItems = "";
        var callbackName = callbackTable;
        callAjax(obj, urlRenderTable, callbackName)
   }, 500);
}
*/
function hideLoadIndc() {
    
    //$('#busy_indicator').hide( "scale", { direction: "center" }, "slow" );
    $('#content').addClass('animated bounce');
    setTimeout(function(){
        document.getElementById('busy_indicator').style.visibility = 'hidden';
    }, 200 );
	
}
function displayLoadIndc() {
    //$('#busy_indicator').show();
    document.getElementById('busy_indicator').style.visibility = 'visible';
}

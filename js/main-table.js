var urlRenderTable, updateSortPosition, urlDisplay, callbackTableInit, callbackTable, templateTable;
var requestDelay;
var proname;

function Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed) {
    this.orderby = orderby;
    this.orderway = orderway;
    this.parent = parent;
    this.offset = offset;
    this.filter = filter;
    this.filterName = filterName;
    this.deleteItems = deleteItems;
    this.displayed = displayed;
}

Table.prototype =
    {
        constructor: Tree,
        init: function(urlRenderTable, updateSortPosition, urlDisplay, callbackTableInit, callbackTable, templateTable){
            urlRenderTable = urlRenderTable;
            updateSortPosition = updateSortPosition;
            callbackTableInit = callbackTableInit;
            callbackTable = callbackTable;
            templateTable = templateTable;
            urlDisplay = urlDisplay;
        },
        
        renderTable: function(success){
            var callbackName = callbackTableInit;
            if (success == 1){
                callbackName = callbackTable;
            }
            this.callAjax(urlRenderTable, callbackName);
        },
        filterByName: function(e, parent){
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
                var orderby = '';
                var orderway = '';
                var filter = proname;
                var deleteItems = "";
                var displayed = "";
                var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
                var callbackName = callbackTable;
                table.callAjax(urlRenderTable, callbackName)
           }, 500);
        },
        doSortTableRow: function(){
            $("#table-render").sortable({
                handle:'button.move-row',
                helper: fixWidthHelper,
                cancel: '',
                update: function(event, ui) {
                    var newProps = new Array(0);
                    $('.iedit').each(function(i) { 
                        var sortNum = $(this).find('button.move-row').val();
                        var categoryid = $(this).find('button.move-row').attr('categoryid');

                        var obj = new Object();
                        obj.categoryid = categoryid;
                        obj.sortNum = sortNum;

                        newProps.push(obj);
                    });

                    var callbackName = "updateSortPosition";
                    Table.prototype.callAjaxTableEjs(newProps, updateSortPosition, callbackName);
                }
            });
        },
        
        callAjaxTableEjs: function(obj, urlAjax, name){
                var input = JSON.stringify(obj);
                $.ajax({
                type: "POST",
                url: urlAjax,
                data: input,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    if (name == 'statusDisplay'){
                        $('#alert-status-updated').removeClass("hidden");
                        $('#alert-status-updated').fadeIn(500);
                        $('#alert-status-updated').fadeOut(3000);
                    } else if (name == 'updateSortPosition') {
                        
                    }
                },
                failure: function(errMsg) {
                    alert("Falure:"+errMsg);
                },
                error: function (xhr, textStatus, errorThrown){
                    alert("Error:"+textStatus);
                }
            });
        },
        
        callAjax: function(urlAjax, name){
            var input = JSON.stringify(this);
            $.ajax({
                type: "POST",
                url: urlAjax,
                data: input,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    $('.badge').html(data.data.length);
                    if (name == callbackTableInit){
                        var content = new EJS({url: templateTable}).render(data);
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
                                var orderby = '';
                                var orderway = '';
                                var parent = parent;
                                var offset = offset;
                                var filter = "";
                                var filterName = "";
                                var deleteItems = "";
                                var displayed = displayed;
                                var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
                                var callbackName = callbackTableInit;
                                table.callAjax(urlRenderTable, callbackName);
                            });
                        }
                        $("input.displayed").bootstrapSwitch();
                    } else if (name == callbackTable) {
                        var content = new EJS({url: templateTable}).render(data);
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
                                var orderby = '';
                                var orderway = '';
                                var parent = parent;
                                var offset = offset;
                                var filter = "";
                                var filterName = "";
                                var deleteItems = "";
                                var displayed = displayed;
                                var table = new Table(orderby, orderway, parent, offset, filter, filterName, deleteItems, displayed);
                                var callbackName = callbackTableInit;
                                table.callAjax(urlRenderTable, callbackName);
                            });
                        }
                        $("input.displayed").bootstrapSwitch();
                    } else if (name = callbackExpandselectedTree){
                        data.current_cat_id = current_cat_id;
                        expandselectedTree = data;
                        openFolderWithId(this.event, "");
                    } 
                    
                    $('.row-actions').hide();
                    $(".iedit").mouseover(function(){
                    $('.row-actions').hide();
                        $(this).find('.row-actions').show();
                    });
                    
                    $("input.displayed").on('switchChange.bootstrapSwitch', function(event, state) {
                        var categoryid = $(this).attr("categoryid");
                        var displayed = ($(this).attr("checked")=='checked')?1:0;
                        var callbackName = "statusDisplay";
                        var obj = new Object();
                        obj.id = categoryid;
                        obj.displayed = displayed;    
                        Table.prototype.callAjaxTableEjs(obj, urlDisplay, callbackName);
                    });
                },
                failure: function(errMsg) {
                    alert("Falure:"+errMsg);
                },
                error: function (xhr, textStatus, errorThrown){
                    alert("Error:"+textStatus);
                }
            });
        },
    }
function fixWidthHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
}

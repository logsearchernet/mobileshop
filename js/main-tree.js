var expandselectedTree;
var currentArrIndex = 0;
var urlExpandAll, urlTree, callbackTree, callbackExpandselectedTree, callbackSingleLevelTree, templateTree;
var expandselectedTree = new Array();
var currentCategoryId;

function Tree (id, parentId) {
    this.id = id;
    this.parentId = parentId;
}

Tree.prototype =
    {
        constructor: Tree,
        init: function (currentCategoryId, urlExpandAll, urlTree, callbackTree, callbackExpandselectedTree, callbackSingleLevelTree,  templateTree) {
            urlExpandAll = urlExpandAll;
            urlTree = urlTree;
            callbackTree = callbackTree;
            callbackExpandselectedTree = callbackExpandselectedTree;
            templateTree = templateTree;
            currentCategoryId = currentCategoryId;
            callbackSingleLevelTree = callbackSingleLevelTree;
        },
        
        openFolderSingleLevel: function (id){
            currentCategoryId = id;
            var thisOne = $("li.tree-folder[catid='"+id+"']");
            var parentId = thisOne.parents('li.tree-folder').attr('catid');
            parentId = (parentId == undefined)?'':parentId;
            
            var visible = thisOne.children('ul.tree').is(':visible');
            if (visible == true){
                thisOne.find('.fa-folder-open').toggleClass('fa-folder-open fa-folder');
                thisOne.children('ul.tree').remove();
            } else {
                thisOne.find('.fa-folder').toggleClass('fa-folder fa-folder-open');
                var tree = new Tree(id, parentId);
                tree.callTreeAjax(urlTree, "callbackTree2");
            }
        },
        
        openFolderWithId: function(id){
            var thisOne = $("li.tree-folder[catid='"+id+"']");
            var parentId = thisOne.parents('li.tree-folder').attr('catid');
            parentId = (parentId == undefined)?'':parentId;
            
            thisOne.closest('ul.tree').siblings('.tree').remove();
            if (id == currentCategoryId){
                $("li.tree-folder[catid='"+id+"']").find('input[value='+id+']').attr('checked', 'checked');
                
                return;
            } 
            var thisOne = $(".tree-folder[catid='"+ id +"']");
            thisOne.find('.fa-folder').toggleClass('fa-folder fa-folder-open');
            var tree = new Tree(id, parentId);
            tree.callTreeAjax(urlTree, callbackTree);
        },
        
        callTreeAjax: function(urlAjax, callbackName) {
                var input = JSON.stringify(this);
                $.ajax({
                type: "POST",
                url: urlAjax,
                data: input,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(data){
                    if (callbackName == callbackTree){ 
                       
                        var content = new EJS({url: templateTree}).render(data);
                        var thisOne = $(".tree-folder[catid='"+ expandselectedTree[currentArrIndex] +"']");
                        thisOne.append(content);
                        currentArrIndex++;
                        Tree.prototype.openFolderWithId(expandselectedTree[currentArrIndex]);
                        
                    } else if (callbackName == callbackExpandselectedTree){
                        expandselectedTree = data;
                        if (expandselectedTree.length > 0){
                            Tree.prototype.openFolderWithId(0);
                        }
                    } else if (callbackName == "callbackTree2"){
                        var content = new EJS({url: templateTree}).render(data);
                        var thisOne = $(".tree-folder[catid="+  currentCategoryId +"]");
                        thisOne.append(content);
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
          
    }
  




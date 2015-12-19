<style>
    
    .tree {
        list-style: none;
    }    
    
</style>
<script>
var basePath = "<?php echo site_url('')?>";
var thatOne = "";
        
$(document).ready(function(){
    
    $(document).on('click','.tree-folder-name', function(e) {
        if($(e.target).is(':input')){
            return;
        } 
        if ($(this).siblings('.tree').is(':visible')){
            $(this).children('i').toggleClass('fa-folder-open fa-folder');
            $(this).siblings('.tree');
            $(this).siblings('.tree').hide('fast');
        } else {
            $(this).siblings('.tree').remove();
            var id_parent = $(this).find('input[name="parent_category"]').val();
            var obj = new Object();
            obj.parent_category = id_parent;

            var url = basePath+"sample_demo/ajax_tree";
            callbackName = "category-tree";
            thatOne = $(this);
            callAjax(obj, url, callbackName);
        }
    });
});  

function callback(name, data) {
    if (name == 'category-tree'){   
        var content = new EJS({url: basePath+'template/categoryTree.ejs'}).render(data);
        thatOne.parent().append(content);
        thatOne.find('.fa').toggleClass('fa-folder fa-folder-open');
    }
}
</script>
<ul id="categories-tree" class="tree">
    <li class="tree-folder">
        <span class="tree-folder-name tree-selected">
            <input type="radio" name="parent_category" value="0">
            <i class="fa fa-folder"></i>
            <label class="tree-toggler">Home</label>
        </span>
        
    </li>
</ul>


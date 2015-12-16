<script>
var basePath = "<?php echo site_url('')?>";
        
$(document).ready(function(){
    doSortParts();
});

function doSortParts(){
    $("#category-table").sortable({
    	handle:'button.move-row',
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
            alert(JSON.stringify(newProps));
    	}
    });
}
</script>
<table id="">
    <tbody id="category-table">
    <tr class="iedit">
        <td>
            <button type="button" class="btn btn-link move-row ui-sortable-handle" categoryid="12" value="1"><i class="fa fa-arrows fa-lg"></i></button>
        </td>
        <td>111</td>
    </tr>
    <tr class="iedit">
        <td>
            <button type="button" class="btn btn-link move-row ui-sortable-handle" categoryid="13" value="2"><i class="fa fa-arrows fa-lg"></i></button>
        </td>
        <td>222</td>
    </tr>
    <tr class="iedit">
        <td>
            <button type="button" class="btn btn-link move-row ui-sortable-handle"  categoryid="14" value="3"><i class="fa fa-arrows fa-lg"></i></button>
        </td>
        <td>333</td>
    </tr>
    </tbody>
</table>
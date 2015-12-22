<div class="row">
    <div class="col-lg-6">

        <ul class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-container">
                <a href="<?php echo site_url('product') ?>">Catalog</a>				
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('product_attribute_group/') ?>">Product Attributes</a>
            </li>
            <li class="breadcrumb-current">
                <a href="<?php echo site_url('product_attribute_child/index/'. $parentid) ?>">Product Attribute Values</a>
            </li>
        </ul>
    </div>
</div>
<br/>
<div class="col-lg-offset-1 col-md-8">
<?php echo validation_errors(); ?>
<?php
$formAttributes = array('class' => 'form-horizontal');
$labelAttributes = array(
'class' => 'col-sm-2 control-label',
);
$inputAttributes = 'class="form-control"';
?>
<?php echo form_open('product_attribute_child/attribute_child_edit', $formAttributes); ?>
    
    <div class="card">
        <div class="card-head style-primary">
            <header>Create a product attribute</header>
        </div>
        <div class="card-body floating-label">

            <div class="form-group">
                <?php echo form_label('Attribute group', 'atrribute_group', $labelAttributes); ?>
                <div class="col-sm-10">
                    <select id="attribute_group" name="attribute_group" class="form-control">
                        <?php foreach ($options as $id => $name):?>
                        <option value="<?php echo $id?>" <?php echo ($id == $parentid)?"selected":"";?>><?php echo $name?></option>
                        <?php endforeach;?>
                    </select>
                    <?php echo form_hidden('id', $attribute->id);?>
                </div>
            </div>
            
            <div class="form-group">
                <?php echo form_label('Value', 'value', $labelAttributes); ?>
                <div class="col-sm-10">
                    <?php echo form_input('value', $attribute->value, $inputAttributes); ?><div class="form-control-line"></div>
                </div>
            </div> 
            
            <!--
            <div class="form-group">
                <?php echo form_label('Color', 'color', $labelAttributes); ?>
                <div class="col-sm-10">
                    <?php echo form_input('color', $attribute->color, $inputAttributes); ?>
                    <div class="form-control-line"></div>
                    <?php echo form_hidden('id', $attribute->id);?>
                    <script>
                    $(function(){
                        $('input[name="color"]').colorpicker();
                    });
                    </script>
                </div>
            </div>
            -->
            
            

            <div class="row">
                <div class="col-lg-6 text-left">
                    <a href="<?php echo site_url('product_attribute_child/index/'.$parentid) ?>" class="btn btn-primary ink-reaction">Cancel</a>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="submit" class="btn btn-primary ink-reaction"><?php echo (isset($attribute->id) ? "Update value" : "Create value"); ?></button>
                </div>
            </div>
        </div>
    </div><!--end .card -->
<?php echo form_close(); ?>    
</div>
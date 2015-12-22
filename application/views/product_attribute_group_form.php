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
<?php echo form_open('product_attribute_group/attribute_group_edit', $formAttributes); ?>
    
    <div class="card">
        <div class="card-head style-primary">
            <header>Create a product attribute</header>
        </div>
        <div class="card-body floating-label">

            <div class="form-group">
                <?php echo form_label('Name', 'name', $labelAttributes); ?>
                <div class="col-sm-10">
                    <?php echo form_input('name', $attribute->name, $inputAttributes); ?><div class="form-control-line"></div>
                </div>
            </div> 
            
            <div class="form-group">
                <?php echo form_label('Public Name', 'public_name', $labelAttributes); ?>
                <div class="col-sm-10">
                    <?php echo form_input('public_name', $attribute->public_name, $inputAttributes); ?><div class="form-control-line"></div>
                </div>
            </div>
            
            <div class="form-group">
                <?php echo form_label('Attribute Type', 'atrribute_type', $labelAttributes); ?>
                <div class="col-sm-10">
                    <select id="attribute_type" name="attribute_type" class="form-control">
                        <option value="select" <?php echo ($attribute->attribute_type == "select")?"selected":"";?>>Drop-down list</option>
                        <option value="radio" <?php echo ($attribute->attribute_type == "radio")?"selected":"";?>>Radio buttons</option>
                    </select>
                    <?php echo form_hidden('id', $attribute->id);?>
                </div>
            </div>
            

            <div class="row">
                <div class="col-lg-6 text-left">
                    <a href="<?php echo site_url('product_attribute_group/') ?>" class="btn btn-primary ink-reaction">Cancel</a>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="submit" class="btn btn-primary ink-reaction"><?php echo (isset($attribute->id) ? "Update category" : "Create category"); ?></button>
                </div>
            </div>
        </div>
    </div><!--end .card -->
<?php echo form_close(); ?>    
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    CKEDITOR.replaceAll('tinymce');
</script>

<div class="container top">

    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li>
            <a href="<?php echo site_url("admin") . '/' . $this->uri->segment(2); ?>">
                <?php echo ucfirst($this->uri->segment(2)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <a href="#">Update</a>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            Updating <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>



    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/material/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($material as $material_content) { ?>

            <input type="hidden" value="<?php echo $material_content['item_row_material_id'] ?>" name="item_row_material_id" />

            <div class="control-group">
                <label for="inputError" class="control-label">Name<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="name" name="name" value="<?php echo $material_content['name'] ?>" >

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Description<span class="star">*</span></label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor" name="description"><?php echo $material_content['description'] ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Unit of Measurement<span class="star">*</span></label>
                <div class="controls">
                    <select name="uom">
                        <option <?php echo trim($material_content['uom']) == 'KG' ? 'selected="selected"' : '' ?>  value="KG">KG</option>
                        <option <?php echo trim($material_content['uom']) == 'GM' ? 'selected="selected"' : '' ?> value="GM">GM</option>
                        <option <?php echo trim($material_content['uom']) == 'LTR' ? 'selected="selected"' : '' ?> value="LTR">LTR</option>
                    </select>

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Quantity<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="cost" name="qty" value="<?php echo $material_content['qty'] ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Price<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="cost" name="cost" value="<?php echo $material_content['cost'] ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php echo trim($material_content['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php echo trim($material_content['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

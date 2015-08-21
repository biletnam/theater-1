<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function getPerRowMaterial(obj, child_type) {
        var parent_id = $(obj).val();
//        toggle_loader($('#per_' + child_type))
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_per_row_material",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#' + child_type).html(data);
                }
            });
        } else {
            $('#per_' + child_type).html('');
            $('#per_' + child_type).change();
        }
    }
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
            <a href="#">New</a>
        </li>
    </ul>

    <div class="page-header">
        <h2>
            Adding <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>

    <?php
    //flash messages
    //print_r($flash_message);
    /* if(!empty($flash_message))
      {
      echo '<div class="alert alert-success">';
      echo '<a class="close" data-dismiss="alert">&#215;</a>';
      echo '<strong>Well done!</strong> new category created with success.';
      echo '</div>';
      }else{
      echo '<div class="alert alert-error">';
      echo '<a class="close" data-dismiss="alert">&#215;</a>';
      echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
      echo '</div>';
      } */
    ?>

    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/purchase_material/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Row Material Name:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = " getPerRowMaterial(this,'uom') ";
                $attribute = 'id="per_item_row_material_id"  onchange="' . $js . '" ';
                echo form_dropdown('item_row_material_id', $item_row_material_opt, $item_row_material_id, $attribute);
                ?>
            </div>

        </div>
        <div id="uom">

        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo set_value('status') == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo set_value('status') == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/purchase_material">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

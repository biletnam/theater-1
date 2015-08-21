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

    echo form_open_multipart('admin/material/add', $attributes);
    ?>
    <fieldset>

        <div class="control-group">
            <label for="inputError" class="control-label">Name<span class="star">*</span></label>
            <div class="controls">
                <input type="name" id="" name="name" value="" >

            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Description<span class="star">*</span> </label>
            <div class="controls">
                <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Unit of Measurement<span class="star">*</span></label>
            <div class="controls">
                <select name="uom">
                    <option <?php echo set_value('uom') == 'KG' ? 'selected="selected"' : '' ?>  value="KG">KG</option>
                    <option <?php echo set_value('uom') == 'GM' ? 'selected="selected"' : '' ?> value="GM">GM</option>
                    <option <?php echo set_value('uom') == 'LTR' ? 'selected="selected"' : '' ?> value="LTR">LTR</option>
                </select>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Quantity<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="cost" name="qty" value="">
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Price<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="cost" name="cost" value="">
            </div>
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
            <a class="btn" href="<?php echo site_url('admin') ?>/material">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

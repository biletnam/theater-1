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

    echo form_open('admin/category/add', $attributes);
    ?>
    <fieldset>
        <?php /* ?> <div class="control-group">
          <label for="inputError" class="control-label">Category Name</label>
          <div class="controls">
          <input type="text" id="" name="en" value="<?php echo set_value('en'); ?>" >
          <!--<span class="help-inline">Woohoo!</span>-->
          </div>
          </div><?php */ ?>
        <?php /* ?> <?php //echo '<pre>'; print_r($site_language);
          for($i=0;$i<count($site_language);$i++){
          ?>
          <div class="control-group">
          <label for="inputError" class="control-label"><?php echo $site_language[$i]['language_longform'];?></label>
          <div class="controls">
          <textarea name="<?php echo $site_language[$i]['language_shortcode']?>"></textarea>
          <!--<span class="help-inline">Woohoo!</span>-->
          </div>
          </div>
          <?php }?><?php */ ?>
        <div class="control-group">
            <label for="inputError" class="control-label">Select Parent Menu:</label>
            <div class="controls">
                <select name="parent_id">
                    <option value="0">--------- Parent Category ---------</option>	
                    <?php
                    for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                        if ($par_cat_array[$i]['category_id'] == $parent_id)
                            $selected = "selected";
                        else
                            $selected = "";
                        echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                    }
                    ?>
                </select>
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Category Name</label>
            <div class="controls">
                <input type="text" id="" name="category_name" value="<?php echo set_value('category_name'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        
        <div class="control-group">
            <label for="inputError" class="control-label">Display Order<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="display_order" name="display_order" value="<?php echo set_value('display_order'); ?>" >
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
            <a class="btn" href="<?php echo site_url('admin') ?>/category">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

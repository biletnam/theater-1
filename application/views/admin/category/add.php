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
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open('admin/category/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">Select Parent Menu:<span class="star">*</span></label>
            <div class="controls">
                <select name="parent_id">
                    <option value="">--------- Parent Category ---------</option>
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
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Category Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="category_name" value="<?php echo set_value('category_name'); ?>" >
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

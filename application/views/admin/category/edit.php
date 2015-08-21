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
//    echo "<pre>";
//    print_r($par_cat_array);
//    exit;
    //form validation
    echo validation_errors();
    echo form_open('admin/category/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />
        <input type="hidden" value="<?php echo $category[0]['category_id']; ?>" name="category_id" />

        <div class="control-group">
            <label for="inputError" class="control-label">Select Parent Menu:<span class="star">*</span></label>
            <div class="controls">
                <select name="parent_id">
                    <option value="">--------- Parent Category ---------</option>
                    <?php
                    for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                        ?>

                        <?php
                        //echo $category[0]['parent_id'] . '<br>';
                        if ($par_cat_array[$i]['category_id'] == $category[0]['parent_id'])
                            $selected = "selected='selected'";
                        else
                            $selected = "";
                        echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php foreach ($category as $category_content) { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Category Name<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="" name="category_name" value="<?php echo $category_content['category_name'] ?>" >
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php echo trim($category_content['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php echo trim($category_content['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
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

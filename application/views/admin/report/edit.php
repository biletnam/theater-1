<div class="container top">
    <script>
        $(function() {
            $("#joining_date").datepicker({dateFormat: "yy-mm-dd"});
            $("#end_date").datepicker({dateFormat: "yy-mm-dd"});
        });
    </script>
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

    echo form_open_multipart('admin/company/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />


        <div class="control-group">
            <label for="inputError" class="control-label">Company Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="company_name" value="<?php echo $company[0]['company_name']; ?>" >
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo trim($company[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo trim($company[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
            <span style="display:none"; id="delete_msg">Are you really sure to delete this Company?</span>
            <a style="margin-left:30px;" href="<?php echo site_url("admin") ?>/company/delete/<?php echo $this->uri->segment(4) ?>" class="btn btn-danger complexConfirm">Delete Company</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

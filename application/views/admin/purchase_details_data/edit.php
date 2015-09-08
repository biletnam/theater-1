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

    echo form_open_multipart('admin/user/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />


        <div class="control-group">
            <label for="inputError" class="control-label">First Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="firstname" value="<?php echo $user[0]['firstname']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" id="" name="lastname" value="<?php echo $user[0]['lastname']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="username" value="<?php echo $user[0]['username']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
                <input disabled="disabled" type="password" class="pass_disabled" name="password" value="<?php echo $user[0]['password']; ?>" >
                <span class="help-inline"><a onclick="changepassword();" href="javascript:void(0)">Change</a></span>
            </div>
        </div>
        <div id="confirm_div" style="display:none;" class="control-group">
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
                <input disabled="disabled" type="password" class="pass_disabled" name="password2" value="<?php echo $user[0]['password']; ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="primary_email" value="<?php echo $user[0]['primary_email']; ?>" >
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Phone<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="phone" value="<?php echo $user[0]['phone']; ?>" >
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">User Type</label>
            <div class="controls">
<!--                <select name="user_type">
                    <option <?php echo trim($user[0]['user_type']) == 'Super Admin' ? 'selected="selected"' : '' ?>  value="Super Admin">Super Admin</option>
                    <option <?php echo trim($user[0]['user_type']) == 'Admin' ? 'selected="selected"' : '' ?> value="Admin">Admin</option>
                </select>-->
                <select name="user_type">
                    <?php
                    $user_role_array = Access_level::user_role_dropdown();
                    $ci = & get_instance();
                    $user_type = $ci->session->userdata('user_type');
                    ?>
                    <?php foreach ($user_role_array[$user_type] as $key => $role_val) {
                        ?>
                        <option <?php echo $user[0]['user_type'] == $key ? 'selected="selected"' : '' ?>  value="<?php echo $key ?>"><?php echo $role_val ?></option>
                    <?php } ?>

                </select>
                     <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Joining Date<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="joining_date" name="joining_date" value="<?php echo $user[0]['joining_date']; ?>" >
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Ending Date<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="end_date" name="end_date" value="<?php echo $user[0]['end_date']; ?>" >
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo trim($user[0]['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo trim($user[0]['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo $this->session->userdata('redirect_url'); ?>">Cancel</a>
            <span style="display:none"; id="delete_msg">Are you really sure to delete this User?</span>
            <?php if (user_access($this->session->userdata('user_id'), 'delete_users') == true) { ?>
                <a style="margin-left:30px;" href="<?php echo site_url("admin") ?>/user/delete/<?php echo $this->uri->segment(4) ?>" class="btn btn-danger complexConfirm">Delete User</a>
            <?php } ?>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

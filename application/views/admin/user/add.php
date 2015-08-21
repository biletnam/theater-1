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
    //form validationc
    echo validation_errors();
    echo form_open_multipart('admin/user/add', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label">First Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="firstname" value="<?php echo set_value('firstname'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Last Name</label>
            <div class="controls">
                <input type="text" id="" name="lastname" value="<?php echo custom_set_value('lastname'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">User Name<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="username" value="<?php echo set_value('username'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Password<span class="star">*</span></label>
            <div class="controls">
                <input type="password" id="" name="password" value="<?php echo set_value('password'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Confirm Password<span class="star">*</span></label>
            <div class="controls">
                <input type="password" id="" name="password2" value="<?php echo set_value('password2'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Primary E-mail<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="primary_email" value="<?php echo set_value('primary_email'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Phone</label>
            <div class="controls">
                <input type="text" id="" name="phone" value="<?php echo set_value('phone'); ?>" >
                <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
       <?php //echo "<pre>"; print_r($this->session->all_userdata()); die; ?>
        <?php if (Access_level::session_user_type() == 'super_admin') { ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Company<span class="star">*</span></label>
                <div class="controls">
                    <select name="company_id">
                        <option value="">-select company-</option>
                        <?php for ($i = 0; $i < count($company); $i++) { ?>
                            <option <?php echo custom_set_value('company_id') == $company[$i]['company_id'] ? 'selected="selected"' : '' ?>  value="<?php echo $company[$i]['company_id'] ?>"><?php echo $company[$i]['company_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        <?php } else { ?>
        <?php 
               
//        echo "<pre>"; print_r($company);
//                echo "</pre>";
        ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Company<span class="star">*</span></label>
                <div class="controls">
                    <select name="company_id">
                    <?php
                    $company_id = Access_level::session_company_id();
                   
                    for ($i = 0; $i < count($company); $i++) {  ?>
                        <option value="<?php echo $company_id;  ?>"><?php echo $company[$i]['company_name']; ?></option>
                    <?php } ?>
                    </select>
                </div>
            </div>
        <?php } ?>
        <div class="control-group">
            <label for="inputError" class="control-label">User Type</label>
            <div class="controls">
                <select name="user_type">
                    <?php
                    $user_role_array = Access_level::user_role_dropdown();
                    $ci = & get_instance();
                    $user_type = $ci->session->userdata('user_type');
                    ?>
                    <?php foreach ($user_role_array[$user_type] as $key => $role_val) {
                        ?>
                        <option <?php echo custom_set_value('user_type') == $key ? 'selected="selected"' : '' ?>  value="<?php echo $key ?>"><?php echo $role_val ?></option>
                    <?php } ?>

                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label" >Joining Date</label>
            <div class="controls">
                <input type="text" name="joining_date" id="joining_date" value="<?php echo set_value('joining_date'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label" >Ending Date</label>
            <div class="controls">
                <input type="text" name="end_date" id="end_date" value="<?php echo set_value('end_date'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Status</label>
            <div class="controls">
                <select name="status">
                    <option <?php echo custom_set_value('status') == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                    <option <?php echo custom_set_value('status') == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
                </select>
                 <!--<span class="help-inline">Woohoo!</span>-->
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <a class="btn" href="<?php echo site_url('admin') ?>/user">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

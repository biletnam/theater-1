<div class="container top">
    <script>
        $(function() {
            $("#joining_date").datepicker({dateFormat: "yy-mm-dd"});
            $("#end_date").datepicker({dateFormat: "yy-mm-dd"});
            $('#search_btn').click(function() {
                $('#is_search').val('search');
            });
        });
    </script>
    <ul class="breadcrumb">
        <li>
            <a href="<?php echo site_url("admin/dashboard"); ?>">
                <?php echo ucfirst($this->uri->segment(1)); ?>
            </a>
            <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </li>
    </ul>

    <div class="page-header users-header">
        <h2>
            <?php echo ucfirst($this->uri->segment(2)); ?>
        </h2>
    </div>


    <?php
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');
    //form validationc
    echo validation_errors();
    echo form_open_multipart('admin/purchase_report/search', $attributes);
    ?>
    <fieldset>
        <div class="control-group">
            <label for="inputError" class="control-label" >Start Date</label>
            <div class="controls">
                <input type="text" name="start_date" id="joining_date" value="<?php echo set_value('start_date'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label" >End Date</label>
            <div class="controls">
                <input type="text" name="end_date" id="end_date" value="<?php echo set_value('end_date'); ?>">
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Product</label>
            <div class="controls">
                <select name="product_name">
                    <option value="">-Select Product-</option>
                    <?php for ($i = 0; $i < count($all_products); $i++) { ?>
                        <option value="<?php echo $all_products[$i]['title'] ?>"><?php echo $all_products[$i]['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="is_search" id="is_search">
        <div class="form-actions">
            <button id="search_btn" class="btn btn-primary" type="submit">Search</button>
            <button class="btn btn-primary" type="submit">Export CSV</button>
            <a class="btn" href="<?php echo site_url('admin') ?>">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

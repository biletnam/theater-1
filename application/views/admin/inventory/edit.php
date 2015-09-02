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

    echo form_open_multipart('admin/inventory/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php foreach ($inventory as $inventory_content) { ?>
            <?php //echo "<pre>"; print_r($products_content); die;   ?>
            <input type="hidden" value="<?php echo $inventory_content['inventory_id'] ?>" name="inventory_id" />

            <div class="control-group">
                <label for="inputError" class="control-label">Name</label>
                <div class="controls">
                    <input type="text" id="" name="name" value="<?php echo $inventory_content['name'] ?>" readonly >

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Quantity</label>
                <div class="controls">
                    <input type="text" id="" name="qua" value="<?php echo $inventory_content['qua'] ?>" >
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">UOM</label>
                <div class="controls">
                    <select name="uom">
                        <option <?php echo trim($inventory_content['uom']) == 'KG' ? 'selected="selected"' : '' ?>  value="KG">KG</option>
                        <option <?php echo trim($inventory_content['uom']) == 'LTR' ? 'selected="selected"' : '' ?> value="LTR">LTR</option>
                        <option <?php echo trim($inventory_content['uom']) == 'GM' ? 'selected="selected"' : '' ?>  value="GM">GM</option>
                        <option <?php echo trim($inventory_content['uom']) == 'ML' ? 'selected="selected"' : '' ?> value="ML">ML</option>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Total Cost</label>
                <div class="controls">
                    <input type="text" id="" name="total_cost" value="<?php echo $inventory_content['total_cost'] ?>" >

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

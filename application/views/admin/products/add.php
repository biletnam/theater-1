
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function getPerPlaces(obj, child_type) {
        var parent_id = $(obj).val();
//        toggle_loader($('#per_' + child_type))
        $('#per_' + child_type)
        if (parent_id != "") {
            $.ajax({
                type: 'POST',
                url: base_url + "common_ctrl/get_places",
                data: {child_type: child_type, parent_id: parent_id},
                success: function(data) {
                    $('#per_' + child_type).html(data);
                    $('#per_' + child_type).change();
//                    toggle_loader($('#per_' + child_type), 1);
                }
            });
        } else {
            $('#per_' + child_type).html('<option value="">Select</option>');
            $('#per_' + child_type).change();
//            toggle_loader($('#per_' + child_type), 1);
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
    //form data
    $attributes = array('class' => 'form-horizontal', 'id' => '');

    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/products/add', $attributes);
    ?>
    <fieldset>

        <div class="control-group">
            <label for="inputError" class="control-label">Select Parent Menu:<span class="star">*</span></label>
            <div class="controls">
                <select name="category_id">
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
            <label for="inputError" class="control-label">Title<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="title" value="" >

            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Product Type:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = "";
                $attribute = 'id="product_type"  onchange="' . $js . '" ';
                echo form_dropdown('product_type', $product_type_opt, '', $attribute);
                ?>
            </div>

        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Unit of Measurement:-<span class="star">*</span></label>
            <div class="controls">
                <?php
                $js = "";
                $attribute = 'id="uom"  onchange="' . $js . '" ';
                echo form_dropdown('uom', $uom_opt, '', $attribute);
                ?>
            </div>

        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Quantity<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="qty" value="" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Price<span class="star">*</span></label>
            <div class="controls">
                <input type="text" id="" name="price" value="" >
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Images: <span class="star">*</span></label>
            <div class="controls">
                <input type="file" name="images" value="" />
            </div>
        </div>
        <div class="control-group">
            <label for="inputError" class="control-label">Description </label>
            <div class="controls">
                <textarea class="tinymce ckeditor" id="editor" name="description"></textarea>
            </div>
        </div>

        <div class="control-group">
            <label for="inputError" class="control-label">Combo</label>
            <div class="controls">
                <input type="checkbox" id="" name="is_group" value="YES" >

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
            <a class="btn" href="<?php echo site_url('admin') ?>/products">Cancel</a>
        </div>
    </fieldset>

    <?php echo form_close(); ?>

</div>

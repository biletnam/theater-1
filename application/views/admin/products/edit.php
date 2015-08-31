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
    $ci = &get_instance();
    $ci->load->model('common_model');
    //form validation
    echo validation_errors();

    echo form_open_multipart('admin/products/update/' . $this->uri->segment(4) . '', $attributes);
    ?>
    <fieldset>
        <input type="hidden" value="<?php echo $this->session->userdata('redirect_url') ?>" name="redirect_url" />

        <?php
        foreach ($products as $products_content) {
            ?>
            <?php //echo "<pre>"; print_r($products_content); die;  ?>
            <input type="hidden" value="<?php echo $products_content['products_id'] ?>" name="products_id" />

            <div class="control-group">
                <label for="inputError" class="control-label">Select Parent Menu:<span class="star">*</span></label>
                <div class="controls">
                    <select name="category_id">
                        <option value="">--------- Parent Category ---------</option>
                        <?php
                        for ($i = 0, $n = count($par_cat_array); $i < $n; $i++) {
                            ?>

                            <?php
                            //echo $category[0]['parent_id']; die;
                            if ($par_cat_array[$i]['category_id'] == $category[0]['category_id'])
                                $selected = "selected='selected'";
                            else
                                $selected = "";
                            echo "<option value='" . $par_cat_array[$i]['category_id'] . "' $selected>" . $par_cat_array[$i]['path'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Title</label>
                <div class="controls">
                    <input type="text" id="" name="title" value="<?php echo $products_content['title'] ?>" >

                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Product Type:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $js = "";
                    $attribute = 'id="product_type"  onchange="' . $js . '" ';
                    echo form_dropdown('product_type', $product_type_opt, $products_content['product_type'], $attribute);
                    ?>
                </div>

            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Unit of Measurement:-<span class="star">*</span></label>
                <div class="controls">
                    <?php
                    $js = "";
                    $attribute = 'id="uom"  onchange="' . $js . '" ';
                    echo form_dropdown('uom', $uom_opt, $products_content['uom'], $attribute);
                    ?>
                </div>

            </div>
            <?php
            $where = " AND uom_id={$products_content['uom']}";
            $uom_unit = $ci->common_model->getFieldData('uom', 'uom', $where);
            if ($uom_unit == "KG" || $uom_unit == "LTR") {
                $convertedQty = Access_level::convertToLTROrKG($products_content['qty']);
            } else {
                $convertedQty = $products_content['qty'];
            }
            ?>
            <div class="control-group">
                <label for="inputError" class="control-label">Quantity<span class="star">*</span></label>
                <div class="controls">
                    <input type="text" id="" name="qty" value="<?php echo $convertedQty; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="inputError" class="control-label">Price</label>
                <div class="controls">
                    <input type="text" id="" name="price" value="<?php echo $products_content['price'] ?>" >

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Images: </label>
                <div class="controls">
                    <input type="file" name="images" value="" />

                    <div style="float:left; padding: 1px;"><img width="100" src="<?php echo base_url(); ?>uploads/product/<?php echo $products_content['images']; ?>" /></div>

                    <input type="hidden" name="old_image" value="<?php echo $products_content['images'] ?>" />

                </div>
            </div>


            <div class="control-group">
                <label for="inputError" class="control-label">Description </label>
                <div class="controls">
                    <textarea class="tinymce ckeditor" id="editor" name="description"><?php echo $products_content['description'] ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Combo</label>
                <div class="controls">
                    <?php
                    $is_combo = $products_content['is_group'];
                    $checked = '';
                    if ($is_combo == 'YES') {
                        $checked = "checked='checked'";
                    }
                    ?>
                    <input <?php echo $checked; ?> type="checkbox" id="" name="is_group" value="YES" >

                </div>
            </div>

            <div class="control-group">
                <label for="inputError" class="control-label">Status</label>
                <div class="controls">
                    <select name="status">
                        <option <?php echo trim($products_content['status']) == 'Active' ? 'selected="selected"' : '' ?>  value="Active">Active</option>
                        <option <?php echo trim($products_content['status']) == 'Inactive' ? 'selected="selected"' : '' ?> value="Inactive">Inactive</option>
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

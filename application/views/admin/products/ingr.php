<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/hogan.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/typeahead.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assets/css/admin/style.css">
<script>
    $(document).ready(function() {
        $('#name').typeahead({
            name: 'name',
            cache: true,
            remote: '<?php echo base_url(); ?>admin_products/get_row_material/%QUERY',
            template: [
                '<p class="repo-price">Qty:-{{qty}}</p>',
                '<p class="repo-name">{{name}}</p>',
                '<p class="repo-material">{{item_row_material_id}}</p>'
            ].join(''),
            engine: Hogan
        });

        $('#name').bind('typeahead:selected', function(obj, datum, name) {
            var product = datum;
            //console.log(product);
            var item_row_material_id = product.item_row_material_id;
            //alert(item_row_material_id);
            put_value(item_row_material_id);
        });

        $("#material_qua").keyup(function(e) {
            //var code = $(this).keycode;
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code >= 96 && code <= 105 || code >= 48 && code <= 57) {
                var per_cost = $('#material_cost').val();
                var new_qua = $(this).val();
                var new_cost = parseFloat(per_cost) * parseFloat(new_qua);
                $('#material_cost').val(new_cost)
            }
        });

    });

    function put_value(id) {
        var item_row_material_id = id;
        $.ajax({
            url: base_url + 'admin_products/get_uom',
            type: "POST",
            data: {item_row_material_id: item_row_material_id},
            success: function(data) {
                $('#material_uom').val(data);
                var name = $('#name').val();
                $('#material_name').val(name);
                //alert(name);
                put_cost(item_row_material_id);
            },
            error: function() {
            }
        });
    }

    function put_cost(id) {
        var item_row_material_id = id;
        $.ajax({
            url: base_url + 'admin_products/get_cost',
            type: "POST",
            data: {item_row_material_id: item_row_material_id},
            success: function(data) {
                $('#material_qua').val(1);
                $('#material_cost').val(data);
            },
            error: function() {
            }
        });
    }

    function editproduct(e)
    {
        var id = $(e).attr('data-id');
        var name = $('.name_' + id).text();
        var qua = $('.qua_' + id).text();
        var uom = $('.uom_' + id).text();
        var cost = $('.cost_' + id).text();

        $('#edit_text_box').val(id);
        $('#material_name').val(name);
        $('#name').val(name);
        $('#material_qua').val(qua);
        $('#material_uom').val(uom);
        $('#material_cost').val(cost);
    }

    var counter = 1;
    function add_fields() {
        var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'add_tr_' + counter);
        console.log(newTextBoxDiv);
        newTextBoxDiv.html('<td><input type="text" name="name" id="material_name"></td><td><input type="text" name="quantity" id="material_qua"></td> <td><input type="text" name="uom" id="material_uom"></td><td><input type="text" name="cost" id="material_cost"></td><td>');
        newTextBoxDiv.appendTo("#add_table > tbody");
        counter++;
    }
</script>
<style>
    input, textarea, select, .uneditable-input{}
    #material_qua,#material_uom,#material_cost{ width: 150px;}
</style>
<?php
//echo $this->session->flashdata('flash_message');
if ($this->session->flashdata('flash_message')) {
    if ($this->session->flashdata('flash_message') == 'add') {
        echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo '<strong>Well done!</strong> new products created with success.';
        echo '</div>';

        $this->session->set_userdata('flash_message', '');
        //echo $this->session->flashdata('flash_message');
    } else if ($this->session->flashdata('flash_message') == 'update') {
        echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo '<strong>Well done!</strong> products updated with success.';
        echo '</div>';
        $this->session->set_userdata('flash_message', '');
    } else if ($this->session->flashdata('flash_message') == 'delete') {
        echo '<div class="alert alert-success">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo '<strong>Well done!</strong> products deleted with success.';
        echo '</div>';
        $this->session->set_userdata('flash_message', '');
    } else {
        echo '<div class="alert alert-error">';
        echo '<a class="close" data-dismiss="alert">&#215;</a>';
        echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
        echo '</div>';
    }
}
?>
<div class="container top">

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
            <?php
            if (!empty($product_name)) {
                echo $product_name;
            }
            ?> Ingredients<?php //echo ucfirst($this->uri->segment(2));?>
        </h2>
    </div>
    <div class="row">
        <div class="span12 columns">
            <table id="add_table" class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="yellow header headerSortDown">Name <span style="color:#FF0000">*</span></th>
                        <th class="yellow header headerSortDown">Quantity <span style="color:#FF0000">*</span></th>
                        <th class="yellow header headerSortDown">Unit Type</th>
                        <th class="yellow header headerSortDown">Cost</th>
                    </tr>
                </thead>
                <?php
                //form data
                $attributes = array('class' => 'form-horizontal', 'id' => '');
                //form validation
                echo validation_errors();
                echo form_open_multipart('admin/products/add_ingr', $attributes);
                ?>
                <tbody>
                    <tr id="add_tr">
                <input type="hidden" id="material_name" name="material_name">
                <input type="hidden" id="edit_text_box" name="edit_id">
                <input type="hidden" name="product_id" value="<?php
                if (!empty($product_id)) {
                    echo $product_id;
                }
                ?>">
                <td><input id="name" type="text" name="name"><span class="valid_msg"></span></td>
                <td><input id="material_qua" type="text" name="quantity"><span class="valid_msg"></span></td>
                <td><input id="material_uom" type="text" name="uom" readonly></td>
                <td><input id="material_cost" type="text" name="cost" readonly></td>
                <td>
                    <input id="add_ingr" class="btn btn-success" type="submit" name="add" value="Add Ingr">
                </td>
                </tr>
                </tbody>
                <?php echo form_close(); ?>
            </table>
            <table id="add_table" class="table table-striped table-bordered table-condensed">
                <tbody>
                    <?php
                    foreach ($all_ingr as $row) {
                        $product_ingredients_id = $row['product_ingredients_id'];
                        echo '<tr>';
                        echo '<td class="name_' . $product_ingredients_id . '">' . $row['material_name'] . '</td>';
                        echo '<td class="qua_' . $product_ingredients_id . '">' . $row['material_qua'] . '</td>';
                        echo '<td class="uom_' . $product_ingredients_id . '">' . $row['uom'] . '</td>';
                        echo '<td class="cost_' . $product_ingredients_id . '">' . $row['cost'] . '</td>';
                        echo '<td class="crud-actions">
                  <a onclick="editproduct(this)" data-id="' . $row['product_ingredients_id'] . '" href="javascript:void(0)" class="btn btn-info">view & edit</a>
                  <a href="' . site_url("admin") . '/products/delete_ingr/' . $row['product_ingredients_id'] . '" class="btn btn-danger">delete</a>
                </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>
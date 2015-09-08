<script>
    function orderView(e) {
        var item_row_material_purchase_id = $(e).attr('data-id');
        $.ajax({
            url: base_url + 'admin_purchase_details_data/view_order_detail',
            type: "POST",
            data: {item_row_material_purchase_id: item_row_material_purchase_id},
            success: function (data) {

                $('.list_head').html(data);
                var sum_qua = 0;
                $('.total_coast').each(function ()
                {
                    sum_qua += parseInt($(this).text());
                });
                $('.value_total').text(sum_qua);
            },
            error: function () {
            }
        });
    }
</script>
<style>
    .black_overlay{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index:1001;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width: 50%;
        height: auto;
        padding: 25px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
    }
    .list_head{ width: 100%}
    .list_head div{ width: 20%; float: left; border-bottom: 1px solid #CCC; text-align: center;}
    .bill_close{ text-align: center; margin-bottom: 10px;}
    .bill_close a{ background-color: #ccc; padding: 5px 10px;}
    .label_total{ float: left; width: 50%}
    /*    .value_total{ float: left; width: 60%}*/
    .label_discount{ float: left; width: 37%}
    .value_discount{ float: left; width: 57%; margin: 0 0 0 4%;}
    .label_grand{ float: left; width: 40%}
    .value_grand{ float: left; width: 60%}
    .qua_label{ width: 35%; float: left;}
    .qua_value{ float: left; }
</style>
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

    <div class="row">
        <div class="span12 columns">

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="yellow header headerSortDown">Purchase Id</th>
                        <!--<th class="yellow header headerSortDown">Product Id</th>-->
                        <th class="yellow header headerSortDown">Total Amount</th>
                        <th class="yellow header headerSortDown">Quantity</th>
                        <th class="yellow header headerSortDown">Date</th>
                        <th class="yellow header headerSortDown"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($user as $row) {
                        $date = date('d/m/Y', $row['datetime']);
                        echo '<tr>';
                        echo '<td>' . $row ['item_row_material_purchase_id'] . '</td>';
                        // echo '<td>' . $row ['products_id'] . '</td>';
                        echo '<td>' . $row ['total_amount'] . '</td>';
                        echo '<td>' . $row['total_quantity'] . '</td>';
                        echo '<td>' . $date . '</td>';
                        echo '<td style="text-align:center;" class="crud-actions">';
                        ?>
                    <a id="data_view" data-id="<?php echo $row['item_row_material_purchase_id']; ?>" href="javascript:void(0)" class="btn btn-info data_view" onclick = "orderView(this);
                                document.getElementById('pop_up').style.display = 'block';
                                document.getElementById('fade').style.display = 'block'">view</a>
                       <?php
                       echo '</td>';
                       echo '</tr>';
                   }
                   /* <a href="'.site_url("admin").'/user/delete/'.$row['user_id'].'" class="btn btn-danger complexConfirm">delete</a> */
                   ?>
                </tbody>
            </table>

            <?php
            $this->session->set_userdata('redirect_url', current_url());
            echo '<div class="pagination">' . $this->pagination->create_links() . '</div>';
            ?>

        </div>
    </div>
    <div id="pop_up" class="white_content">
        <div style="width: 100%; float: left;">
            <div class="bill_close">
                <a href = "javascript:void(0)" onclick = "document.getElementById('pop_up').style.display = 'none';
                        document.getElementById('fade').style.display = 'none'">Close</a>
            </div>
            <div class="list_head"></div>
            <div style="width: 100%">
                <div style="width: 25%; float: right; font-size: 14px; margin-top: 10px; font-weight: bold">
                    <div class="label_total">Total Price:</div>
                    <div class="value_total"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="fade" class="black_overlay"></div>
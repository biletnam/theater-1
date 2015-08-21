<script>
    function orderView(e) {
        var order_id = $(e).attr('data-id');
        $.ajax({
            url: base_url + 'admin_operator_list/view_order_detail',
            type: "POST",
            data: {order_id: order_id},
            success: function(data) {
                //console.log(data);
                $('.list_head').html(data);
                var sum_qua = 0;
                $('.total_coast').each(function()
                {
                    sum_qua += parseInt($(this).text());
                });
                $('.value_total').text(sum_qua);

                var quantity = 0;
                $('.quantity').each(function()
                {
                    quantity += parseInt($(this).text());
                });
                $('.qua_value').text(quantity);

                $('.discount').each(function()
                {
                    discount = parseInt($(this).text());
                });
                var disc = sum_qua * discount / 100
                $('.value_discount').text(disc);

                $('.grand_total').each(function()
                {
                    grand_total = parseInt($(this).text());
                });
                $('.value_grand').text(grand_total);
            },
            error: function() {
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
        height: 50%;
        padding: 16px;
        border: 16px solid orange;
        background-color: white;
        z-index:1002;
        overflow: auto;
    }
    .list_head{ width: 100%}
    .list_head div{ width: 16%; float: left; border-bottom: 1px solid #CCC; text-align: center;}
    .bill_close{ text-align: center; margin-bottom: 10px;}
    .bill_close a{ background-color: #ccc; padding: 5px 10px;}
    .label_total{ float: left; width: 40%}
    .value_total{ float: left; width: 60%}
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

    <div class="page-header users-header">
        <h2>Operator List
            <?php //echo ucfirst($this->uri->segment(2)); ?>

<!--            <a  href="<?php //echo site_url("admin") . '/' . $this->uri->segment(2);                                  ?>/add" class="btn btn-success">Add a new</a>-->
            <?php /* ?> <a style="margin-right:30px;" href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/exportcsv" class="btn btn-info">Export User</a> <?php */ ?>
        </h2>
    </div>

    <div class="row">
        <div class="span12 columns">
            <!--            <div class="well">-->

            <?php
//                $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
//
////save the columns names in a array that we will use as filter
//                $options_keyword = array();
//                foreach ($user as $array) {
//                    foreach ($array as $key => $value) {
//                        $options_keyword[$key] = $key;
//                    }
//                    break;
//                }
//
//                echo form_open('admin/operator_list', $attributes);
//
//                echo form_label('Search:', 'search_string');
//                echo form_input('search_string', $search_string_selected);
//
            ?>
<!--                <select name="order" class="span2">
                    <option //<?php echo ($order == 'firstname') ? 'selected="selected"' : "" ?> value="firstname">Firstname</option>
                    <option //<?php echo ($order == 'lastname') ? 'selected="selected"' : "" ?> value="lastname">Lastname</option>
                    <option //<?php echo ($order == 'username') ? 'selected="selected"' : "" ?> value="username">Username</option>
                    <option //<?php echo ($order == 'primary_email') ? 'selected="selected"' : "" ?> value="primary_email">Primary E-mail</option>
                    <option //<?php echo ($order == 'status') ? 'selected="selected"' : "" ?> value="status">Status</option>
                </select>-->
            <?php
//                echo form_label('Order by:', 'order');
//// echo form_dropdown('order', $options_keyword, $order, 'class="span2"');
//
//                $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');
//
//                $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
//                echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');
//
//                echo form_submit($data_submit);
//                if ($search_string_selected) {
//                    echo '<a style="margin-left: 12px;vertical-align: middle;" class="btn" href="' . site_url("admin/operator_list/") . '">Reset</a>';
//                }
//                echo form_close();
//
            ?>

            <!--            </div>-->

            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th class="header">Order Id</th>
                        <th class="yellow header headerSortDown">Customer Id</th>
                        <th class="yellow header headerSortDown">Total</th>
                        <th class="yellow header headerSortDown">quantity</th>
                        <th class="yellow header headerSortDown">Discount</th>
                        <th class="yellow header headerSortDown">Payment Mode</th>
                        <th class="yellow header headerSortDown">Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($operator_order as $row) {
                        $date = date('d/m/Y', $row['datetime']);
                        echo '<tr>';
                        echo '<td>' . $row['order_id'] . '</td>';
                        echo '<td>' . $row['customer_id'] . '</td>';
                        echo '<td>' . $row['total_amount'] . '</td>';
                        echo '<td>' . $row['quantity'] . '</td>';
                        echo '<td>' . $row['discount'] . '</td>';
                        echo '<td>' . $row['payment_mode'] . '</td>';
                        echo '<td>' . $date . '</td>';
                        echo '<td style="text-align:center;" class="crud-actions">';
                        ?>
                    <a id="data_view" data-id="<?php echo $row['order_id']; ?>" href="javascript:void(0)" class="btn btn-info data_view" onclick = "orderView(this);
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
                <div style="float: left; width: 50%; margin-top: 10px; font-size: 14px; font-weight: bold">
                    <div class="qua_label">Total Quantity :</div>
                    <div class="qua_value"></div>
                </div>
                <div style="width: 40%; float: right; font-size: 14px; margin-top: 10px; font-weight: bold">
                    <div class="label_total">Total :</div>
                    <div class="value_total"></div>
                    <div class="label_discount">Desc :</div>
                    <div style="float: left;">-</div>
                    <div class="value_discount"></div>
                    <div>-------------------------------</div>
                    <div class="label_grand">Grand Total :</div>
                    <div class="value_grand"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="fade" class="black_overlay"></div>
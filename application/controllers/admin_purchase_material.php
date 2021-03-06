<?php

class Admin_purchase_material extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    //const VIEW_FOLDER = 'admin/user';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('purchase_material_model');
        $this->load->model('operator_model');
        $this->load->model('material_model');
        $this->load->model('common_model');
        $this->load->library('session');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {
        $this->session->set_userdata('total_quantity');
        $data['main_content'] = 'admin/purchase_meterial/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function get_row_matetial_by_category() {
        $row_material = $this->material_model->get_row_matetial_item();
        $html = "<table>";
        foreach ($row_material as $row_material_item) {
            echo "<tr><td><a onclick='myid(this);load(this)' data-id=" . $row_material_item['item_row_material_id'] . " href='javascript:void(0)'><img class='product_img' src='" . site_url() . "assets/img/admin/ico/categoryico.png'></a></td><td style='float:left;'><a href='javascript:void(0)'>" . $row_material_item['name'] . "</a></td></tr>";
        }
        "</table>";
    }

    public function get_row_material() {
        $products_id = $this->input->post('products_id');
        $product_detail = $this->material_model->get_row_matetial_item_by_id($products_id);
        $item_list = "<div>";
        foreach ($product_detail as $detail) {
            $uom_val = $detail['uom'];
            $where = " AND uom_id={$uom_val}";
            $uom_unit = $this->common_model->getFieldData('uom', 'uom', $where);

            if ($uom_unit == "KG" || $uom_unit == "GM") {
                $where_uom_id = " AND (uom_id='" . KG_VAL . "' OR uom_id = '" . GM_VAL . "')";
            } else {
                $where_uom_id = " AND (uom_id='" . LTR_VAL . "' OR uom_id = '" . ML_VAL . "')";
            }
            $data['uom_opt'] = $uom_opt = $this->common_model->getDDArray('uom', 'uom_id', 'uom', $where_uom_id, FALSE, 'uom_id');
            unset($data['uom_opt']['']);
            unset($uom_opt['']);
            $detail['qty'] = 1;
            $detail['total'] = $detail['price'];
            $detail['uom'] = $uom_unit;
            // bhushan changes
            $detail['uom_id'] = $uom_val;
            //end changes
            $array = array($products_id => $detail);
            $data = $this->session->userdata('my_order');
            $data[$products_id] = $detail;
            $this->session->set_userdata('my_order', $data);
            ?>
            <div href="javascript:void(0)" class='item_name'><?php echo $detail['title'] ?></div>
            <a onclick="myAddClass(this)" href="javascript:void(0)" class='item_qua current qua_css'>1.00</a>
            <a onclick="myAddClass(this)" href="javascript:void(0)" class="append_qua abc"></a>
            <div class="uom_tit" href="javascript:void(0)">
                <?php
                $js = "perUom(this)";
                $attribute = 'id="uom"  onchange="' . $js . '" href="javascript:void(0)"';
                echo form_dropdown('uom', $uom_opt, $uom_val, $attribute);
                ?>

                <?php //echo $uom_unit  ?></div>
            <div class="price_tit" href="javascript:void(0)"><?php echo $detail['price'] ?></div>
            <div href="javascript:void(0)" data-uom="<?php echo $detail['uom'] ?>" data-uom-id="<?php echo $detail['uom_id'] ?>" data-title='<?php echo $detail['title'] ?>' data-fix='<?php echo $detail['price'] ?>' data-price='<?php echo $detail['price'] ?>' class='item_price curr_price item_price_css'><?php echo $detail['price'] ?></div>
            <a onclick="removeItem(this)" class="cancel_btn" href="javascript:void(0)">X</a>
            <?php
        }
        echo "</div>";
        ?>
        <?php
    }

    public function place_order() {
        $user_id = $this->session->userdata('user_id');
        $session_data = $this->session->userdata('my_order');
        $sum_total_quantity = 0;
        foreach ($session_data as $session_data_val) {
            $uom = $session_data_val['uom'];
            $perQuantity = $session_data_val['qty'];
            if ($uom == "KG" || $uom == "LTR") {
                $total_quantity = $perQuantity * 1000;
            } else {
                $total_quantity = $perQuantity;
            }
            $sum_total_quantity +=$total_quantity;

            $sum_total_quantity_arr['total_qty'] = $sum_total_quantity;
        }

        $order = array(
            'total_amount' => $this->input->post('total_amount'),
            'datetime' => time(),
            'total_quantity' => $sum_total_quantity_arr['total_qty'],
            'user_id' => $user_id
        );

        $last_insert_id = $this->purchase_material_model->store_purchase_material($order);
        if (!empty($session_data)) {
            foreach ($session_data as $value) {
                $uom = $value['uom'];
                $perQuantity = $value['qty'];
                if ($uom == "KG") {
                    $convertedUom = "GM";
                } else if ($uom == "LTR") {
                    $convertedUom = "ML";
                } else {
                    $convertedUom = $uom;
                }

                if ($uom == "KG" || $uom == "LTR") {
                    $quantity = $perQuantity * 1000;
                } else {
                    $quantity = $perQuantity;
                }
                $order_detail = array(
                    "item_row_material_purchase_id" => $last_insert_id,
                    "products_id" => $value['products_id'],
                    "name" => $value['title'],
                    "cost" => $value['price'],
                    "qty" => $quantity,
                    "uom" => $value['uom'],
                    "total" => $value['total'],
                    'datetime' => time(),
                );
                $row_material_detail = $this->material_model->get_row_matetial_item_by_id($value['products_id']);
                $initialQty = @$row_material_detail[0]['qty'];
                $updatedQty = $initialQty + $value['qty'];
                $update_row_material = array(
                    "qty" => $updatedQty,
                );
                $this->purchase_material_model->store_purchase_material_detail($order_detail);
                $this->material_model->update_material($update_row_material, $value['products_id']);
                //mehul 31-08-2015
                $inventory_data = $this->purchase_material_model->get_data_from_inventory($value['title']);
                if (empty($inventory_data)) {
                    $arr_insert = array(
                        "name" => $value['title'],
                        "qua" => $quantity,
                        "uom" => $convertedUom,
                        "total_cost" => $value['total'],
                    );
                    $this->purchase_material_model->addProductInventory($arr_insert);
                } else {
                    $where = "AND name='" . $value['title'] . "'";
                    $qua_inv = $this->common_model->getFieldData('inventory', 'qua', $where);

                    $where = "AND name='" . $value['title'] . "'";
                    $new_total = $this->common_model->getFieldData('inventory', 'total_cost', $where);

                    $new_qua = $qua_inv + $quantity;
                    $new_total = $new_total + $value['total'];
                    $arr = array(
                        "qua" => $new_qua,
                        "total_cost" => $new_total,
                    );
                    $this->purchase_material_model->update_inventory_by_purchase_material($value['title'], $arr);
                }

                //mehul 31-08-2015
            }
        }
    }

    public function get_all_row_material() {
        $product_meterial = $this->material_model->get_row_matetial_item();
        $html = "<table>";
        foreach ($product_meterial as $product_meterial_item) {
            $product_images = $product_meterial_item['images'];
            echo "<tr><td><a class='item_" . $product_meterial_item['products_id'] . "' onclick='myid(this)' data-id=" . $product_meterial_item['products_id'] . " href='javascript:void(0)'><img class='product_img' src='" . site_url() . "uploads/images/" . $product_images . "'></a></td><td style='float:left;'><a href='javascript:void(0)'>" . $product_meterial_item['title'] . "</a></td></tr>";
        }
        "</table>";
    }

    public function unset_session() {
        $product_id = $this->input->post('data_id');
        $data = $this->session->userdata('my_order');
        unset($data[$product_id]);
        $this->session->set_userdata('my_order', $data);
        $data = $this->session->userdata('my_order');
    }

    public function update_session() {

        $product_id = $this->input->post('product_id');
        $product_quantity = $this->input->post('add_count');
        $total = $this->input->post('total_product_price');
        $product_name = $this->input->post('product_name');
        $fix_price = $this->input->post('fix_price');
        $uom = $this->input->post('uom');
        $uom_id = $this->input->post('uom_id');

//$final_total = $this->input->post('final_total');
        $arr = array(
            "products_id" => $product_id,
            "title" => $product_name,
            "price" => $fix_price,
            "qty" => $product_quantity,
            "uom" => $uom,
            "uom_id" => $uom_id,
            "total" => $total
        );

        $array = array($product_id => $arr);
        $data = $this->session->userdata('my_order');
        $data[$product_id] = $arr;
        $this->session->set_userdata('my_order', $data);
    }

    public function delete_session() {
        $this->session->unset_userdata('my_order');
    }

}

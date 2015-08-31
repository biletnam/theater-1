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
        //$final_total = $this->input->post('final_total');
        $item_list = "<div>";
        foreach ($product_detail as $detail) {
            $detail['qty'] = 1;
            $detail['total'] = $detail['cost'];
            $detail['uom'] = $detail['uom'];
            $array = array($products_id => $detail);
            $data = $this->session->userdata('my_order');
            $data[$products_id] = $detail;
            $this->session->set_userdata('my_order', $data);
            ?>
            <div href="javascript:void(0)" class='item_name'><?php echo $detail['name'] ?></div>
            <a onclick="myAddClass(this)" href="javascript:void(0)" class='item_qua current qua_css'>1.00</a>
            <a onclick="myAddClass(this)" href="javascript:void(0)" class="append_qua abc"></a>
            <div class="uom_tit" href="javascript:void(0)"><?php echo $detail['uom'] ?></div>
            <div class="price_tit" href="javascript:void(0)"><?php echo $detail['cost'] ?></div>
            <div href="javascript:void(0)" data-uom="<?php echo $detail['uom'] ?>" data-title='<?php echo $detail['name'] ?>' data-fix='<?php echo $detail['cost'] ?>' data-price='<?php echo $detail['cost'] ?>' class='item_price curr_price item_price_css'><?php echo $detail['cost'] ?></div>
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
        $order = array(
            'total_amount' => $this->input->post('total_amount'),
            'datetime' => time(),
            'total_quantity' => $this->input->post('total_quantity'),
            'user_id' => $user_id
        );

        $last_insert_id = $this->purchase_material_model->store_purchase_material($order);
        if (!empty($session_data)) {
            foreach ($session_data as $value) {
                $order_detail = array(
                    "item_row_material_purchase_id" => $last_insert_id,
                    "item_row_material_id" => $value['item_row_material_id'],
                    "name" => $value['name'],
                    "cost" => $value['cost'],
                    "qty" => $value['qty'],
                    "uom" => $value['uom'],
                    "total" => $value['total'],
                    'datetime' => time(),
                );
                $row_material_detail = $this->material_model->get_row_matetial_item_by_id($value['item_row_material_id']);
                $initialQty = @$row_material_detail[0]['qty'];
                $updatedQty = $initialQty + $value['qty'];
                $update_row_material = array(
                    "qty" => $updatedQty,
                );
                $this->purchase_material_model->store_purchase_material_detail($order_detail);
                $this->material_model->update_material($update_row_material, $value['item_row_material_id']);
            }
        }
    }

    public function get_all_row_material() {
        $row_material = $this->material_model->get_row_matetial_item();
        $html = "<table>";
        foreach ($row_material as $row_material_item) {
            echo "<tr><td><a class='item_" . $row_material_item['item_row_material_id'] . "' onclick='myid(this)' data-id=" . $row_material_item['item_row_material_id'] . " href='javascript:void(0)'><img class='product_img' src='" . site_url() . "assets/img/admin/ico/categoryico.png'></a></td><td style='float:left;'><a href='javascript:void(0)'>" . $row_material_item['name'] . "</a></td></tr>";
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
        //$final_total = $this->input->post('final_total');
        $arr = array(
            "item_row_material_id" => $product_id,
            "name" => $product_name,
            "cost" => $fix_price,
            "qty" => $product_quantity,
            "uom" => $uom,
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

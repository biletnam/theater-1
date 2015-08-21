<?php

class Admin_operator extends CI_Controller {
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
        $this->load->model('operator_model');
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
//        echo "<pre>";
//        print_r($this->session->all_userdata());
//        die;
        //echo "</pre>";
        //$this->session->set_userdata('final_total');
        $this->session->set_userdata('total_quantity');
        $data['category'] = $this->operator_model->get_category();
        $session_arr = $this->session->all_userdata();
        $data['operator_id'] = $session_arr['user_id'];
        //echo "<pre>"; print_r($data['category']); die;
        $data['main_content'] = 'admin/operator_view';
        $this->load->view('admin/includes/template', $data);
    }

    public function get_product_by_category() {
        //echo "<pre>"; print_r($_POST); die;
        $category_id = $this->input->post('category_id');
        $product = $this->operator_model->get_product($category_id);
        //echo "<pre>"; print_r($product); die;
        $html = "<table>";
        foreach ($product as $pro) {
            echo "<tr><td><a onclick='myid(this);load(this)' data-id=" . $pro['products_id'] . " href='javascript:void(0)'><img class='product_img' src='" . site_url() . "uploads/images/" . $pro['images'] . "'></a></td><td style='float:left;'><a href='javascript:void(0)'>" . $pro['title'] . "</a></td></tr>";
        }
        "</table>";
    }

    public function get_product() {
        $products_id = $this->input->post('products_id');
        $product_detail = $this->operator_model->get_product_detail_by_product_id($products_id);
        //$final_total = $this->input->post('final_total');
        $item_list = "<div>";
        foreach ($product_detail as $detail) {
            $detail['quantity'] = 1;
            $detail['total'] = $detail['price'];
            $array = array($products_id => $detail);
            //$this->session->set_userdata($products_id, $detail);
            $data = $this->session->userdata('my_order');
            $data[$products_id] = $detail;
            $this->session->set_userdata('my_order', $data);
            ?>
            <div href="javascript:void(0)" class='item_name'><?php echo $detail['title'] ?></div>
            <a onclick="myAddClass(this)" href="javascript:void(0)" class='item_qua current qua_css'>1</a><a onclick="myAddClass(this)" href="javascript:void(0)" class="append_qua abc"></a>
            <div class="price_tit" href="javascript:void(0)"><?php echo $detail['price'] ?></div>
            <div href="javascript:void(0)" data-title='<?php echo $detail['title'] ?>' data-fix='<?php echo $detail['price'] ?>' data-price='<?php echo $detail['price'] ?>' class='item_price curr_price item_price_css'><?php echo $detail['price'] ?></div>
            <a onclick="removeItem(this)" class="cancel_btn" href="javascript:void(0)">X</a>
            <?php
        }
        echo "</div>";
        ?>
        <?php
//        echo "<pre>";
//        print_r($this->session->all_userdata());
//        die;
    }

    public function place_order() {
        $session_arr = $this->session->all_userdata();
        $user_id = $session_arr['user_id'];
        $order = array(
            'total_amount' => $this->input->post('total_amount'),
            'datetime' => time(), //$this->input->post('time_date'),
            'discount' => $this->input->post('discount'),
            'payment_mode' => $this->input->post('payment_mode'),
            'quantity' => $this->input->post('quantity'),
            'grand_amount' => $this->input->post(grand_amount),
            'user_id' => $user_id
        );
        $last_insert_id = $this->operator_model->addOrder($order);

        $data = $this->session->userdata('my_order');
        if (!empty($data)) {
            foreach ($data as $value) {
                $order_detail = array(
                    "order_id" => $last_insert_id,
                    "product_id" => $value['products_id'],
                    "product_title" => $value['title'],
                    "quantity" => $value['quantity'],
                    "cost" => $value['total'],
                    'datetime' => time(),
                );
                $this->operator_model->addOrderDetail($order_detail);
            }
        }
    }

    public function get_all_product() {
        $products = $this->operator_model->get_products();
        //echo "<pre>"; print_r($products); die;
        $html = "<table>";
        foreach ($products as $product) {
            //echo "<pre>"; print_r($product); die;
            //$id = str_replace(' ', '_', $pro['title']);

            echo "<tr><td><a class='item_" . $product['products_id'] . "' onclick='myid(this)' data-id=" . $product['products_id'] . " href='javascript:void(0)'><img class='product_img' src='" . site_url() . "uploads/images/" . $product['images'] . "'></a></td><td style='float:left;'><a href='javascript:void(0)'>" . $product['title'] . "</a></td></tr>";
        }
        "</table>";
    }

    public function get_operator_data() {
        $operator_user_id = $this->input->post('operator_id');
        $total = $this->operator_model->get_operator_report($operator_user_id);
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
        //$final_total = $this->input->post('final_total');
        $arr = array(
            "products_id" => $product_id,
            "title" => $product_name,
            "price" => $fix_price,
            "quantity" => $product_quantity,
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

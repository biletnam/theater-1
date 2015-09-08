<?php

class Admin_purchase_details_data extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    const VIEW_FOLDER = 'admin/purchase_details_data';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('purchase_details_data_model');

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }

        if (!Access_level::get_access('purchase_details_data')) {
            redirect('admin/dashboard');
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {
//        echo $this->uri->segment(3);
//        die;
//        if ($this->uri->segment(3)) {
//            $user_id = $this->uri->segment(3);
//        } else {
//            $session_arr = $this->session->all_userdata();
//            $user_id = $session_arr['user_id'];
//        }
        $session_arr = $this->session->all_userdata();
        $user_id = $session_arr['user_id'];
        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/purchase_details_data';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0) {
            $limit_end = 0;
        }

        //if order type was changed
        if ($order_type) {
            $filter_session_data['order_type'] = $order_type;
        } else {
            //we have something stored in the session?
            if ($this->session->userdata('order_type')) {
                $order_type = $this->session->userdata('order_type');
            } else {
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'DESC';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data
        //filtered && || paginated
        if ($search_string !== false && $order !== false || $this->uri->segment(3) == true) {

            /*
              The comments here are the same for line 79 until 99

              if post is not null, we store it in session data array
              if is null, we use the session data already stored
              we save order into the the var to load the view with the param already selected
             */
            if ($search_string) {
                $filter_session_data['search_string_selected'] = $search_string;
            } else {
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if ($order) {
                $filter_session_data['order'] = $order;
            } else {
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if (isset($filter_session_data)) {
                $this->session->set_userdata($filter_session_data);
            }

            //fetch sql data into arrays
            $data['count_products'] = $this->purchase_details_data_model->count_user($search_string, $order, $user_id);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['user'] = $this->purchase_details_data_model->get_user($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['user'] = $this->purchase_details_data_model->get_user($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['user'] = $this->purchase_details_data_model->get_user('', $order, $order_type, $config['per_page'], $limit_end, '');
                } else {
                    $data['user'] = $this->purchase_details_data_model->get_user('', '', $order_type, $config['per_page'], $limit_end, '');
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['user_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->purchase_details_data_model->count_user(null, null, $user_id);
            $data['user'] = $this->purchase_details_data_model->get_user(null, null, $order_type, $config['per_page'], $limit_end, '');
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/purchase_details_data/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function view_order_detail() {
        $item_row_material_purchase_id = $this->input->post('item_row_material_purchase_id');

        $order_detail_data = $this->purchase_details_data_model->get_order_detail_by_order_id($item_row_material_purchase_id);
//        echo "<pre>";
//        print_r($order_detail_data);
//        exit;
//        $grand = $this->purchase_details_data_model->get_order_grand_total_by_order_id($item_row_material_purchase_id);
//        $grand_total = $grand[0]['grand_amount'];
        ?>
        <div>Title</div>
        <div>Quantity</div>
        <div>UOM</div>
        <div>Fixed Price</div>
        <div>Cost</div>
        <?php
        foreach ($order_detail_data as $data) {
            $uom = $data['uom'];
            $qty = $data['qty'];
            if ($uom == "KG" || $uom == "LTR") {
                $convertedQty = $qty / 1000;
            } else {
                $convertedQty = $qty;
            }
            $product_price = $this->purchase_details_data_model->get_product_price_by_product_id($data['products_id']);
            $fix_price = $product_price[0]['price'];
            ?>
            <div><?php echo $data['name']; ?></div>
            <div class="quantity"><?php echo $convertedQty; ?></div>
            <div class="quantity"><?php echo $uom; ?></div>
            <div><?php echo $fix_price; ?></div>
            <div class="total_coast"><?php echo $data['total']; ?></div>
            <!--            <div class="discount"><?php echo $discount ?></div>
            <div class="grand_total"><?php echo $grand_total ?></div>-->
            <?php
        }
    }

}

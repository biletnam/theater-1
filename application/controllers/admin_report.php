<?php

class Admin_report extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    const VIEW_FOLDER = 'admin/report';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('report_model');

        $this->load->helper('url');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }

        if (!Access_level::get_access('company')) {

            redirect('admin/dashboard');
        }
        $this->load->model('user_role_extended_model');
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/report';
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
        $data['all_products'] = $this->report_model->getAllProducts();

        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/report/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function search() {
        $is_search = $this->input->post('is_search');
        $today = date('Y-m-d');
        if ($today == $this->input->post('end_date')) {
            $end_date = time();
        } else {
            $end_date = strtotime($this->input->post('end_date'));
        }
        $end_date = strtotime("tomorrow", $end_date) - 1;
        $start_date = strtotime($this->input->post('start_date'));
        $product_name = $this->input->post('product_name');
        if ($is_search == "search") {
            $data['search_product'] = $abc = $this->report_model->getOrderDataBetweenTwoDates($product_name, $start_date, $end_date);
            $total = 0;
            $qua = 0;
            foreach ($abc as $value) {
                $total = $total + $value['cost'];
                $qua = $qua + $value['quantity'];
            }
            $data['sub_total'] = $total;
            $data['quantity'] = $qua;
        } else {
            $do_export = $this->input->post('do_export');
            $this->db->select('*');
            $this->db->from('order_detail');
            $this->db->where('product_title', $product_name);
            $this->db->where('datetime >=', $start_date);
            $this->db->where('datetime <=', $end_date);
            $query = $this->db->get();
            $rs_users = $query->result_array();

            $currentDate = date('Y-m-d_H-i-s');
            $fname = 'sales_' . $currentDate . '.xls';
            $filepath = './uploads/export_csv/' . $fname;
            $heading_row = array('Product Title', 'Quantity', 'Cost', 'Date');
            $header = '';
            $data = '';
            $value = '';

            for ($h = 0; $h < count($heading_row); $h++) {
                $header .= $heading_row[$h] . "\t";
            }

            if (count($rs_users) > 0) {
                for ($c = 0; $c < count($rs_users); $c++) {
                    $line = '';
                    $date_order = date('m/d/Y', $rs_users[$c]['datetime']);
                    $product_title = (!empty($rs_users[$c]['product_title']) ? $rs_users[$c]['product_title'] : "");
                    $quantity = (!empty($rs_users[$c]['quantity']) ? $rs_users[$c]['quantity'] : "");
                    $cost = (!empty($rs_users[$c]['cost']) ? $rs_users[$c]['cost'] : "" );
                    $date = (!empty($date_order) ? $date_order : "");

                    $content_row = array();
                    $content_row = array($product_title, $quantity, $cost, $date);
                    for ($a = 0; $a < count($content_row); $a++) {

                        if ((!isset($content_row[$a]) ) || ( $content_row[$a] == "" )) {
                            $value = "\t";
                        } else {
                            $value = $content_row[$a] . "\t";
                        }
                        $line .= $value;
                    }

                    $data .= trim($line) . "\n";
                }
            }
            header("Content-type:application/octet-stream");
            header("Content-Disposition:attachment;filename=$fname");
            header("Pragma: no-cache");
            header("Expires: 0");
            print "$header\n$data";
            //echo file_get_contents($filepath);
            //unlink($filepath);
            exit;
        }
        $data['main_content'] = 'admin/report/list_view';
        $this->load->view('admin/includes/template', $data);
    }

}

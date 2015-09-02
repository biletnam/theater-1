<?php

class Admin_purchase_report_today extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    const VIEW_FOLDER = 'admin/purchase_report_today';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('purchase_report_model');

        $this->load->helper('url');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }

        if (!Access_level::get_access('purchase_report_today')) {

            redirect('admin/dashboard');
        }
        $this->load->model('user_role_extended_model');
    }

    /**
     * Load the main view with all the current model model's data.
     * @return void
     */
    public function index() {

        //all the products sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/purchase_report_today';
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
        $start_of_day = time() - 86400 + (time() % 86400);
        $end_of_day = $start_of_day + 86400;

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
            //echo "search_c->". $search_string; die;
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
            $data['count_data'] = $this->purchase_report_model->count_today_sale($start_of_day, $end_of_day, $search_string, $order);
            $config['total_rows'] = $data['count_data'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['today_sale'] = $this->purchase_report_model->get_today_sale($start_of_day, $end_of_day, $search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['today_sale'] = $this->purchase_report_model->get_today_sale($start_of_day, $end_of_day, $search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['today_sale'] = $this->purchase_report_model->get_today_sale($start_of_day, $end_of_day, '', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['today_sale'] = $this->purchase_report_model->get_today_sale($start_of_day, $end_of_day, '', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['today_data_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';


            //fetch sql data into arrays
            $data['count_today_sale'] = $this->purchase_report_model->count_today_sale($start_of_day, $end_of_day);
            $data['today_sale'] = $this->purchase_report_model->get_today_sale($start_of_day, $end_of_day, '', '', $order_type, $config['per_page'], $limit_end);

            $config['total_rows'] = $data['count_today_sale'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/purchase_report_today/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function exportcsv() {
        $do_export = $this->input->post('do_export');
        $start_of_day = time() - 86400 + (time() % 86400);
        $end_of_day = $start_of_day + 86400;
        if (!empty($do_export)) {
            $this->db->select('*');
            $this->db->from('item_row_material_purchase_details');
            $this->db->where('datetime >=', $start_of_day);
            $this->db->where('datetime <=', $end_of_day);
            $this->db->where('status', 'Active');
            $query = $this->db->get();
            $rs_users = $query->result_array();

            $currentDate = date('Y-m-d_H-i-s');
            $fname = 'purchase_today_' . $currentDate . '.xls';
            $filepath = './uploads/export_csv/' . $fname;
            $heading_row = array('Material Name', 'Quantity', 'Cost', 'UOM', 'Total', 'Date');
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
                    $product_title = (!empty($rs_users[$c]['name']) ? $rs_users[$c]['name'] : "");
                    $quantity = (!empty($rs_users[$c]['qty']) ? $rs_users[$c]['qty'] : "");
                    $cost = (!empty($rs_users[$c]['cost']) ? $rs_users[$c]['cost'] : "" );
                    $uom = (!empty($rs_users[$c]['uom']) ? $rs_users[$c]['uom'] : "" );
                    $total = (!empty($rs_users[$c]['total']) ? $rs_users[$c]['total'] : "" );
                    $date = (!empty($date_order) ? $date_order : "");

                    $content_row = array();
                    $content_row = array($product_title, $quantity, $cost, $uom, $total, $date);
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
        $data['main_content'] = 'admin/purchase_report_today/list';
        $this->load->view('admin/includes/template', $data);
    }

}

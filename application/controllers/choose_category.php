<?php

class Choose_category extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('choose_category_model');
        $this->load->model('common_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
//redirect('admin/login');
        }
    }

    public function choosecatdata() {
//        echo "<pre>";
//        print_r($this->session->all_userdata());exit;

        $data['cate'] = $categ_id = $this->uri->segment(3);
        $data['city_id'] = $this->uri->segment(4);
        $data['name'] = $this->uri->segment(5);

        $session = array(
            'category' => $categ_id,
        );
        $this->session->set_userdata($session);
        $data['cat'] = $this->choose_category_model->getAllSubcategory($categ_id);
        $where_subcategory = " AND category_id={$categ_id}";
        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);
        $data['main_content'] = 'choose_category_view';
        $this->load->view('includes/template', $data);
    }

}
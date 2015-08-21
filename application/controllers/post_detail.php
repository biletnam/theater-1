<?php

class Post_detail extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('post_detail_model');
        $this->load->model('common_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {
        $this->load->helper('url');
    }

    function getPostdetails() {
        $data['posts_id'] = $posts_id = $this->uri->segment(3);
        $data['parent_id'] = $parent = $this->uri->segment(4);
        $post_city = $this->uri->segment(5);
        if (isset($parent) && !empty($parent)) {
            $cetegory_id = $parent;
        } else {
            $cetegory_id = $this->session->userdata('stack_category_id');
        }
        $state_id = $this->session->userdata('stack_state_id');

        if (isset($post_city) && !empty($post_city)) {
            $data['city_id'] = $city_id = $post_city;
        } else {
            $data['city_id'] = $city_id = $this->session->userdata('stack_city_id');
        }
        if (isset($state_id) && !empty($state_id)) {
            $whereCat = " AND category={$cetegory_id} AND state={$state_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);
            $data['sub_category_id'] = $sub_cat = $subcategory;
        } else {
            $whereCat = " AND category={$cetegory_id} AND city={$city_id}";
            $subcategory = $this->common_model->getFieldData('posts', 'subcategory', $whereCat);
            $data['sub_category_id'] = $sub_cat = $subcategory;

//            $sub_cat = $this->session->userdata('stack_subcategory_id');
        }

        if (isset($state_id) && !empty($state_id)) {

            $where = " AND subcategory={$sub_cat} AND state={$state_id} AND payment_status='complete'";
            $city = $this->common_model->getFieldData('posts', 'city', $where);
            $whereCity = " AND city_id={$city}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $whereCity);
        } else {

            $where = " AND city_id={$city_id}";
            $data['city_name'] = $this->common_model->getFieldData('city', 'city_name', $where);
        }

        $where_category = " AND category_id={$cetegory_id}";

        $data['category'] = $this->common_model->getFieldData('category', 'category_name', $where_category);

        $where_subcategory = " AND category_id={$sub_cat}";

        $data['subcategory'] = $this->common_model->getFieldData('category', 'category_name', $where_subcategory);

        $data['des'] = $this->post_detail_model->getPostdetail($posts_id);
        $data['city_opt'] = $this->common_model->getDDArray('city', 'city_id', 'city_name');
        $data['main_content'] = 'post_detail_view';
        $this->load->view('includes/template', $data);
    }

    /**
     * encript the password
     * @return mixed
     */
}
<?php

class Admin_category extends CI_Controller {
    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */

    const VIEW_FOLDER = 'admin/category';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('category_model');

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('category')) {
            redirect('admin/dashboard');
        }
        
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

        $config['base_url'] = base_url() . 'admin/category';
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
            $data['count_products'] = $this->category_model->count_category($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['category'] = $this->category_model->get_category($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['category'] = $this->category_model->get_category($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['category'] = $this->category_model->get_category('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['category'] = $this->category_model->get_category('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

            //clean filter data inside section
            $filter_session_data['category_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products'] = $this->category_model->count_category();
            $data['category'] = $this->category_model->get_category('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/category/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function add() {

        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

//            $this->form_validation->set_rules('parent_id', 'category', 'required');
            $this->form_validation->set_rules('category_name', 'category_name', 'required');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {

                if ($_POST['parent_id'] != 0) {
                    $path1 = addslashes($this->category_model->getCategoryPathById($_POST['parent_id'])) . " > ";
                    $path = $path1 . $_POST['category_name'];
                } else {
                    $path = $_POST['category_name'];
                }
                //echo "<pre>";
                //echo $path;
                //print_r($path);
                //exit;
                $data_to_store = array(
                    'category_name' => isset($_POST['category_name']) ? $_POST['category_name'] : "",
                    'parent_id' => isset($_POST['parent_id']) ? $_POST['parent_id'] : "",
                    'path' => $path,
                    
                );
                //if the insert has returned true then we show the flash message
                if ($this->category_model->store_category($data_to_store)) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/category/');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
        $data['main_content'] = 'admin/category/add';
        $this->load->view('admin/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id
        $id = $this->uri->segment(4);
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
//            $this->form_validation->set_rules('parent_id', 'category', 'required');
            $this->form_validation->set_rules('category_name', 'category_name', 'required');
            
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
//if the form has passed through the validation
            if ($this->form_validation->run()) {
                //if the insert has returned true then we show the flash message
                $redirect_url = $this->input->post('redirect_url');
                if ($_POST['parent_id'] == 0) {
                    $cat_content = $this->category_model->getSubCategoryByParentId($_POST['category_id']);
                    for ($cat = 0; $cat < count($cat_content); $cat++) {
                        $path1 = addslashes($_POST['category_name']) . " > ";
                        $path = $path1 . $cat_content[$cat]['category_name'];
                        $data_to_store = array(
                            'path' => $path
                        );
                        $this->category_model->update_category_second($cat_content[$cat]['category_id'], $data_to_store);
                    }
                    $_POST['path'] = $_POST['category_name'];
                } else {
                    $path1 = addslashes($this->category_model->getCategoryPathById($_POST['parent_id'])) . " > ";
                    $path = $path1 . $_POST['category_name'];
                    $_POST['path'] = $path;
                }

                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }
                if ($this->category_model->update_category($id, $_POST) == TRUE) {
                    $this->session->set_flashdata('flash_message', 'updated');
                } else {
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }
                $this->session->set_flashdata('flash_message', 'update');
                redirect($redirect_url);
            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data
        //product data

        $data['category'] = $this->category_model->get_category_by_id($id);
        //echo "<pre>"; print_r($data['category']); die;
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
//        echo "<pre>";
//        print_r($data['par_cat_array']);
//        exit;
        $data['main_content'] = 'admin/category/edit';
        $this->load->view('admin/includes/template', $data);
    }

//update

    /**
     * Delete product by his id
     * @return void
     */
    public function delete() {
        //product id
        $id = $this->uri->segment(4);
        $this->category_model->delete_category($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('admin/category/');
    }

}

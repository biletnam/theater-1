<?php

class Admin_products extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    const VIEW_FOLDER = 'admin/products';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('products_model');
        $this->load->model('category_model');
        $this->load->model('common_model');
        $this->load->library('Common');
        $this->load->library('Upload');
        $this->load->library('upload');
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
        if (!Access_level::get_access('products')) {
            redirect('admin/dashboard');
        }
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

        $config['base_url'] = base_url() . 'admin/products';
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
            $data['count_products'] = $this->products_model->count_products($search_string, $order);
            $config['total_rows'] = $data['count_products'];

//fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['products'] = $this->products_model->get_products($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['products'] = $this->products_model->get_products($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['products'] = $this->products_model->get_products('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['products'] = $this->products_model->get_products('', '', $order_type, $config['per_page'], $limit_end);
                }
            }
        } else {

//clean filter data inside section
            $filter_session_data['products_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

//pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

//fetch sql data into arrays
            $data['count_products'] = $this->products_model->count_products();
            $data['products'] = $this->products_model->get_products('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
//initializate the panination helper
        $this->pagination->initialize($config);

//load the view
        $data['main_content'] = 'admin/products/list';
        $this->load->view('admin/includes/template', $data);
    }

    public function add() {
        $data['subcategory_opt'] = array("" => "Select");
        $data['subcategory'] = "";
        $data['category'] = "";
        $where = " AND parent_id= '0' ";
        $data['main_category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name', $where);

//$data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
//if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
//echo "<pre>"; print_r($_POST); die;
//form validation
//$this->form_validation->set_rules('country', 'country', 'required');
            $this->form_validation->set_rules('category_id', 'Main Category', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required|is_unique[products.title]');
            $this->form_validation->set_rules('price', 'Price', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
//if the form has passed through the validation
            if ($this->form_validation->run()) {

                $path = './uploads/images';
                $this->load->library('upload');
                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));
                if ($this->upload->do_multi_upload("images")) {
                    $file_name = $this->upload->get_multi_upload_data();
                    foreach ($file_name as $value) {
                        $images[] = $value['file_name'];
                    }
                }
                $_POST['images'] = implode(',', $images);
                if ($this->products_model->addPosts()) {
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/products/');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
        $data['main_content'] = 'admin/products/add';
        $this->load->view('admin/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
//echo "<pre>"; print_r($_POST); die;
        $id = $this->uri->segment(4);
        $cat_id = $this->uri->segment(5);
//if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('category_id', 'Category', 'required');
            $this->form_validation->set_rules('title', 'Title', 'required|edit_unique[products.title.' . $id . ']');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

            if ($this->form_validation->run()) {


                $this->load->library('upload');
                $path = './uploads/images';

                $this->upload->initialize(array(
                    "upload_path" => $path,
                    "allowed_types" => "*"
                ));
                if ($this->upload->do_multi_upload("images")) {

                    $file_name = $this->upload->get_multi_upload_data();
                    foreach ($file_name as $value) {
                        $images[] = $value['file_name'];
                    }

                    $_POST['images'] = implode(',', $images);
                } else {
                    $_POST['images'] = $this->input->post('old_image');
                }

//if the insert has returned true then we show the flash message
                $redirect_url = $this->input->post('redirect_url');
                foreach ($_POST as $k => $v) {
                    if (in_array($k, array('redirect_url'))) {
                        unset($_POST[$k]);
                    }
                }

                if ($this->products_model->update_products() == TRUE) {
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

        $where = " AND parent_id= '0' ";
        $data['main_category_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name', $where);
//$data['country_opt'] = $this->common_model->getDDArray('country', 'country_id', 'country_name');
        $data['products'] = $this->products_model->get_products_by_id($id);

        if ($data['products'][0]['category_id'] != "") {

            $where_subcategory = " AND parent_id!= '0' AND category_id='{$data['products'][0]['category_id']}'";
            $data['subcategory_opt'] = $this->common_model->getDDArray('category', 'category_id', 'category_name', $where_subcategory);
        }
//echo $id; die;
        $data['category'] = $this->category_model->get_category_by_id($cat_id);
//echo "<pre>"; print_r($data['category']); die;
        $data['par_cat_array'] = $this->category_model->getParentCategoryList(0, $old_cat = "", 0, 1, 5);
        $data['main_content'] = 'admin/products/edit';
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
        $this->products_model->delete_products($id);
        $this->session->set_flashdata('flash_message', 'delete');
        redirect('admin/products/');
    }

    public function ingredients() {
        $product_id = $data['product_id'] = $this->uri->segment(4);
//$data['products'] = $this->products_model->getAutocompleteProductList();
        $product_data = $this->products_model->get_products_by_id($product_id);
        $data['product_name'] = @$product_data[0]['title'];
        $data['all_ingr'] = $this->products_model->get_ingredients_data_by_product_id($product_id);
        $data['main_content'] = 'admin/products/ingr';
        $this->load->view('admin/includes/template', $data);
    }

    function get_row_material($searchStr) {
        $whereAutoComplete = " AND ( name like '%{$searchStr}%' )";
        $autocomplete_data = $this->products_model->getAutocompleteProductList($whereAutoComplete);
        echo $autocomplete_data;
        exit;
    }

    function get_uom() {
        $item_row_material_id = $this->input->post('item_row_material_id');
        $uom_arr = $this->products_model->get_uom_by_id($item_row_material_id);
        echo $uom = $uom_arr[0]['uom'];
    }

    function get_cost() {
        $item_row_material_id = $this->input->post('item_row_material_id');
        $uom_arr = $this->products_model->get_cost_by_id($item_row_material_id);
        echo $uom = $uom_arr[0]['cost'];
    }

    function add_ingr() {
        $product_id = $this->input->post('product_id');
        $edit_id = $this->input->post('edit_id');
        if (empty($edit_id)) {
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $this->form_validation->set_rules('material_name', 'Name', 'required');
                $this->form_validation->set_rules('quantity', 'Quantity', 'required');
                $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');
                if ($this->form_validation->run()) {
                    $data_to_store = array(
                        'product_id' => $this->input->post('product_id'),
                        'material_name' => $this->input->post('material_name'),
                        'material_qua' => $this->input->post('quantity'),
                        'uom' => $this->input->post('uom'),
                        'cost' => $this->input->post('cost')
                    );
                    if ($this->products_model->store_ingredients($data_to_store)) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_message', 'add');
                    } else {
                        $data['flash_message'] = FALSE;
                        $this->session->set_flashdata('flash_message', 'not_updated');
                    }
                }
            }
        } else {
            $data_to_store = array(
                'product_id' => $this->input->post('product_id'),
                'material_name' => $this->input->post('material_name'),
                'material_qua' => $this->input->post('quantity'),
                'uom' => $this->input->post('uom'),
                'cost' => $this->input->post('cost')
            );
            $this->products_model->update_ingredients($edit_id, $data_to_store);
        }
        $data['all_ingr'] = $this->products_model->get_ingredients_data_by_product_id($this->input->post('product_id'));
        redirect('admin/products/ingredients/' . $product_id);
        $data['main_content'] = 'admin/products/ingr';
        $this->load->view('admin/includes/template', $data);
    }

    function delete_ingr() {
        $id = $this->uri->segment(4);
        $this->products_model->delete_products_ingr_by_id($id);
        //$this->session->set_flashdata('flash_message', 'delete');
        redirect('admin/products/');
    }

//edit
}

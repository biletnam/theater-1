<?php

class Admin_user extends CI_Controller {

    /**
     * name of the folder responsible for the views
     * which are manipulated by this controller
     * @constant string
     */
    const VIEW_FOLDER = 'admin/user';

    /**
     * Responsable for auto load the model
     * @return void
     */
    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }

        if (!Access_level::get_access('user')) {

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

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');

        //pagination settings
        $config['per_page'] = 20;

        $config['base_url'] = base_url() . 'admin/user';
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
            $data['count_products'] = $this->user_model->count_user($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if ($search_string) {
                if ($order) {
                    $data['user'] = $this->user_model->get_user($search_string, $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['user'] = $this->user_model->get_user($search_string, '', $order_type, $config['per_page'], $limit_end);
                }
            } else {
                if ($order) {
                    $data['user'] = $this->user_model->get_user('', $order, $order_type, $config['per_page'], $limit_end);
                } else {
                    $data['user'] = $this->user_model->get_user('', '', $order_type, $config['per_page'], $limit_end);
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
            $data['count_products'] = $this->user_model->count_user();
            $data['user'] = $this->user_model->get_user('', '', $order_type, $config['per_page'], $limit_end);
            $config['total_rows'] = $data['count_products'];
        }//!isset($search_string) && !isset($order)
        //initializate the panination helper
        $this->pagination->initialize($config);

        //load the view
        $data['main_content'] = 'admin/user/list';
        $this->load->view('admin/includes/template', $data);
    }

//index

    public function add() {
        //echo "<pre>"; print_r($_POST); die;
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            //form validation
            $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[4]|is_unique[user.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
            $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
            $this->form_validation->set_rules('primary_email', 'primary E-mail', 'trim|required|valid_email|is_unique[user.primary_email]');
            $this->form_validation->set_rules('company_id', 'Company name', 'trim|required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $data = $this->functions->do_upload('avatar', './uploads/avatar/');
                if (isset($data['upload_data'])) {
                    $file_name = $data['upload_data']['file_name'];
                } else {
                    $file_name = "";
                }
                if (is_array($this->input->post('user_interests'))) {
                    $user_interests = implode(",", $this->input->post('user_interests'));
                } else {
                    $user_interests = '';
                }
                if (is_array($this->input->post('language_id'))) {
                    $language_ids = implode(",", $this->input->post('language_id'));
                } else {
                    $language_ids = '';
                }
                $user_rand_id = $this->functions->get_user_rand_id();
                $data_to_store = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->input->post('username'),
                    'password' => $this->__encrip_password($this->input->post('password')),
                    'primary_email' => $this->input->post('primary_email'),
                    'company_id' => $this->input->post('company_id'),
                    'phone' => $this->input->post('phone'),
                    'user_type' => $this->input->post('user_type'),
                    'joining_date' => $this->input->post('joining_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status' => $this->input->post('status')
                );
                //echo "<pre>"; print_r($data_to_store); die;
                //if the insert has returned true then we show the flash message
                if ($this->user_model->store_user($data_to_store)) {
                    $user_id = $this->db->insert_id();
                    $ex_data = array(
                        'user_id' => $user_id,
                        'parent_user_id' => Access_level::session_user_id(),
                        'user_type' => $this->input->post('user_type'),
                    );
                    $this->user_role_extended_model->store_user_role_extended($ex_data);
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_message', 'add');
                    redirect('admin/user/');
                    //redirect('admin/user'.'');
                } else {
                    $data['flash_message'] = FALSE;
                }
            }
        }

        $data['company'] = $this->company_model->get_company('', '', 'DESC', '', '', 'Active');
        $data['main_content'] = 'admin/user/add';
        $this->load->view('admin/includes/template', $data);
    }

    /**
     * Update item by his id
     * @return void
     */
    public function update() {
        //product id
        $id = $this->uri->segment(4);
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST') {

            $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('username', 'User name', 'trim|required|min_length[4]|edit_unique[user.username.' . $id . ']');
            if (isset($_POST['password'])) {
                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
                $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
            }
            $this->form_validation->set_rules('primary_email', 'primary E-mail', 'trim|required|valid_email|edit_unique[user.primary_email.' . $id . ']');

            $this->form_validation->set_message('validate_keyword', 'Please select Max 10 User interest!');

            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');


            //if the form has passed through the validation
            if ($this->form_validation->run()) {
                $data = $this->functions->do_upload('avatar', './uploads/avatar/');
                if (isset($data['upload_data'])) {
                    $file_name = $data['upload_data']['file_name'];
                    @unlink("./uploads/avatar/" . $this->input->post('old_avatar'));
                } else {
                    $file_name = $this->input->post('old_avatar');
                }
                if (is_array($this->input->post('user_interests'))) {
                    $user_interests = implode(",", $this->input->post('user_interests'));
                } else {
                    $user_interests = '';
                }
                if (is_array($this->input->post('language_id'))) {
                    $language_ids = implode(",", $this->input->post('language_id'));
                } else {
                    $language_ids = '';
                }
                //Main Power admin will not be inactive
                $status = ($id == 1) ? 'Active' : $this->input->post('status');
                $redirect_url = $this->input->post('redirect_url');
                $data_to_store = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->input->post('username'),
                    'primary_email' => $this->input->post('primary_email'),
                    'phone' => $this->input->post('phone'),
                    'user_type' => $this->input->post('user_type'),
                    'joining_date' => $this->input->post('joining_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status' => $status
                );
                //echo "<pre>"; print_r($data_to_store); die;
                if (isset($_POST['password'])) {
                    $this->db->set('password', $this->__encrip_password($this->input->post('password')));
                }
                //if the insert has returned true then we show the flash message
                if ($this->user_model->update_user($id, $data_to_store) == TRUE) {
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

        $data['user'] = $this->user_model->get_user_by_id($id);

        //load the view
        $data['main_content'] = 'admin/user/edit';
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
        $this->user_model->delete_user($id);

        if ($id == 1) {
            $this->session->set_flashdata('flash_message', 'error');
        } else {
            $this->session->set_flashdata('flash_message', 'delete');
        }
        redirect('admin/user/');
    }

//edit

    public function exportcsv() {
        $do_export = $this->input->post('do_export');
        $type_of_membership = $this->input->post('type_of_membership');
        $language_inter = $this->input->post('language_interface');
        if (!empty($do_export)) {
            //echo "go"; die;
            //$rs_users = $this->user_model->get_user('', '', '', '','');
            $this->db->select('*');
            $this->db->from('user');
            if (!empty($type_of_membership)) {
                $this->db->where('type_of_membership', $type_of_membership);
            }
            if (!empty($language_inter)) {
                $this->db->where('language_interface', $language_inter);
            }
            $this->db->group_by('user_id');
            $this->db->order_by('user_id', 'DESC');
            $query = $this->db->get();
            $rs_users = $query->result_array();

            $currentDate = date('Y-m-d_H-i-s');
            $fname = 'user_' . $currentDate . '.xls';
            $filepath = './uploads/export_csv/' . $fname;

            // Write heading row in csv file
            $heading_row = array('Id', 'First Name', 'Last Name', 'User Name', 'Primary E-mail', 'Gender', 'Type of memebership', 'Language interface', 'Language for Newsletter', 'Town', 'Zip code', 'Country', 'User interests', 'Additional E-mail 1', 'Additional E-mail 2', 'NO Adds', 'Adult Content tag', 'Privacy Settings', 'Invoice First Name', 'Invoice Last Name', 'Invoice Company Name', 'Invoice Street', 'Invoice Town', 'Invoice Zip code', 'Invoice Country', 'Last login', 'Date of registration', 'account_confirmed', 'Status');

            // Make array for csv row content and write it in file

            $header = '';
            $data = '';
            $value = '';

            for ($h = 0; $h < count($heading_row); $h++) {
                $header .= $heading_row[$h] . "\t";
            }
            if (count($rs_users) > 0) {
                for ($c = 0; $c < count($rs_users); $c++) {
                    $line = '';



                    if (!empty($rs_users[$c]['user_interests'])) {
                        $ex = explode(",", $rs_users[$c]['user_interests']);
                        if (count($ex > 0)) {
                            for ($i = 0; $i < count($ex); $i++) {
                                $user_int_array = $this->newsletter_keyword_model->get_keyword_by_id($ex[$i]);
                                $user_int[] = $user_int_array[0]['en'];
                            }
                        }
                        $keyword = implode(",", $user_int);
                    } else {
                        @$keyword = '';
                    }


                    if (!empty($rs_users[$c]['country'])) {
                        $country = $this->user_model->get_countries_by_id($rs_users[$c]['country']);
                    }
                    if (!empty($rs_users[$c]['i_country'])) {
                        $i_country = $this->user_model->get_countries_by_id($rs_users[$c]['i_country']);
                    }
                    $site_language = $this->site_language_model->get_language_by_id($rs_users[$c]['language_interface']);
                    $language = $this->newsletter_language_model->get_language_by_id($rs_users[$c]['language_id']);

                    $user_rand_id = (!empty($rs_users[$c]['user_rand_id']) ? $rs_users[$c]['user_rand_id'] : "#");
                    $firstname = (!empty($rs_users[$c]['firstname']) ? $rs_users[$c]['firstname'] : "");
                    $lastname = (!empty($rs_users[$c]['lastname']) ? $rs_users[$c]['lastname'] : "");
                    $username = (!empty($rs_users[$c]['username']) ? $rs_users[$c]['username'] : "" );
                    $primary_email = (!empty($rs_users[$c]['primary_email']) ? $rs_users[$c]['primary_email'] : "");
                    $gender = (!empty($rs_users[$c]['gender']) ? $rs_users[$c]['gender'] : "");
                    $type_of_membership = (!empty($rs_users[$c]['type_of_membership']) ? $rs_users[$c]['type_of_membership'] : "");

                    $language_interface = (!empty($site_language[0]['language_longform']) ? $site_language[0]['language_longform'] : "" );
                    $newsletter_language = (!empty($language[0]['language_longform']) ? $language[0]['language_longform'] : "" );

                    $town = (!empty($rs_users[$c]['town']) ? $rs_users[$c]['town'] : "");
                    $zip_code = (!empty($rs_users[$c]['zip_code']) ? $rs_users[$c]['zip_code'] : "");
                    $country = (!empty($country[0]['country_name']) ? $country[0]['country_name'] : "");

                    $user_interests = (!empty($keyword) ? $keyword : "");

                    $additional_email1 = (!empty($rs_users[$c]['additional_email1']) ? $rs_users[$c]['additional_email1'] : "");
                    $additional_email2 = (!empty($rs_users[$c]['additional_email2']) ? $rs_users[$c]['additional_email2'] : "");
                    $no_ads = (!empty($rs_users[$c]['no_ads']) ? $rs_users[$c]['no_ads'] : "");
                    $adult_content = (!empty($rs_users[$c]['adult_content']) ? $rs_users[$c]['adult_content'] : "");
                    $privacy_settings = (!empty($rs_users[$c]['privacy_settings']) ? $rs_users[$c]['privacy_settings'] : "");
                    $i_firstname = (!empty($rs_users[$c]['i_firstname']) ? $rs_users[$c]['i_firstname'] : "");
                    $i_lastname = (!empty($rs_users[$c]['i_lastname']) ? $rs_users[$c]['i_lastname'] : "");
                    $i_company_name = (!empty($rs_users[$c]['i_company_name']) ? $rs_users[$c]['i_company_name'] : "");
                    $i_street = (!empty($rs_users[$c]['i_street']) ? $rs_users[$c]['i_street'] : "");
                    $i_town = (!empty($rs_users[$c]['i_town']) ? $rs_users[$c]['i_town'] : "");
                    $i_zip_code = (!empty($rs_users[$c]['i_zip_code']) ? $rs_users[$c]['i_zip_code'] : "");
                    $i_country = (!empty($i_country[0]['country_name']) ? $i_country[0]['country_name'] : "");
                    $last_login = (!empty($rs_users[$c]['last_login']) ? $rs_users[$c]['last_login'] : "");
                    $date_of_registration = (!empty($rs_users[$c]['date_of_registration']) ? $rs_users[$c]['date_of_registration'] : "");
                    $account_confirmed = (!empty($rs_users[$c]['account_confirmed']) ? $rs_users[$c]['account_confirmed'] : "");
                    $status = (!empty($rs_users[$c]['status']) ? $rs_users[$c]['status'] : "");

                    $content_row = array();
                    $content_row = array($user_rand_id, $firstname, $lastname, $username, $primary_email, $gender, $type_of_membership, $language_interface, $newsletter_language, $town, $zip_code, $country, $user_interests, $additional_email1, $additional_email2, $no_ads, $adult_content, $privacy_settings, $i_firstname, $i_lastname, $i_company_name, $i_street, $i_town, $i_zip_code, $i_country, $last_login, $date_of_registration, $account_confirmed, $status);
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


            // Close csv file pointer
            //fclose($fp);
            //$url = site_url('uploads/export_csv/')."/".$fname;

            header("Content-type:application/octet-stream");
            header("Content-Disposition:attachment;filename=$fname");
            header("Pragma: no-cache");
            header("Expires: 0");
            print "$header\n$data";
            //echo file_get_contents($filepath);
            //unlink($filepath);
            exit;
        }
        $data['site_language'] = $this->site_language_model->get_language('', '', '', '', '', 'Active', '');
        $data['main_content'] = 'admin/user/export';
        $this->load->view('admin/includes/template', $data);
    }

    function validate_user_interests($str) {
        $array_value = $str; //this is redundant, but it's to show you how
        //the content of the fields gets automatically passed to the method
        //print_r($str);
        if (count($array_value) <= 10) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}

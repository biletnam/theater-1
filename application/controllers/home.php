<?php

class Home extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    public function __construct() {

        parent::__construct();

        $this->load->model('home_model');
        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->load->model('payment_model');
        $this->load->model('write_add_model');
        $this->load->helper('url');

        if (!$this->session->userdata('is_logged_in')) {
            //redirect('admin/login');
        }
    }

    function index() {

        $id = isset($_POST['posts_id']) ? $_POST['posts_id'] : "";

        if (isset($_POST) && !empty($_POST)) {
            $transaction_approval = $_POST['Transaction_Approved'];
            if ($transaction_approval != 'NO') {
                if ($this->session->userdata('user_id')) {
                    $user_id = $this->session->userdata('user_id');
                } else {
                    $user_id = "0";
                }

                $data_to_store = array(
                    'uid' => $user_id,
                    'trans_id' => isset($_POST['x_trans_id']) ? $_POST['x_trans_id'] : "",
                    'invoice_num' => isset($_POST['x_invoice_num']) ? $_POST['x_invoice_num'] : "",
                    'description' => isset($_POST['x_description']) ? $_POST['x_description'] : "",
                    'amount' => isset($_POST['x_amount']) ? $_POST['x_amount'] : "",
                    'cust_id' => isset($_POST['x_cust_id']) ? $_POST['x_cust_id'] : "",
                    'first_name' => isset($_POST['x_first_name']) ? $_POST['x_first_name'] : "",
                    'last_name' => isset($_POST['x_last_name']) ? $_POST['x_last_name'] : "",
                    'company' => isset($_POST['x_company']) ? $_POST['x_company'] : "",
                    'address' => isset($_POST['x_address']) ? $_POST['x_address'] : "",
                    'city' => isset($_POST['x_city']) ? $_POST['x_city'] : "",
                    'state' => isset($_POST['x_state']) ? $_POST['x_state'] : "",
                    'zip' => isset($_POST['x_zip']) ? $_POST['x_zip'] : "",
                    'country' => isset($_POST['x_country']) ? $_POST['x_country'] : "",
                    'phone' => isset($_POST['x_phone']) ? $_POST['x_phone'] : "",
                    'email' => isset($_POST['x_email']) ? $_POST['x_email'] : "",
                    'ship_to_first_name' => isset($_POST['x_ship_to_first_name']) ? $_POST['x_ship_to_first_name'] : "",
                    'ship_to_last_name' => isset($_POST['x_ship_to_last_name']) ? $_POST['x_ship_to_last_name'] : "",
                    'ship_to_company' => isset($_POST['x_ship_to_company']) ? $_POST['x_ship_to_company'] : "",
                    'ship_to_address' => isset($_POST['x_ship_to_address']) ? $_POST['x_ship_to_address'] : "",
                    'ship_to_city' => isset($_POST['x_ship_to_city']) ? $_POST['x_ship_to_city'] : "",
                    'ship_to_state' => isset($_POST['x_ship_to_state']) ? $_POST['x_ship_to_state'] : "",
                    'ship_to_zip' => isset($_POST['x_ship_to_zip']) ? $_POST['x_ship_to_zip'] : "",
                    'ship_to_country' => isset($_POST['x_ship_to_country']) ? $_POST['x_ship_to_country'] : "",
                    'discount_amount' => isset($_POST['discount_amount']) ? $_POST['discount_amount'] : "",
                );

                $payment_id = $this->payment_model->add_payment($data_to_store);

                if (isset($payment_id) && !empty($payment_id)) {
                    $data_to_update = array(
                        'payment_status' => 'complete',);

                    if ($this->write_add_model->update_posts($id, $data_to_update) == TRUE) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', 'Suceess');
                        redirect("home");
                    }
                }
            } else {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', 'Your payment has not been approval');
                redirect("home");
            }
        } else {
            $data['page_type'] = $home = $this->uri->segment(1);

            $stack_state_id_selected = $this->session->userdata('stack_state_id');
            $stack_city_id_selected = $this->session->userdata('stack_city_id');
            if (!empty($stack_state_id_selected)) {
                $where_state = " AND state_id='{$stack_state_id_selected}'";
                $state_name = $this->common_model->getFieldData('state', 'state_name', $where_state);
                redirect('state_category/cat/' . $stack_state_id_selected . '/' . $state_name);
            } elseif (!empty($stack_city_id_selected)) {
                $where_city = " AND city_id='{$stack_city_id_selected}'";
                $city_name = $this->common_model->getFieldData('city', 'city_name', $where_city);
                redirect('citycategory/cat/' . $stack_city_id_selected . '/' . $city_name);
            } else {
                $data['main_content'] = 'home_view';
                $data['country_opt'] = $this->home_model->getAllCountry();
                $this->load->view('includes/template', $data);
            }
        }
    }

    function home_page() {
        $this->session->unset_userdata('stack_city_id');
        $this->session->unset_userdata('stack_select_type');
        redirect('home');
    }

    function confirm() {
        $email_encode = $this->uri->segment(3);

        if (!empty($email_encode)) {

            $email = base64url_decode($email_encode);
            $pass = generate_password();
            //$affiliate_number = $this->session->userdata('affiliate_num');

            $data_to_store = array(
                'password' => md5($pass),
                'status' => 'Active',
//                'affiliate_type' => $affiliate_type,
            );

            $this->load->helper('email');
            //load email library
            $this->load->library('email');

            //read parameters from $_POST using input class
            // check is email addrress valid or no
            if (valid_email($email)) {
                // compose email
                $get_admin_detail = get_admin_detail(); //common helper function for admin detail
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                $this->email->subject('Register confirmation and password for StacksClassifieds');
                $users = $this->user_model->get_user_by_filed('primary_email', $email);
                $mail_data['password'] = $pass;
                $mail_data['username'] = $users[0]['username'];
                $message = $this->load->view('mail_templates/password_mail', $mail_data, true);
                $this->email->message($message);

                // try send mail ant if not able print debug
                if (!$this->email->send()) {
                    $msgadd = "<strong>E-mail not sent </strong>"; //.$this->email->print_debugger();
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('signup');
                } else {

                    $update_url = $this->user_model->update_user_by_email($email, $data_to_store);
                    $where_flag = " AND primary_email='{$email}'";
                    $affiliate_flag = $this->common_model->getFieldData('user', 'affiliate_flag', $where_flag);

                    if ($update_url) {
                        //
                        // $whereStr = "affiliate_user_email='{$email}'";
                        $affiliate_user_data = $this->common_model->getRow('affiliate', 'affiliate_user_email', $email);
                        $user_data = $this->common_model->get_content_by_field('user', 'affiliate_send_user_email', $affiliate_user_data->affiliate_send_user_email);

                        $affiliate_earn = $user_data[0]['affiliate_earn'];
                        $register_price = $user_data[0]['register_price'];
                        $affiliate_number = $user_data[0]['affiliate_number'];
                        $earn_price = $register_price + $affiliate_earn;

                        if ($affiliate_flag == '0') {
                            $flag_data_store = array('affiliate_flag' => '1');
                            $this->user_model->update_user_by_email($email, $flag_data_store);
                            $earn_price = $register_price + $affiliate_earn;
                            $data_store = array(
                                'affiliate_earn' => $earn_price,
                            );
                            $this->common_model->update_by_field('user', 'affiliate_number', $affiliate_number, $data_store);
                            $data['flash_message'] = TRUE;
                            $this->session->set_flashdata('flash_class', 'alert-success');
                            $this->session->set_flashdata('flash_message', '<strong>Thank you for confirming your account. Please check your email for username and password.</strong>');
                            redirect('home');
                        } else {
                            redirect('home');
                        }
                    } else {

                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>Oh snap! change a few things up and try submitting again.</strong>');
                        redirect('signup');
                    }
                }
            }
        } else {
            redirect('home');
        }

        //$data['main_content'] = 'reset_password_view';
        //$this->load->view('includes/template', $data);
    }

    function account() {
        $data['user_id'] = $this->uri->segment(3);
        $data['country'] = $this->home_model->getAllCountry();
        $data['main_content'] = 'user_account_view';
        $this->load->view('includes/template', $data);
    }

    function affiliate_number_account() {
        $user_id = $this->uri->segment(3);
        $whereStr = " AND user_id={$user_id}";
        $affi_number = $this->common_model->getFieldData('user', 'affiliate_number', $whereStr);
        if (!empty($affi_number)) {
            redirect("signin/signin_user/{$user_id}/affiliate");
        } else {
            $affiliate_number = affiliate_number();
            $data_store = array('affiliate_number' => $affiliate_number, 'type' => 'affiliate');
            $this->common_model->update_by_field('user', 'user_id', $user_id, $data_store);
            redirect("signin/signin_user/{$user_id}/affiliate");
        }
    }

    function change_password() {
        $email_encode = $this->uri->segment(3);
        $data['email'] = base64url_decode($email_encode);
        $data['main_content'] = 'reset_password_view';
        $this->load->view('includes/template', $data);
    }

    function set_password() {

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
        if ($this->form_validation->run()) {
            $email = $this->input->post('email');
            $data_to_store = array(
                'password' => md5($this->input->post('password')),
                'status' => 'Active'
            );
            if ($this->user_model->update_user_by_email($email, $data_to_store)) {
                $data['flash_message'] = TRUE;
                redirect('signup');
            } else {
                $data['flash_message'] = TRUE;
                redirect('signup');
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }

}


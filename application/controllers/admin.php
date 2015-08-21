<?php

class Admin extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not,
     * send him to the login page
     * @return void
     */
    function index() {
        //echo "hii"; die;
        if ($this->session->userdata('is_logged_in')) {
            redirect('admin/dashboard');
        } else {
            $this->load->view('admin/login');
        }
    }

    /**
     * encript the password
     * @return mixed
     */
    function __encrip_password($password) {
        return md5($password);
    }

    /**
     * check the username and the password with the database
     * @return void
     */
    function validate_credentials() {

        $this->load->model('Admin_model');

        $username = $this->input->post('username');
        $password = $this->__encrip_password($this->input->post('password'));

        $is_valid = $this->Admin_model->validate($username, $password);
        $stored_user_data = $this->Admin_model->get_user_id($username);

        $stored_userdata = json_decode(json_encode($stored_user_data), true);
//        echo '<pre>';
//        print_r($stored_userdata);
        $user_id = $stored_userdata[0]['user_id'];
        $user_type = $stored_userdata[0]['user_type'];
        if ($user_type != 'super_admin') {
            $company_id = $stored_userdata[0]['company_id'];
        } else {
            $company_id = 0;
        }
        if ($is_valid) {
            $data = array(
                'username' => $username,
                'user_id' => $user_id,
                'user_type' => $user_type,
                'company_id' => $company_id,
                'is_logged_in' => true
            );
//            echo '<pre>';
//            print_r($data);
//            echo '</pre>';
//            die;
            $this->session->set_userdata($data);
            redirect('admin/dashboard');
        } else { // incorrect username or password
            $data['message_error'] = TRUE;
            $this->load->view('admin/login', $data);
        }
    }

    /**
     * The method just loads the signup view
     * @return void
     */
    function signup() {
        $this->load->view('admin/signup_form');
    }

    /**
     * Create new user and store it in the database
     * @return void
     */
    function create_member() {
        $this->load->library('form_validation');

        // field name, error message, validation rules
        $this->form_validation->set_rules('first_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/signup_form');
        } else {
            $this->load->model('Admin_model');

            if ($query = $this->Admin_model->create_member()) {
                $this->load->view('admin/signup_successful');
            } else {
                $this->load->view('admin/signup_form');
            }
        }
    }

    /**
     * Destroy the session, and logout the user.
     * @return void
     */
    function logout() {
        $this->session->sess_destroy();
        redirect('admin');
    }

}


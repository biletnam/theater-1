<?php

class Signin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->helper('url');

        if ($this->session->userdata('is_logged_in')) {
            //redirect('home');
        }
    }

    function index() {

    }

    function signin_user() {
        $user_id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        if ($type == "affiliate") {
            $data['content'] = $this->user_model->get_user_by_filed('user_id', $user_id);
            $data['main_content'] = 'affilate_view';
            $this->load->view('includes/template', $data);
        } else {
            $session = array(
                'type' => "user",
            );
            $this->session->set_userdata($session);
            $data['main_content'] = 'signin_view';
            $this->load->view('includes/template', $data);
        }
    }

    function __encrip_password($password) {
        return md5($password);
    }

    function validate_credentials_front() {

        if (empty($this->session->userdata['username'])) {
            $this->load->model('Admin_model');
            $username = $this->input->post('username');
//            $this->session->userdata[''];
            $password = $this->__encrip_password($this->input->post('password'));
            $is_valid = $this->Admin_model->validate_front($username, $password);
            if ($is_valid) {
                $stored_user_data = $this->Admin_model->get_user_id($username);
                $user_id = $stored_user_data[0]->user_id;
                $primary_email = $stored_user_data[0]->primary_email;
                $affiliate = $stored_user_data[0]->type;
                if (!empty($affiliate)) {
                    $type = $affiliate;
                } else {
                    $type = 'user';
                }
                $data = array(
                    'username' => $username,
                    'primary_email' => $primary_email,
                    'user_id' => $user_id,
                    'type' => $type,
                    'is_logged_in' => true
                );
                $this->session->set_userdata($data);
                if ($affiliate == 'affiliate') {
                    redirect("signin/signin_user/$user_id/affiliate");
                } else {
                    redirect("home/account/$user_id");
                }
            } else {
                $this->session->set_flashdata('flash_class', 'alert-danger');
                $this->session->set_flashdata('flash_message', '<strong>ohh snap!</strong> Wrong Username or password!</strong>');
                redirect('home');
            }
        } else {
            redirect('home');
        }
    }

}


<?php

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');

        if ($this->session->userdata('is_logged_in')) {
            redirect('home');
        }
    }

    function index() {
        $affiliate_number = $this->uri->segment(3);
        $affiliate_num = base64url_decode($affiliate_number);

        if (!empty($affiliate_num)) {
            $data['type'] = "user";
            $data['main_content'] = 'signup_view';
            $this->load->view('includes/template', $data);
        } else {
            $type = $this->session->userdata('type');
            if ($type == "affiliate") {
                $data['type'] = "affiliate";
            } else {
                $data['type'] = "user";
            }
            $data['main_content'] = 'signup_view';
            $this->load->view('includes/template', $data);
        }
    }

    function signup_user() {
        $data['type'] = "user";
        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    function create_member_site() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('create_email', 'Email Address', 'trim|required|valid_email|is_unique[user.primary_email]|matches[create_email_confirm]');
        $this->form_validation->set_rules('create_email_confirm', 'Email Address Confirmation', 'required');
        $this->form_validation->set_message('is_unique', 'The %s is already taken! Please choose another.');
        $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">&#215;</a><strong>', '</strong></div>');

        if ($this->form_validation->run()) {
            $pass = generate_password();
            $type = $this->input->post('type');
            if ($type == "affiliate") {
                $affiliate_number = affiliate_number();
            } else {
                $affiliate_number = '';
            }
            $email = $this->input->post('create_email');
            $data_to_store = array(
                'username' => $this->input->post('username'),
                'password' => md5($pass),
                'firstname' => $this->input->post('username'),
                'primary_email' => $email,
                'type' => $this->input->post('type'),
                'affiliate_number' => $affiliate_number,
                'status' => 'Inactive'
            );

            $this->load->helper('email');
            $this->load->library('email');

            if (valid_email($email)) {

                $get_admin_detail = get_admin_detail();
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['priority'] = 1;
                $this->email->initialize($config);
                $this->email->from($get_admin_detail['email'], $get_admin_detail['name']);
                $this->email->to($email);
                $this->email->set_mailtype("html");
                if ($type == "affiliate") {
                    $this->email->subject('StacksClassifieds.com new account:' . $email);
                    $mail_data['url'] = site_url() . 'affiliate/affiliate_confirm/' . base64url_encode($email);
                    $message = $this->load->view('mail_templates/affiliate_confirmation_user', $mail_data, true);
                } else {
                    $this->email->subject('Register confirmation for StacksClassifieds');
                    $mail_data['url'] = site_url() . 'home/confirm/' . base64url_encode($email);
                    $message = $this->load->view('mail_templates/signup_mail', $mail_data, true);
                }

                $this->email->message($message);

                if (!$this->email->send()) {

                    $msgadd = "<strong>E-mail not sent </strong>";
                    $data['flash_message'] = TRUE;
                    $this->session->set_flashdata('flash_class', 'alert-error');
                    $this->session->set_flashdata('flash_message', $msgadd);
                    redirect('signup');
                } else {
                    if ($this->user_model->store_user($data_to_store)) {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-success');
                        $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We have sent you a link to confirm your Account.');
                        redirect('home');
                    } else {
                        $data['flash_message'] = TRUE;
                        $this->session->set_flashdata('flash_class', 'alert-error');
                        $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
                        redirect('home');
                    }
                }
            }
        } else {

            $this->session->set_flashdata('validation_error_messages', validation_errors());
            redirect('signup');
        }

        $data['main_content'] = 'signup_view';
        $this->load->view('includes/template', $data);
    }

    function set_password() {
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('create_email_confirm', 'Password Confirmation', 'trim|required|matches[password]');
        if ($this->form_validation->run()) {
            $email = base64url_decode($this->input->post('create_email'));
            $data_to_store = array(
                'password' => md5($this->input->post('password')),
                'status' => 'Active'
            );
            if ($this->user_model->update_user_by_email($email, $data_to_store)) {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-success');
                $this->session->set_flashdata('flash_message', '<strong>Well done!</strong> We sent you password on your E-mail.');
                redirect('signup');
            } else {
                $data['flash_message'] = TRUE;
                $this->session->set_flashdata('flash_class', 'alert-error');
                $this->session->set_flashdata('flash_message', '<strong>Oh snap!</strong> change a few things up and try submitting again.');
                redirect('signup');
            }
        }
    }

}


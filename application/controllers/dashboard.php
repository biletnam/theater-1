<?php

class Dashboard extends CI_Controller {

    /**
     * Check if the user is logged in, if he's not, 
     * send him to the login page
     * @return void
     */
    function index() {
        if($this->session->userdata('user_type') == 'operator'){
            redirect('admin/operator');
        }else{
            $data['main_content'] = 'admin/dashboard_view';
            $this->load->view('admin/includes/template', $data);
        }
        
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * encript the password 
     * @return mixed
     */
}
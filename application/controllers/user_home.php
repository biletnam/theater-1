<?php
class User_home extends CI_Controller {
	public function __construct()
    {
		parent::__construct();
	}
	function index()
	{
		$this->load->helper('url');
		$data['main_content'] = 'home_view';
		
        $this->load->view('includes/template', $data); 
	}
}
?>
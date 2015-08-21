<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Do_language {
	
	var $CI;		
	
	public function __construct() {
	
	$this->CI =& get_instance();
	$this->CI->load->model('site_language_model');
	$this->CI->load->model('language_keyword_model');
	$this->set_language();
}
	function set_language(){
		//$CI =& get_instance();
		
		if(!$this->CI->session->userdata('language_shortcode'))
		{
			//$get_lang = $this->CI->site_language_model->get_language('', '', '', '','','Active');
			$data = array(
				'language_shortcode' => 'en',
				);
				$this->CI->session->set_userdata($data);
			
		}
			//echo '<pre>'; print_r($this->CI->session->userdata);
			$session_language_shortcode = $this->CI->session->userdata('language_shortcode');
			$get_lang_data = $this->CI->language_keyword_model->get_language_keyword('', '', '', '','','');
			//echo '<pre>'; print_r($get_lang_data);
			for($i=0;$i<count($get_lang_data);$i++){
			if(empty($get_lang_data[$i][$session_language_shortcode])){
				$session_lang_short = $get_lang_data[$i]["en"];
			}else{
				$session_lang_short = $get_lang_data[$i][$session_language_shortcode];
			}
				define(stripslashes($get_lang_data[$i]["language_define"]),stripslashes($session_lang_short));
	}
		}
	
	}
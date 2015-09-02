<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Access_level {

    private static $CI;

    public function __construct() {
        //Load all helpers here...
        self::$CI = & get_instance();
        self::$CI->load->model('user_model');
        self::$CI->load->model('company_model');
        self::$CI->load->model('user_role_extended_model');
        self::$CI->load->helper('url');
    }

    public static function session_user_type() {
        $user_type = self::$CI->session->userdata('user_type');
        if (!empty($user_type)) {
            return $user_type;
        } else {
            redirect('admin/login');
        }
    }

    public static function session_user_id() {
        $user_id = self::$CI->session->userdata('user_id');
        if (!empty($user_id)) {
            return $user_id;
        } else {
            redirect('admin/login');
        }
    }

    public static function session_username() {
        $username = self::$CI->session->userdata('username');
        if (!empty($username)) {
            return $username;
        } else {
            redirect('admin/login');
        }
    }

    public static function session_company_id() {
        return $company_id = self::$CI->session->userdata('company_id');
//        if (!empty($company_id)) {
//            return $company_id;
//        } else {
//            redirect('admin/login');
//        }
    }

    /*     * **********************************************
      /**********Users role Information****************

      1 	super_admin
      2 	admin
      3 	operator
      4 	customer


     * ***********************************************
     * ********************************************* */

    public static function user_role_array() {
        return array("super_admin" => "Super Admin", "admin" => "Admin", "operator" => "Operator", "customer" => "Customer");
    }

    public static function user_role_dropdown() {
        return array(
            "super_admin" => array("admin" => "Admin", "operator" => "Operator", "customer" => "Customer"),
            "admin" => array("admin" => "Admin", "operator" => "Operator", "customer" => "Customer"),
            "operator" => array("operator" => "Operator", "customer" => "Customer"),
            "customer" => array("customer" => "Customer")
        );
    }

//Define permissions to Aceess module by User Role
    public static function get_access($controller) {
        // 1 	super_admin
        $modules = array();
        $user_type = self::$CI->session->userdata('user_type');

        if ($user_type == 'super_admin') {
            $modules = array('company', 'user', 'products', 'material', 'category', 'operator_list', 'operator_data', 'purchase_material', 'report_list', 'purchase_report', 'purchase_report_today', 'uom', 'inventory');
        }
        //2 admin
        if ($user_type == 'admin') {
            $modules = array('user', 'products', 'operator_list', 'inventory');
        }
        //3 operator
        if ($user_type == 'operator') {
            $modules = array('operator_data');
        }
        //4 customer
        if ($user_type == 'customer') {
            $modules = array();
        }
        if (in_array($controller, $modules)) {
            return true;
        } else {
            return false;
        }
    }

    public static function convertToMlOrGm($data) {
        $fixValue = 1000;
        if (!empty($data)) {
            $finalValue = $data * $fixValue;
            return $finalValue;
        }
    }

    public static function convertToLTROrKG($data) {
        $fixValue = 1000;
        if (!empty($data)) {
            $finalValue = $data / $fixValue;
            return $finalValue;
        }
    }

}

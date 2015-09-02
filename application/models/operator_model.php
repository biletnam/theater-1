<?php

class operator_model extends CI_Model {

    public function get_category() {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product($category_id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'Active');
        $this->db->where('product_type', 'FG');
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        die;
        return $query->result_array();
    }

    public function get_product_detail_by_product_id($products_id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('products_id', $products_id);
        $query = $this->db->get();
        //echo $a = $this->db->last_query(); die;
        return $query->result_array();
    }

    public function addOrder($order) {
        $insert = $this->db->insert('order', $order);
        return $this->db->insert_id();
    }

    public function addOrderDetail($order_detail) {
        $insert = $this->db->insert('order_detail', $order_detail);
        return $this->db->insert_id();
    }

    public function get_products() {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('status', 'Active');
        $this->db->where('product_type', 'FG');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_operator_report($operator_user_id) {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('user_id', $operator_user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $user_id) {

        $get_parent_userids = model_load_model('user_role_extended_model')->get_user_role_extended_by_field_array(array("parent_user_id"), array(Access_level::session_user_id()));
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_ingredients_by_product_id($product_id) {
        $this->db->select('*');
        $this->db->from('product_ingredients');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_inventory_by_sale_product($name, $data) {
        $this->db->where('name', $name);
        $this->db->update('inventory', $data);
        //echo $this->db->last_query();
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>
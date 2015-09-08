<?php

class operator_data_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    /**
     * Get product by his is
     * @param int $product_id
     * @return array
     */
    public function get_user_by_id($id) {
        $this->db->select('*');
        $this->db->from('order');
        /* $this->db->select('user.*,site_language.language_longform');
          $this->db->from('user');
          $this->db->join('site_language', 'user.language_interface = site_language.site_language_id','left'); */
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_filed($field, $value) {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch user data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_user($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null, $user_id) {

        //$get_parent_userids = model_load_model('user_role_extended_model')->get_user_role_extended_by_field_array(array("parent_user_id"), array(Access_level::session_user_id()));
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('user_id', $user_id);

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('order_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_user($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('order');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('order_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Delete user
     * @param int $id - user id
     * @return boolean
     */
    function delete_user($id) {
        $this->db->where('user_id', $id);
        $this->db->where('user_id !=', 1);
        $this->db->delete('user');
    }

    public function get_order_detail_by_order_id($order_id) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product_price_by_product_id($product_id) {
        $this->db->select('price');
        $this->db->from('products');
        $this->db->where('products_id', $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_order_discount_by_order_id($order_id) {
        $this->db->select('discount');
        $this->db->from('order');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_order_grand_total_by_order_id($order_id) {
        $this->db->select('grand_amount');
        $this->db->from('order');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //User ROLE queries End
}

?>
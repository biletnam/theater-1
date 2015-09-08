<?php

class purchase_details_data_model extends CI_Model {

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
        $this->db->from('item_row_material_purchase');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_filed($field, $value) {
        $this->db->select('*');
        $this->db->from('item_row_material_purchase');
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
    public function get_user($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('item_row_material_purchase');
        //$this->db->where('user_id', $user_id);

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('user_id', $order_type);
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
        $this->db->from('item_row_material_purchase');
        // $this->db->where('user_id', $user_id);
        $this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('user_id', 'Asc');
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
        $this->db->from('item_row_material_purchase_details');
        $this->db->where('item_row_material_purchase_id', $order_id);
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
        $this->db->from('item_row_material_purchase');
        $this->db->where('item_row_material_purchase_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_order_grand_total_by_order_id($order_id) {
        $this->db->select('total_amount');
        $this->db->from('item_row_material_purchase');
        $this->db->where('item_row_material_purchase_id', $order_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //User ROLE queries End
}

?>
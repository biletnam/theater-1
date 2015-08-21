<?php

class purchase_material_model extends CI_Model {

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
    public function get_purchase_material_by_id($id) {
        $this->db->select('*');
        $this->db->from('item_row_material_purchase');
        $this->db->where('item_row_material_purchase_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch category data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_purchase_material($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('item_row_material_purchase');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('item_row_material_purchase_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('item_row_material_purchase_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }

        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_purchase_material($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('item_row_material_purchase');
        $this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('item_row_material_purchase_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_purchase_material($insertArr) {
        $insert = $this->db->insert('item_row_material_purchase', $insertArr);
        return $this->db->insert_id();
    }

    function store_purchase_material_detail($data) {
        $insert = $this->db->insert('item_row_material_purchase_details', $data);
        return $this->db->insert_id();
    }

    /**
     * Update category
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_purchase_material($data, $id) {
        $this->db->where('item_row_material_purchase_id', $id);
        $this->db->update('item_row_material_purchase', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete categoryr
     * @param int $id - category id
     * @return boolean
     */
    function delete_purchase_material($id) {
        $this->db->where('item_row_material_purchase_id', $id);
        $this->db->delete('item_row_material_purchase');
    }

//    function get_umo_by_id($id) {
//        $this->db->select('umo');
//        $this->db->from('item_row_material');
//        $this->db->where('item_row_material_id', $id);
//        $query = $this->db->get();
//        return $query->result_array();
//    }
}

?>
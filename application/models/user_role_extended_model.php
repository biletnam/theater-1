<?php

class user_role_extended_model extends CI_Model {

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
    public function get_user_role_extended_by_id($id) {
        $this->db->select('*');
        $this->db->from('user_role_extended');
        $this->db->where('user_role_extended_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_role_extended_by_field_array($where_field = array(), $where_value = array()) {
        $this->db->select('*');
        $this->db->from('user_role_extended');
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch user_role_extended data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_user_role_extended($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('user_role_extended');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like('user_role_extended', $search_string);
        }
        $this->db->group_by('user_role_extended_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('user_role_extended_id', $order_type);
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

    public function get_user_role_extended_active() {

        $this->db->select('*');
        $this->db->from('user_role_extended');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Count the number of rows
     * @param int $search_string
     * @param int $order
     * @return int
     */
    function count_user_role_extended($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('user_role_extended');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like('user_role_extended', $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('user_role_extended_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_user_role_extended($data) {
        $insert = $this->db->insert('user_role_extended', $data);
        return $insert;
    }

    /**
     * Update user_role_extended
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_user_role_extended($id, $data) {
        $this->db->where('user_role_extended_id', $id);
        $this->db->update('user_role_extended', $data);
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
     * Delete user_role_extendedr
     * @param int $id - user_role_extended id
     * @return boolean
     */
    function delete_user_role_extended($id) {
        $this->db->where('user_role_extended_id', $id);
        $this->db->delete('user_role_extended');
    }

    function get_add_from_keyword($keywords) {
        //$this->db->query("select * from user_role_extended where
        //";
        $where = "";
        for ($i = 0; $i < count($keywords); $i++) {
            if ($i != 0) {
                $where .= "OR FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            } else {
                $where .= "FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            }
        }
        $query_row = "select * from user_role_extended where status = 'Active' and " . $where;
        $query = $this->db->query($query_row);
        //echo $this->db->last_query();
        return $query->result_array();
    }

}

?>
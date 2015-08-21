<?php

class company_model extends CI_Model {

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
    public function get_company_by_id($id) {
        $this->db->select('*');
        $this->db->from('company');
        $this->db->where('company_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_company_by_field_array($where_field = array(), $where_value = array()) {
        $this->db->select('*');
        $this->db->from('company');
        if (count($where_field) > 0 && count($where_value) > 0) {
            for ($i = 0; $i < count($where_field); $i++) {
                $this->db->where($where_field[$i], $where_value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch company data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_company($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('company');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('company_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('company_id', $order_type);
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

    public function get_company_active() {

        $this->db->select('*');
        $this->db->from('company');
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
    function count_company($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('company');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('company_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_company($data) {
        $insert = $this->db->insert('company', $data);
        return $insert;
    }

    /**
     * Update company
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_company($id, $data) {
        $this->db->where('company_id', $id);
        $this->db->update('company', $data);
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
     * Delete companyr
     * @param int $id - company id
     * @return boolean
     */
    function delete_company($id) {
        $this->db->where('company_id', $id);
        $this->db->delete('company');
    }

    function get_add_from_keyword($keywords) {
        //$this->db->query("select * from company where
        //";
        $where = "";
        for ($i = 0; $i < count($keywords); $i++) {
            if ($i != 0) {
                $where .= "OR FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            } else {
                $where .= "FIND_IN_SET(" . $keywords[$i] . ",`newsletter_keyword_id`)";
            }
        }
        $query_row = "select * from company where status = 'Active' and " . $where;
        $query = $this->db->query($query_row);
        //echo $this->db->last_query();
        return $query->result_array();
    }

}

?>
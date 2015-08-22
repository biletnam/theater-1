<?php

class uom_model extends CI_Model {

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
    public function get_uom_by_id($id) {
        $this->db->select('*');
        $this->db->from('uom');
        $this->db->where('uom_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Fetch uom data from the database
     * possibility to mix search, filter and order
     * @param string $search_string
     * @param strong $order
     * @param string $order_type
     * @param int $limit_start
     * @param int $limit_end
     * @return array
     */
    public function get_uom($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('uom');
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('uom_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('uom_id', $order_type);
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
    function count_uom($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('uom');
        //$this->db->where('status', 'Active');
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('uom_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_uom($data) {
        $insert = $this->db->insert('uom', $data);
        return $insert;
    }

    /**
     * Update uom
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_uom($id, $data) {
        $this->db->where('uom_id', $id);
        //$this->db->where_not_in('username', $names);
        $this->db->update('uom', $data);
//        echo $this->db->last_query();
//        die;
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_uom_status($id, $data) {

        $this->db->where_not_in('uom_id', $id);
        $this->db->update('uom', $data);

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
     * Delete uomr
     * @param int $id - uom id
     * @return boolean
     */
    function delete_uom($id) {
        $this->db->where('uom_id', $id);
        $this->db->delete('uom');
    }

    function get_uom_by_lat_long($lat, $long, $distance = 10, $radius_in = "KM", $limit = 1) {
        if ($radius_in == "KM") {
            $radius_in_dis = 6371;
        } else {
            $radius_in_dis = 3959;
        }
        $query = $this->db->query("SELECT *,
( {$radius_in_dis} * acos( cos( radians({$lat}) ) * cos( radians( `lat` ) ) * cos( radians( `long` ) - radians({$long}) ) + sin( radians({$lat}) ) * sin( radians( `lat` ) ) ) ) AS distance
FROM `uom` where `status` = 'Active' HAVING distance <= {$distance} ORDER BY distance LIMIT 0 , {$limit}");
//        echo $this->db->last_query();
//        die;
        return $query->result_array();
    }

}

?>
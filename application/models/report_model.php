<?php

class report_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    public function getAllProducts() {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_by_date($product_name, $start_date, $end_date, $search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('product_title', $product_name);
        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('order_detail_id', 'Asc');
        }
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        die;
        return $query->num_rows();
    }

    public function getOrderDataBetweenTwoDates($product_title, $start_date, $end_date) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('product_title', $product_title);
        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        $query = $this->db->get();
//        echo $a = $this->db->last_query();
//        die;
        return $query->result_array();
    }

    public function get_today_sale($start_date, $end_date, $search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('order_detail_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('order_detail_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $query->result_array();
    }

    function count_today_sale($start_date, $end_date, $search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('order_detail');

        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('order_detail_id', 'Asc');
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $query->num_rows();
    }

    public function get_today_sale1($title, $start_date, $end_date, $search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('product_title', $title);
        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('order_detail_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('order_detail_id', $order_type);
        }

        if ($limit_start && $limit_end) {
            $this->db->limit($limit_start, $limit_end);
        }

        if ($limit_start != null) {
            $this->db->limit($limit_start, $limit_end);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        return $query->result_array();
    }

    public function getOrderDataBetweenTwoDates1($start_date, $end_date, $search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {
        $this->db->select('*');
        $this->db->from('order_detail');

        $this->db->where('datetime >=', $start_date);
        $this->db->where('datetime <=', $end_date);
        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('order_id');

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
//        echo $a = $this->db->last_query();
//        die;
        return $query->result_array();
    }

}

?>
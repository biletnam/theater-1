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

}

?>
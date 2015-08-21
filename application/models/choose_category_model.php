<?php

class choose_category_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAllSubcategory($cat_id) {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('parent_id', $cat_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_posts_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_posts_category($table, $field, $whereStr) {

        $sql = "Select $field from $table WHERE $whereStr";
        $query = $this->db->query($sql);
        $data = $query->result();
        return $query->result_array();

    }

}
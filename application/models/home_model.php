<?php

class home_model extends CI_Model {

    /**
     * Responsable for auto load the database
     * @return void
     */
    public function __construct() {
        $this->load->database();
    }

    function getAllposts() {
        $this->db->select('*');
        $this->db->from('posts');
        $query = $this->db->get();

        return $query->result_array();
    }

    function getPosts_by_field_value($field = array(), $value = array()) {
        $this->db->select('*');
        $this->db->from('posts');
        if (count($field) > 0) {

            for ($i = 0; $i < count($field); $i++) {
                $this->db->where($field[$i], $value[$i]);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function getAllCountry() {
        $this->db->select('*');
        $this->db->from('country');
        //$this->db->join('posts', 'posts.country = country.country_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getState_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('state');
        $this->db->group_by('state_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getCity_by_field_value($field, $value) {
        $this->db->select('*');
        $this->db->from('city');
        //$this->db->order_by("city_name", "asc"); 
        $this->db->group_by('city_name');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_city_by_post($table, $field, $value) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join('country', 'country.country_id= city.country_id');
        $query = $this->db->get();
        // $abc = $this->db->last_query();
        return $query->result_array();
    }

}

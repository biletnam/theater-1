<?php

class user_model extends CI_Model {

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
        $this->db->from('user');
        /* $this->db->select('user.*,site_language.language_longform');
          $this->db->from('user');
          $this->db->join('site_language', 'user.language_interface = site_language.site_language_id','left'); */
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_filed($field, $value) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($field, $value);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_countries($order = null, $order_by = null) {
        $this->db->select('*');
        $this->db->from('countries');
        if ($order) {
            $this->db->order_by($order, $order_by);
        } else {
            $this->db->order_by('id', 'ASC');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_countries_by_id($id) {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('id', $id);
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

        $get_parent_userids = model_load_model('user_role_extended_model')->get_user_role_extended_by_field_array(array("parent_user_id"), array(Access_level::session_user_id()));
        $this->db->select('*');
        $this->db->from('user');
        $parent_ids[] = Access_level::session_user_id();
        switch (Access_level::session_user_type()) {
            case 'super_admin':

                break;

            case 'admin':
                for ($i = 0; $i < count($get_parent_userids); $i++) {
                    $parent_ids[] = $get_parent_userids[$i]['user_id'];
                }
                break;

            default:
                break;
        }

        $parent_string = implode(",", $parent_ids);
        if (Access_level::session_user_type() != 'super_admin') {
            $this->db->where("user_id IN ($parent_string)");
        }


        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }
        //$this->db->order_by('status', 'Active');

        if ($search_string) {
            if ($order == 'language_interface') {
                $this->load->model('site_language_model');
                //$language_interface = $this->site_language_model->get_language_by_id();
                //$lang = !empty($language_interface[0]['language_longform']) ? $language_interface[0]['language_longform'] : '--';
                $this->db->join('site_language', 'user.language_interface = site_language.site_language_id');
                $order = 'site_language.language_longform';
            }
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('user_id');

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
        $this->db->from('user');
        //$this->db->where('status', 'Active');
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
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function store_user($data) {
        $insert = $this->db->insert('user', $data);
        return $insert;
    }

    /**
     * Update user
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function update_user($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update('user', $data);
        //echo $this->db->last_query();
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_user_afffiliate_email($email, $data) {
        $this->db->where('primary_email', $email);
        $this->db->update('user', $data);
    }

    function update_affiliate_earn_by_email($email, $data) {
        $this->db->where('primary_email', $email);
        $this->db->update('user', $data);
    }

    function add_afffiliate_email($data) {
        $insert = $this->db->insert('affiliate', $data);
        return $insert;
    }

    function update_user_by_email($email, $data) {
        $this->db->where('primary_email', $email);
        $this->db->update('user', $data);
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        if ($report !== 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_user_by_field($field, $value, $data) {
        $this->db->where($field, $value);
        $this->db->update('user', $data);
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
     * Delete user
     * @param int $id - user id
     * @return boolean
     */
    function delete_user($id) {
        $this->db->where('user_id', $id);
        $this->db->where('user_id !=', 1);
        $this->db->delete('user');
    }

    //User ROLE queries Start
    public function get_user_role_by_userid($user_id) {
        $this->db->select('*');
        $this->db->from('user_role');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //User ROLE queries End
}

?>
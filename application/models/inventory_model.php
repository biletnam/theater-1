<?php

class inventory_model extends CI_Model {

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
    public function get_products_by_id($id) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('products_id', $id);
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
    public function get_inventory($search_string = null, $order = null, $order_type = 'DESC', $limit_start = null, $limit_end = null, $wherestatus = null) {

        $this->db->select('*');
        $this->db->from('inventory');

        if ($wherestatus != null) {
            $this->db->where('status', $wherestatus);
        }

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        $this->db->group_by('inventory_id');

        if ($order) {
            $this->db->order_by($order, $order_type);
        } else {
            $this->db->order_by('inventory_id', $order_type);
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
    function count_inventory($search_string = null, $order = null) {
        $this->db->select('*');
        $this->db->from('inventory');

        if ($search_string) {
            $this->db->like($order, $search_string);
        }
        if ($order) {
            $this->db->order_by($order, 'Asc');
        } else {
            $this->db->order_by('inventory_id', 'Asc');
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    /**
     * Store the new item into the database
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function getCategoryPathById($iCatId) {

        $sql_query = "select path FROM products where products_id='$iCatId'";
        $query = $this->db->query($sql_query);
        $db_cat_rs = $query->result_array();
        return $db_cat_rs[0]['path'];
    }

    function addPosts() {
        $insertArr['uid '] = Access_level::session_user_id();
        $insertArr['category_id'] = $_POST['category_id'];
        $insertArr['title'] = $_POST['title'];
        $insertArr['price'] = $_POST['price'];
        $insertArr['images'] = $_POST['images'];
        $insertArr['description'] = $_POST['description'];
        $insertArr['status'] = $_POST['status'];
        $insertArr['is_group'] = isset($_POST['is_group']) ? $_POST['is_group'] : "";
        $insert = $this->db->insert('products', $insertArr);
        return $insert;
    }

    /**
     * Update category
     * @param array $data - associative array with data to store
     * @return boolean
     */
    function getAutocompleteProductList($where = '') {
        $autoProduct = array();
        $sql = "select * from item_row_material where 1 AND status = 'Active' {$where}";

        $query = $this->db->query($sql);
        $data = $query->result();
        if ($data) {
            foreach ($data as $dataP) {
                $temp = array();
                $temp['item_row_material_id'] = $dataP->item_row_material_id;
                $temp['value'] = $dataP->name;
                $temp['name'] = $dataP->name;
                $temp['uom'] = $dataP->uom;
                $temp['qty'] = $dataP->qty;
                $temp['tokens'] = array($temp['item_row_material_id'], $temp['name']);
                $autoProduct[$dataP->item_row_material_id] = $temp;
            }
        }
        return $autoProduct1 = json_encode($autoProduct);
        //return $autoProduct;
    }

    function get_uom_by_id($item_row_material_id) {
        $this->db->select('uom');
        $this->db->from('item_row_material');
        $this->db->where('item_row_material_id', $item_row_material_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cost_by_id($item_row_material_id) {
        $this->db->select('cost');
        $this->db->from('item_row_material');
        $this->db->where('item_row_material_id', $item_row_material_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function store_ingredients($data) {
        $insert = $this->db->insert('product_ingredients', $data);
        return $insert;
    }

    public function get_ingredients_data_by_product_id($product_id) {
        $this->db->select('*');
        $this->db->from('product_ingredients');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function delete_products_ingr_by_id($id) {
        $this->db->where('product_ingredients_id', $id);
        $this->db->delete('product_ingredients');
    }

    function update_ingredients($id, $data) {
        $this->db->where('product_ingredients_id', $id);
        $this->db->update('product_ingredients', $data);
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

    public function get_inventory_by_id($id) {
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where('inventory_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function update_inventory($id, $data) {
        $this->db->where('inventory_id', $id);
        $this->db->update('inventory', $data);
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

    function delete_inventory_by_id($id) {
        $this->db->where('inventory_id', $id);
        $this->db->delete('inventory');
    }

}

?>
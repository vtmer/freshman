<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * Tag 模型
 */
class Tag_model extends CI_Model {
    public function is_unique($name) {
        return !$this->get_by_name($name);
    }

    public function create($name) {
        if (!$this->is_unique($name)) {
            return $this->db
                ->get_where('tags', array('name' => $name))->result();
        }

        $this->db->insert('tags', array(
            'name' => $name
        ));
        return $this->db->insert_id();
    }

    public function get_by_name($name) {
        return $this->db
            ->get_where('tags', array('name' => $name))
            ->result();
    }

    public function get_all() {
        return $this->db->get('tags')->result();
    }
    
    public function get_all_array() {
        return $this->db->get('tags')->result_array();
    }
}

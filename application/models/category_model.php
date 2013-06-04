<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * Categoriy 模型
 */
class Category_model extends CI_Model {
    public function is_unique($name) {
        $query = $this->db
            ->get_where('categories', array('name' => $name));
        return !$query->result();
    }

    public function create($name) {
        if (!$this->is_unique($name)) {
            return $this->db
                ->get_where('categories', array('name' => $name))->result();
        }

        $this->db->insert('categories', array(
            'name' => $name
        ));
        return $this->db->insert_id();
    }

    public function update($cate_id, $name) {
        $this->db
            ->where('id', $cate_id)
            ->update('categories', array('name' => $name));
        return $cate_id;
    }

    public function remove($cate_id) {
        $this->db
            ->where('id', $cate_id)
            ->delete('categories');
        return true;
    }

    public function get_posts($cate_id) {
        return $this->db
            ->join('posts', 'posts_categories.post_id = posts.id')
            ->get_where('posts_categories', array('posts_categories.category_id' => $cate_id))
            ->result();
    }

    public function get_all() {
        return $this->db->get('categories')->result();
    }

    public function get_by_id($cate_id) {
        return $this->db->get_where('categories', array(
            'id' => $cate_id
        ))->result();
    }
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

class Post_model extends CI_Model {
    function validate($author_id, $content, $title, $source) {
        if ($content === '' || $title === '')
            return false;

        $query = $this->db
            ->get_where('users', array('id' => $author_id), 1);
        if (!$query->result())
            return false;

        return true;
    }

    function create($author_id, $content, $title, $source) {
        $this->db->insert('posts', array(
            'author_id' => $author_id,
            'content' => $content,
            'title' => $title,
            'source' => $source
        ));
        return $this->db->insert_id();
    }
}

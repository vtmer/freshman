<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

class Post_model extends CI_Model {
    public function validate($author_id, $content, $title, $source) {
        if ($content === '' || $title === '')
            return false;

        $query = $this->db
            ->get_where('users', array('id' => $author_id), 1);
        if (!$query->result())
            return false;

        return true;
    }

    public function create($author_id, $content, $title, $source) {
        $this->db->insert('posts', array(
            'author_id' => $author_id,
            'content' => $content,
            'title' => $title,
            'source' => $source
        ));
        return $this->db->insert_id();
    }

    private function pack_posts($posts) {
        foreach ($posts as $post) {
            $post->author = $this->get_author($post->author_id);
            $post->categories = $this->get_categories($post->id);
            $post->tags = $this->get_tags($post->id);
        }

        return $posts;
    }

    public function get_all_posts() {
        $posts = $this->db
            ->get('posts')
            ->result();

        return $this->pack_posts($posts);
    }

    public function get_self_posts($author_id) {
        $posts = $this->db
            ->get_where('posts', array('author_id' => $author_id))
            ->result();
        
        return $this->pack_posts($posts);
    }

    public function get_author($author_id) {
        $query = $this->db
            ->get_where('users', array('id' => $author_id), 1);
        if ($query->result())
            return $query->result()[0];
        return null;
    }

    public function get_categories($post_id) {
        return $this->db
            ->select('categories.*')
            ->join('categories', 'posts_categories.category_id = categories.id')
            ->get_where('posts_categories', array('post_id' => $post_id))
            ->result();
    }

    public function get_tags($post_id) {
        return $this->db
            ->select('tags.*')
            ->join('tags', 'posts_tags.tag_id = tags.id')
            ->get_where('posts_tags', array('post_id' => $post_id))
            ->result();
    }
}

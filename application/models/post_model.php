<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * 文章模型
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

    /*
     * 对文章记录进行包装
     * 添加作者、类别、标签、校区和阅读数等信息
     */
    public function pack_post($post) {
        if (!$post)
            return $post;

        $post->author = $this->get_author($post->author_id);
        $post->categories = $this->get_categories($post->id);
        $post->tags = $this->get_tags($post->id);
        $post->campus = $this->get_campus($post->id);
        $post->viewtimes = $this->get_viewtimes($post->id);
        return $post;
    }

    public function pack_posts($posts) {
        foreach ($posts as $post) {
            $post = $this->pack_post($post);
        }

        return $posts;
    }

    public function get_all_posts() {
        $posts = $this->db
            ->get('posts')
            ->result();

        return $this->pack_posts($posts);
    }

    /*
     * 获取用户自身的文章
     */
    public function get_self_posts($author_id) {
        $posts = $this->db
            ->get_where('posts', array('author_id' => $author_id))
            ->result();
        
        return $this->pack_posts($posts);
    }

    public function get_by_id($post_id) {
        $query = $this->db
            ->get_where('posts', array('id' => $post_id))
            ->result();
        if ($query) {
            return $this->pack_post($query[0]);
        }
        return null;
    }

    public function get_author($author_id) {
        $query = $this->db
            ->get_where('users', array('id' => $author_id), 1);
        $result = $query->result();
        if ($result)
            return $result[0];
        return null;
    }

    public function get_campus($post_id) {
        $query = $this->db
            ->get_where('post_metas', array(
                'post_id' => $post_id,
                'key' => 'campus'
            ))
            ->result();
        $ret = array();
        if ($query) {
            foreach ($query as $c)
                $ret[] = $c->value;
        }
        return $ret;
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

    public function get_viewtimes($post_id) {
        $times = $this->db
            ->where('post_id', $post_id)
            ->where('key', 'viewtimes')
            ->get('post_metas')
            ->result();
        if ($times) {
            return (int) $times[0]->value;
        } else {
            $this->db->insert('post_metas', array(
                'post_id' => $post_id,
                'key' => 'viewtimes',
                'value' => 0
            ));
            return 0;
        }
    }

    public function create($value) {
        $this->db->insert('posts', $value);
        return $this->get_by_id($this->db->insert_id());
    }

    public function update($post_id, $value) {
        $this->db
            ->where('id', $post_id)
            ->update('posts', $value);
        return $this->get_by_id($post_id);
    }

    public function update_categories($post_id, $categories) {
        $this->db
            ->delete('posts_categories', array('post_id' => $post_id));
        foreach ($categories as $cate_id) {
            $this->db
                ->insert('posts_categories', array(
                    'post_id' => $post_id,
                    'category_id' => $cate_id
                ));
        }
    }

    public function update_tags($post_id, $tags) {
        $this->db
            ->delete('posts_tags', array('post_id' => $post_id));
        foreach ($tags as $tag_name) {
            $tag = $this->db
                ->get_where('tags', array('name' => $tag_name), 1)
                ->result();
            if ($tag) {
                $tag_id = $tag[0]->id;
            } else {
                $this->db
                    ->insert('tags', array('name' => $tag_name));
                $tag_id = $this->db->insert_id();
            }
            $this->db
                ->insert('posts_tags', array(
                    'post_id' => $post_id,
                    'tag_id' => $tag_id
                ));
        }
    }

    public function update_campus($post_id, $campus) {
        $this->db
            ->delete('post_metas',array('post_id' => $post_id));
        foreach ($campus as $c) {
            $this->db
                ->insert('post_metas', array(
                    'post_id' => $post_id,
                    'key' => 'campus',
                    'value' => $c
                ));
        }
    }

    public function update_viewtimes($post_id) {
        $this->db
            ->update('post_metas', array(
                'value' => $this->get_viewtimes($post_id) + 1
            ), array(
                'post_id' => $post_id,
                'key' => 'viewtimes'
            ));
    }

    public function remove($post_id) {
        $this->db
            ->delete('posts_categories', array('post_id' => $post_id));
        $this->db
            ->delete('posts_tags', array('post_id' => $post_id));
        $this->db
            ->delete('post_metas', array('post_id' => $post_id));
        $this->db
            ->delete('posts', array('id' => $post_id));
    }
}

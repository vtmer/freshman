<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once 'skel.php';

// 文章控制器
class Post extends Skel {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    // /p/(:num)
    public function post($post_id) {
        $this->load->model('post_model');
        $post = $this->post_model->get_by_id($post_id);
        if (!$post || $post->status !== '1') {
            // FIXME  统一的 404 页面
            redirect('404');
            return;
        }

        $this->display('front/article.html', array(
            'post' => $post,
            'categories' => $this->categories($this->visitor['campus'], 5),
            'relatives' => $this->relatives($post_id, $this->visitor['campus'], 5)
        ));
    }

    // 分类推荐
    private function categories($campus, $count) {
        $categories = array();
        foreach ($this->category_model->get_all() as $category) {
            $category->posts = $this->post_model->pack_posts(
                $this->post_model->db
                    ->limit($count)
                    ->join('post_metas', 'post_metas.post_id = posts.id')
                    ->join('posts_categories', 'posts_categories.post_id = posts.id')
                    ->where('posts_categories.category_id', $category->id)
                    ->where('posts.status', 1)
                    ->where('post_metas.key', 'campus')
                    ->where('post_metas.value', $campus)
                    ->order_by('posts.created_date', 'desc')
                    ->get('posts')
                    ->result()
            );
            $categories[] = $category;
        }
        return $categories;
    }

    // 相关文章
    private function relatives($post_id, $campus, $count) {
        $tags = $this->post_model->db
            ->join('posts_tags', 'posts_tags.tag_id = tags.id')
            ->where('posts_tags.post_id', $post_id)
            ->get('tags')
            ->result();
        $tag_ids = array();
        foreach ($tags as $tag) {
            $tag_ids[] = $tag->id;
        }
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->limit($count)
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->join('posts_tags', 'posts_tags.post_id = posts.id')
                ->where('posts.status', 1)
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where_in('posts_tags.tag_id', $tag_ids)
                ->get('posts')
                ->result()
        );
    }
}

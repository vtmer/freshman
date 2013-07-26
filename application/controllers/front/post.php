<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once 'skel.php';

/*
 * 文章控制器
 */
class Post extends Skel {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('json_resp');
    }

    /*
     * /p/(:num)
     */
    public function post($post_id) {
        $this->load->model('post_model');
        $post = $this->post_model->get_by_id($post_id);
        if (!$post || $post->status !== '1') {
            // FIXME  统一的 404 页面
            show_404();
            return;
        }
        // 更新 viewtimes
        $this->post_model->update_viewtimes($post->id);

        $this->display('front/content.html', array(
            'post' => $post,
            'categories' => $this->categories($this->visitor['campus'], 5),
            'relatives' => $this->relatives($post_id, $this->visitor['campus'], 5)
        ));
    }


    public function json_post($post_id) {
        $this->load->model('post_model');
        $post = $this->post_model->get_by_id($post_id);
        $this->post_model->update_viewtimes($post->id);
        $this->json_resp->display($post);
    }
        


    /* 
     * 获取分类推荐文章
     *
     * 到指定的分类下读取前 $count 篇文章
     *
     * TODO 更好的封装
     */
    private function categories($campus, $count) {
        $this->load->model('post_model');
        $this->load->model('category_model');
        $categories = array();
        foreach ($this->category_model->get_all() as $category) {
            $category->posts = $this->post_model->pack_posts(
                $this->post_model->db
                    ->select('posts.*')
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

    public function json_categories($campus,$count = 10) {
       $categories = $this->categories($campus,$count);
       $this->json_resp->display($categories);
    }

    /*
     * 获取相关文章
     *
     * 获取具有相同标签(tag)的文章
     *
     * TODO 更好的封装
     */
    private function relatives($post_id, $campus, $count) {
        // 获取该篇文章所有 tag 的 id
        $tags = $this->post_model->db
            ->join('posts_tags', 'posts_tags.tag_id = tags.id')
            ->where('posts_tags.post_id', $post_id)
            ->get('tags')
            ->result();
        $tag_ids = array();
        foreach ($tags as $tag) {
            $tag_ids[] = $tag->id;
        }
        if (!$tag_ids) {
            return;
        }
        // 获取具有相同 tag 的文章
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
                ->limit($count)
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->join('posts_tags', 'posts_tags.post_id = posts.id')
                ->where('posts.status', 1)
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where('posts.id <>', $post_id)
                ->where_in('posts_tags.tag_id', $tag_ids)
                ->distinct()
                ->get('posts')
                ->result()
        );
    }
}

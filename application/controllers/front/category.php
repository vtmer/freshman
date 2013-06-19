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
 * 分类控制器
 */
class Category extends Skel {
    public function __construct() {
        parent::__construct();
        
        $this->load->model('post_model');
        $this->load->model('category_model');
    }

    /*
     * /c/(:num)
     * TODO 分页
     */
    public function category($cate_id) {
        $category = $this->category_model->get_by_id($cate_id);
        if (!$category) {
            // FIXME  统一的 404 页面
            show_404();
            return;
        } else {
            $category = $category[0];
        }
        $category->posts = $this->posts($cate_id, $this->visitor['campus']);

        $this->display('front/list.html', array(
            'category' => $category
        ));
    }

    /* 
     * /c/all
     * 所有分类页面
     *TODO 分页
     */
    public function all() {
        $category = array(
            'name' => '所有文章',
            'posts' => $this->all_posts($this->visitor['campus'])
        );

        $this->display('front/list.html', array(
            'category' => $category
        ));
    }

    // TODO 更好的封装
    private function posts($cate_id, $campus) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
                ->join('posts_categories', 'posts_categories.post_id = posts.id')
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where('posts.status', 1)
                ->where('posts_categories.category_id', $cate_id)
                ->get('posts')
                ->result()
        );
    }

    // TODO 更好的封装
    private function all_posts($campus) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where('posts.status', 1)
                ->get('posts')
                ->result()
        );
    }
}

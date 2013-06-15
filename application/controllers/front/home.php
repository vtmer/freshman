<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once 'skel.php';

// 主页控制器
class Home extends Skel {
    public function __construct() {
        parent::__construct();

        $this->load->model('post_model');
        $this->load->model('category_model');
    }

    // /
    public function index() {
        $this->display('front/index.html', array(
            'latest' => $this->latest($this->visitor['campus']),
            'categories' => $this->categories($this->visitor['campus'])
        ));
    }

    // 最新动态
    protected function latest($campus, $count = 10) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->limit($count)
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('status', 1)
                ->where('key', 'campus')
                ->where('value', $campus)
                ->order_by('created_date', 'desc')
                ->get('posts')
                ->result()
        );
    }

    // 各个栏目
    protected function categories($campus, $count = 8) {
        $categories = array();
        foreach ($this->category_model->get_all() as $category) {
            $category->posts = $this->post_model->pack_posts(
                $this->post_model->db
                ->limit($count)
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('status', 1)
                ->where('key', 'campus')
                ->where('value', $campus)
                ->order_by('created_date', 'desc')
                ->get('posts')
                ->result()
            );
            $categories[] = $category;
        }
        return $categories;
    }
}

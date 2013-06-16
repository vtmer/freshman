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
            'categories' => $this->categories($this->visitor['campus']),
            'hottest' => $this->hot($this->visitor['campus'], 10)
        ));
    }

    // 最新动态
    private function latest($campus, $count = 10) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
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
    private function categories($campus, $count = 8) {
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

    // hot
    // XXX 不要使用原生 SQL 语句
    private function hot($campus, $threshold = 15, $count = 1) {
        return $this->post_model->pack_posts(
            $this->post_model->db->query("
                SELECT post.*
                FROM `fm_posts` post
                JOIN `fm_post_metas` vt
                ON vt.`post_id` = post.`id`
                JOIN `fm_post_metas` cp
                ON vt.`post_id` = cp.`post_id`
                WHERE
                    vt.`key` = 'viewtimes' AND
                    vt.`value` > ? AND
                    cp.`key` = 'campus' AND
                    cp.`value` = ?
                ORDER BY vt.`value` DESC
                LIMIT ?;", array($threshold, $campus, $count))
                ->result()
            );
    }
}

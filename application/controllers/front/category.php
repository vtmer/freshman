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
    // 分页配置
    protected $pages = array(
        'base_url' => '',
        'total_rows' => 0,
        'query_string_segment' => 'p',
        'per_page' => 25,
        'user_page_numbers' => false,
        'page_query_string' => true,

        'first_link' => '首页',
        'first_tag_open' => '<li>',
        'first_tag_close' => '</li>',

        'last_link' => '尾页',
        'last_tag_open' => '<li>',
        'last_tag_close' => '</li>',

        'next_link' => '>',
        'next_tag_open' => '<li>',
        'next_tag_close' => '</li>',

        'prev_link' => '<',
        'prev_tag_open' => '<li>',
        'prev_tag_close' => '</li>',

        'cur_tag_open' => '<li><a>',
        'cur_tag_close' => '</a></li>',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>'
    );

    public function __construct() {
        parent::__construct();
        
        $this->load->model('post_model');
        $this->load->model('category_model');
    }

    /*
     * /c/(:num)
     * 
     * 分页:
     *  p = 第 n 页
     */
    public function category($cate_id) {
        $config = $this->pages;
        $p = intval($this->input->get($config['query_string_segment']));
        $category = $this->category_model->get_by_id($cate_id);
        if (!$category) {
            // FIXME  统一的 404 页面
            show_404();
            return;
        } else {
            $category = $category[0];
        }
        $category->posts = $this->posts(
            $cate_id, $this->visitor['campus'],
            $config['per_page'], $p / $config['per_page']
        );

        $this->load->library('pagination');
        $this->load->helper('url');
        $config['base_url'] = site_url('/c/' . $cate_id);
        $config['total_rows'] = $this
            ->posts_count($cate_id, $this->visitor['campus']);
        $this->pagination->initialize($config);

        $this->display('front/list.html', array(
            'category' => $category,
            'categories' => $this->categories($this->visitor['campus']),
            'pagination' => $this->pagination->create_links()
        ));
    }
 	 /*
     * 获取各个栏目的文章
     *
     * TODO 更好的封装
     */
private function categories($campus, $count = 3) {
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
    /* 
     * /c/all
     * 所有分类页面
     * 
     * 分页:
     *  p = 第 n 页
     */
    public function all() {
        $config = $this->pages;
        $p = intval($this->input->get($config['query_string_segment']));
        $category = array(
            'name' => '所有文章',
            'posts' => $this->all_posts(
                $this->visitor['campus'],
                $config['per_page'],
                $p / $config['per_page'])
        );

        $this->load->library('pagination');
        $this->load->helper('url');
        $config['base_url'] = site_url('/c/all');
        $config['total_rows'] = $this->all_posts_count($this->visitor['campus']);
        $this->pagination->initialize($config);

        $this->display('front/list.html', array(
            'category' => $category,
            'pagination' => $this->pagination->create_links()
        ));
    }

    // TODO 更好的封装
    private function posts($cate_id, $campus, $limit, $page) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
                ->join('posts_categories', 'posts_categories.post_id = posts.id')
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where('posts.status', 1)
                ->where('posts_categories.category_id', $cate_id)
                ->distinct()
                ->limit($limit, $page * $limit)
                ->get('posts')
                ->result()
        );
    }

    private function posts_count($cate_id, $campus) {
        return sizeof($this->post_model->db
            ->select('posts.*')
            ->join('posts_categories', 'posts_categories.post_id = posts.id')
            ->join('post_metas', 'post_metas.post_id = posts.id')
            ->where('post_metas.key', 'campus')
            ->where('post_metas.value', $campus)
            ->where('posts.status', 1)
            ->where('posts_categories.category_id', $cate_id)
            ->distinct()
            ->get('posts')
            ->result());
    }

    // TODO 更好的封装
    private function all_posts($campus, $limit, $page) {
        return $this->post_model->pack_posts(
            $this->post_model->db
                ->select('posts.*')
                ->join('post_metas', 'post_metas.post_id = posts.id')
                ->where('post_metas.key', 'campus')
                ->where('post_metas.value', $campus)
                ->where('posts.status', 1)
                ->distinct()
                ->limit($limit, $page * $limit)
                ->get('posts')
                ->result()
        );
    }

    private function all_posts_count($campus) {
        return sizeof($this->post_model->db
            ->select('posts.*')
            ->join('post_metas', 'post_metas.post_id = posts.id')
            ->where('post_metas.key', 'campus')
            ->where('post_metas.value', $campus)
            ->where('posts.status', 1)
            ->distinct()
            ->get('posts')
            ->result());
    }
}

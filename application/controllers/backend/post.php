<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

require_once 'auth.php';

/*
 * Post 控制器
 *
 * 文章撰写、修改页面
 */
class Post extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model', 'model');
        $this->load->model('category_model');

        // XXX 抽离出来，不要污染全局环境
        $this->categories = $this->category_model->get_all();
    }

    // /backend/post/create
    public function create() {
        // XXX 抽离出来，不要污染全局环境
        $display = array(
            'user' => $this->user,
            'is_admin' => $this->is_admin,
            'categories' => $this->categories
        );
        $this->twig->display('backend/post.create.html', $display);
    }

    // /backend/post/(:num)
    public function edit($post_id) {
        $post = $this->model->get_by_id($post_id);
        if (!$post ||
            !($this->is_admin || $post->author->id === $this->user->id)) {
            redirect('404');
            return;
        }

        $display = array(
            'user' => $this->user,
            'is_admin' => $this->is_admin,
            'categories' => $this->categories,
            'post' => $post
        );
        $this->twig->display('backend/post.edit.html', $display);
    }

    // /backend/post/(:num)/publish
    public function publish($post_id) {
        $post = $this->model->get_by_id($post_id);
        if (!$post ||
            !($this->is_admin || $post->author->id === $this->user->id)) {
            $this->json_resp->display(array('error' => 'post not found'), 404);
            return;
        }

        $payload = $this->input->post();

        $this->model->update($post_id, array(
            'title' => $payload['title'],
            'content' => $payload['content'],
            'status' => $payload['status']
        ));
        $this->model->update_categories($post_id, $payload['categories']);
        $this->model->update_tags($post_id, $payload['tags']);
        $this->model->update_campus($post_id, $payload['campus']);

        $this->json_resp->display(array('msg' => 'ok'));
    }

    // /backend/post/autosave
    //
    // 只保存标题, 内容, 作者
    // 如果是新建的文章（不带 post_id），创建新的
    // 如果是已有的文章（带 post_id），更新
    public function autosave() {
        $payload = $this->input->post();

        if (array_key_exists('post_id', $payload)) {
            $post = $this->model->update($payload['post_id'], array(
                'content' => $payload['content'],
                'title' => $payload['title']
            ));
        } else {
            $post = $this->model->create(array(
                'content' => $payload['content'],
                'title' => $payload['title'],
                'author_id' => $this->user->id
            ));
        }
        if (!$post) {
            $this->json_resp->display(array(
                'error' => 'save'
            ), 403);
        } else {
            $this->json_resp->display(array(
                'post_id' => $post->id,
                'status' => $post->status
            ));
        }
    }

    // /backend/post/tags
    // ajax 获取所有 tags 接口
    public function get_tags() {
        $this->load->model('tag_model');
        $tags = $this->tag_model->get_all_array();
        $this->json_resp->display($tags);
    }

    // /backend/post/campus
    // ajax 获取所有 学校 接口
    public function get_campus() {
        $this->load->model('site_metas_model');
        $campus = array();
        foreach ($this->site_metas_model->get('campus') as $value) {
            $campus[] = $value->value;
        }
        $this->json_resp->display($campus);
    }
}

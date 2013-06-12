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
    }

    // /backend/post/create
    public function create() {
        $display = array(
            'user' => $this->user,
            'is_admin' => $this->is_admin
        );
        $this->twig->display('backend/post.create.html', $display);
    }

    // /backend/post/(:num)
    public function edit($post_id) {
        $post = $this->model->get_by_id($post_id);
        if (!$post) {
            redirect('404');
            return;
        }

        $display = array(
            'user' => $this->user,
            'is_admin' => $this->is_admin,
            'post' => $post
        );
        $this->twig->display('backend/post.edit.html', $display);
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
}

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
 * Dashboard 控制器
 *
 * 后台主页面
 */
class Dashboard extends Auth_Controller {
    // /backend/
    public function index() {
        if ($this->is_admin)
            redirect(site_url('/backend/admin'));
        else
            redirect(site_url('/backend/posts'));
    }
    
    // /backend/self/update
    // 更新用户个人信息
    public function self_update() {
        $payload = $this->input->post();
        if (array_key_exists('display_name', $payload)) {
            $ret = $this->user_model
                ->update_display_name($this->user->id, $payload['display_name']);
            if (!$ret) {
                $this->json_resp->display(array(
                    'error' => 'display_name'
                ), 403);
                return;
            }
        }
        if (array_key_exists('password', $payload)) {
            $ret = $this->user_model
                ->update_password($this->user->id, $payload['password']);
            if (!$ret) {
                $this->json_resp->display(array(
                    'error' => 'password'
                ), 403);
                return;
            }
        }
        $this->json_resp->display(array(
            'ret' => 'update ok'
        ), 200);
    }

    // /backend/posts
    public function posts() {
        $display = array(
            'user' => $this->user,
            'is_admin' => $this->is_admin
        );

        $this->load->model('post_model');
        if ($this->is_admin)
            $display['posts'] = $this->post_model->get_all_posts();
        else
            $display['posts'] = $this->post_model->get_self_posts($this->user->id);

        $this->twig->display('backend/posts.html', $display);
    }
}

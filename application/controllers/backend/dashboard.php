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

        $display = array(
            'user' => $this->user
        );
        $this->twig->display('backend/dashboard.html', $display);
    }
    
    // /backend/self/update
    // 更新用户个人信息
    public function self_update() {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header('200');

        $payload = $this->input->post();
        if (array_key_exists('display_name', $payload)) {
            $ret = $this->user_model
                ->update_display_name($this->user->id, $payload['display_name']);
            if (!$ret) {
                $this->output->set_status_header('403');
                $this->output->set_output(json_encode(
                    array('error' => 'display_name')
                ));
                return;
            }
        }
        if (array_key_exists('password', $payload)) {
            $ret = $this->user_model
                ->update_password($this->user->id, $payload['password']);
            if (!$ret) {
                $this->output->set_status_header('403');
                $this->output->set_output(json_encode(
                    array('error' => 'password')
                ));
                return;
            }
        }
        $this->output->set_output(json_encode(
            array('ret' => 'update ok')
        ));
    }
}

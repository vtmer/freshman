<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * User 控制器
 *
 * 提供用户登录、登出、创建等操作
 */
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model('user_model', 'model');
        $this->load->helper('url');
    }

    /*
     * /backend/login
     */
    public function login() {
        $display = array();

        // 获取登录后跳转地址
        $next = $this->input->get('next');
        if (!$next)
            $next = site_url('backend');
        if ($this->is_login())
            redirect($next);

        // 创建表单
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'username',
                'label' => 'Username:',
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'password',
                'label' => 'Password:',
                'rules' => 'required|xss_clean'
            )
        ));
        $display['form'] = form_open(
            site_url('backend/login') .'?next=' . $next,
            array(
                'class' => 'form-horizontal'
            )
        );

        if ($this->form_validation->run()) {
            $payload = $this->input->post();
            $token = $this->model
                ->login($payload['username'], $payload['password']);
            if ($token) {
                // 登录成功
                $this->session->set_userdata(array(
                    'username' => $payload['username'],
                    'token' => $token
                ));
                redirect($next);
            } else {
                // 登录失败
                $display['error'] = 'Username or password incorrect!';
            }
        }
        $this->twig->display('backend/login.html', $display);
    }

    /*
     * /backend/logout
     */
    public function logout() {
        $next = $this->input->get('next') or site_url('/');
        if (!$this->is_login())
            redirect(site_url('/backend/login'));

        $token = $this->session->userdata('token');
        $username = $this->session->userdata('username');
        // 擦去登录信息
        // TODO 过期 session 自动删除
        $this->model->logout($username, $token);
        $this->session->unset_userdata(array(
            'username' => '',
            'token' => ''
        ));

        redirect($next);
    }

    /*
     * /backend/deactive
     */
    public function deactive() {
        $display = array();
        $this->twig->display('backend/deactive.html', $display);
    }

    /*
     * 检查当前用户是否已经登录
     */
    private function is_login() {
        $token = $this->session->userdata('token');
        $username = $this->session->userdata('username');

        return $this->model->is_login($username, $token);
    }
}

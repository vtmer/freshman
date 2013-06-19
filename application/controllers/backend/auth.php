<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * Auth 控制器类
 *
 * 提供用户验证功能
 *
 * 如果用户没有登录，跳转到登录页面
 * 如果已经登录，会从 session 获取用户并保存在 $this->user 下
 * $this->is_admin 记录当前用户是否为管理员
 *
 * 后台需要登录权限的控制器都需要继承该类
 */
class Auth_Controller extends CI_Controller {
    // 当前用户
    protected $user;
    protected $user_roles;
    protected $is_admin;

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->model('site_metas_model');

        // 获取所有用户权限信息
        // TODO 抽取常用模块
        $roles = array();
        foreach ($this->site_metas_model->get('role') as $value) {
            $role = explode(':', $value->value);
            $roles[$role[0]] = $role[1];
        }

        $token = $this->session->userdata('token');
        $username = $this->session->userdata('username');
        $this->user = $this->user_model->get_by_token($username, $token);

        if (!$this->user)
            redirect(site_url('/backend/login?next=' . current_url()));
        if (!$this->user_model->is_active($this->user->id))
            redirect(site_url('/backend/deactive'));

        $this->user_roles = $this->user_model->get_roles($this->user->id);
        $this->is_admin = false;
        foreach ($this->user_roles as $role)
            if ($role->name === $roles['admin']) {
                $this->is_admin = true;
                break;
            }
    }
}

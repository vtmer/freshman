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
 * 管理员 Dashboard 控制器
 */
class Admin_Dashboard extends Auth_Controller {
    public function __construct() {
        parent::__construct();

        if (!$this->is_admin)
            redirect(site_url('404'));
    }

    /*
     * /backend/admin
     */
    public function index() {
        // 临时跳转
        redirect(site_url('/backend/posts'));
    }

    // user 部分
    // --------------------------------------------------------------------

    /* 
     * /backend/users
     */
    public function users() {
        // 获取所有用户权限信息
        // TODO 抽取常用模块
        $this->load->model('site_metas_model');
        $roles = array();
        foreach ($this->site_metas_model->get('role') as $value) {
            $role = explode(':', $value->value);
            $roles[$role[0]] = $role[1];
        }

        $admin_name = $roles['admin'];
        $users = $this->user_model->get_all_users();
        foreach ($users as $user) {
            $user->is_admin = $this->user_model
                                    ->is_role($user->id, $admin_name);
            $user->role_ids = array();
            foreach ($this->user_model->get_roles($user->id) as $role) {
                array_push($user->role_ids, $role->id);
            }
        }
        $this->load->model('role_model');
        $roles = $this->role_model->get_all_roles();

        $display = array(
            'user' => $this->user,
            'users' => $users,
            'roles' => $roles
        );

        $this->twig->display('backend/users.html', $display);
    }

    /*
     * /backend/user/create
     */
    public function user_create() {
        $payload = $this->input->post();

        // 确保创建的 role 存在
        $this->load->model('role_model');
        $role_ids = $this->role_model->get_all_role_ids();
        for ($i = 0;$i < count($payload['roles']);$i++) {
            if (!in_array($payload['roles'][$i], $role_ids)) {
                $this->json_resp->display(array(
                    'error' => 'roles'
                ), 403);
                return;
            }
        }

        if (!$this->user_model
                ->is_unique_login_name($payload['login_name'])) {
            $this->json_resp->display(array(
                'error' => 'login_name'
            ), 403);
            return;
        }
        if (!$this->user_model
                ->is_unique_display_name($payload['display_name'])) {
            $this->json_resp->display(array(
                'error' => 'display_name'
            ));
            return;
        }
        
        $user_id = $this->user_model->create(
            $payload['login_name'],
            $payload['display_name'],
            $payload['password'],
            $payload['roles']
        );

        if (!$user_id) {
            $this->json_resp->display(array(
                'error' => 'create'
            ), 403);
            return;
        }

        $this->json_resp->display(array(
            'ret' => 'create ok',
            'id' => $user_id
        ));
    }

    /*
     * /backend/user/(num:id)/edit
     */
    public function user_edit($id) {
        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            $this->json_resp->display(array(
                'error' => 'user not found'
            ), 404);
            return;
        }
        $user = $user[0];

        $payload = $this->input->post();

        // 确保 role 存在
        $this->load->model('role_model');
        $role_ids = $this->role_model->get_all_role_ids();
        for ($i = 0;$i < count($payload['roles']);$i++) {
            if (!in_array($payload['roles'][$i], $role_ids)) {
                $this->json_resp->display(array(
                    'error' => 'roles'
                ), 403);
                return;
            }
        }

        if ($user->display_name !== $payload['display_name'] && !$this->user_model
            ->is_unique_display_name($payload['display_name'])) {
            $this->json_resp->display(array(
                'error' => 'display_name'
            ), 403);
            return;
        }
        if ($user->login_name !== $payload['login_name'] && !$this->user_model
            ->is_unique_login_name($payload['login_name'])) {
            $this->json_resp->display(array(
                'error' => 'login_name'
            ), 403);
            return;
        }

        $ret = $this->user_model
            ->update($id,
                $payload['login_name'], $payload['display_name'],
                $payload['password'], $payload['roles']);
        if (!$ret) {
            $this->json_resp->display(array(
                'error' => 'update'
            ), 403);
            return;
        }

        $this->json_resp->display(array(
            'ret' => 'update ok',
            'id' => $id
        ), 200);
    }
    
    // category 部分
    // --------------------------------------------------------------------

    /*
     * /backend/categries
     */
    public function categories() {
        $this->load->model('category_model');
        $categories = $this->category_model->get_all();

        foreach ($categories as $category) {
            $category->posts = $this->category_model->get_posts($category->id);
        }

        $display = array(
            'user' => $this->user,
            'categories' => $categories
        );

        $this->twig->display('backend/categories.html', $display);
    }

    /* 
     * /backend/category/create
     */
    public function category_create() {
        $payload = $this->input->post();
        $this->load->model('category_model');

        if (!$this->category_model->is_unique($payload['name'])) {
            $this->json_resp->display(array(
                'error' => 'name'
            ), 403);
            return;
        }

        $category_id = $this->category_model->create($payload['name']);

        if (!$category_id) {
            $this->json_resp->display(array(
                'error' => 'create'
            ), 403);
            return;
        }
        
        $this->json_resp->display(array(
            'ret' => 'create ok',
            'id' => $category_id
        ));
    }

    /*
     * /backend/category/(num:id)/edit
     */
    public function category_edit($id) {
        $this->load->model('category_model');
        $category = $this->category_model->get_by_id($id);
        if (!$category) {
            $this->json_resp->display(array(
                'error' => 'category not found'
            ), 403);
            return;
        }
        $category = $category[0];

        $payload = $this->input->post();

        if ($category->name !== $payload['name'] && !$this->category_model
            ->is_unique($payload['name'])) {
            $this->json_resp->display(array(
                'error' => 'name'
            ), 403);
            return;
        }

        $ret = $this->category_model->update($id, $payload['name']);
        if (!$ret) {
            $this->json_resp->display(array(
                'error' => 'update'
            ), 403);
            return;
        }
        
        $this->json_resp->display(array(
            'ret' => 'update ok',
            'id' => $id
        ));
    }
    
    /*
     * /backend/category/(num:id)/remove
     */
    public function category_remove($id) {
        $this->load->model('category_model');
        $category = $this->category_model->get_by_id($id);
        if (!$category) {
            $this->json_resp->display(array(
                'error' => 'category not found'
            ), 403);
            return;
        }
        $category = $category[0];

        $ret = $this->category_model->remove($category->id);
        if (!$ret) {
            $this->json_resp->display(array(
                'error' => 'remove'
            ), 403);
            return;
        }
        
        $this->json_resp->display(array(
            'ret' => 'removed',
            'id' => $id
        ));
    }
}

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

    // /backend/admin
    public function index() {
        // 临时跳转
        redirect(site_url('/backend/users'));
    }

    // /backend/users
    public function users() {
        $admin_name = $this->config->item('role_name')['admin'];
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

    // /backend/user/create
    public function user_create() {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header('200');

        $payload = $this->input->post();

        // 确保创建的 role 存在
        $this->load->model('role_model');
        $role_ids = $this->role_model->get_all_role_ids();
        for ($i = 0;$i < count($payload['roles']);$i++) {
            if (!in_array($payload['roles'][$i], $role_ids)) {
                $this->output->set_status_header('403');
                $this->output->set_output(json_encode(
                    array('error' => 'roles')
                ));
                return;
            }
        }

        if (!$this->user_model
                ->is_unique_login_name($payload['login_name'])) {
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'login_name')
            ));
            return;
        }
        if (!$this->user_model
                ->is_unique_display_name($payload['display_name'])) {
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'display_name')
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
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'create')
            ));
            return;
        }

        $this->output->set_output(json_encode(
            array(
                'ret' => 'create ok',
                'id' => $user_id
            )
        ));
    }

    // /backend/user/(num:id)/edit
    public function user_edit($id) {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header('200');

        $user = $this->user_model->get_by_id($id);
        if (!$user) {
            $this->output->set_status_header('404');
            $this->output->set_output(json_encode(
                array('error' => 'user not found')
            ));
            return;
        }
        $user = $user[0];

        $payload = $this->input->post();

        // 确保 role 存在
        $this->load->model('role_model');
        $role_ids = $this->role_model->get_all_role_ids();
        for ($i = 0;$i < count($payload['roles']);$i++) {
            if (!in_array($payload['roles'][$i], $role_ids)) {
                $this->output->set_status_header('403');
                $this->output->set_output(json_encode(
                    array('error' => 'roles')
                ));
                return;
            }
        }

        if ($user->display_name !== $payload['display_name'] && !$this->user_model
            ->is_unique_display_name($payload['display_name'])) {
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'display_name')
            ));
            return;
        }
        if ($user->login_name !== $payload['login_name'] && !$this->user_model
            ->is_unique_login_name($payload['login_name'])) {
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'login_name')
            ));
            return;
        }

        $ret = $this->user_model
            ->update($id,
                $payload['login_name'], $payload['display_name'],
                $payload['password'], $payload['roles']);
        if (!$ret) {
            $this->output->set_status_header('403');
            $this->output->set_output(json_encode(
                array('error' => 'update')
            ));
            return;
        }

        $this->output->set_output(json_encode(
            array(
                'ret' => 'update ok',
                'id' => $id
            )
        ));
    }
}

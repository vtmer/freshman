<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * User 模型
 *
 * 用户密码加密方法：SHA1(原始密码 + 加密盐)
 */
class User_model extends CI_Model {
    private $salt;

    public function __construct() {
        $this->salt = $this->config->item('encryption_key');
    }

    public function get_by_token($username, $token) {
        $query = $this->db
            ->get_where('users', array('login_name' => $username));
        if (!$query->result())
            return;

        $user = $query->result()[0];

        $query = $this->db
            ->select('user_id')
            ->get_where('sessions', array('key' => $token));
        if (!$query->result())
            return;
        if ($query->result()[0]->user_id == $user->id)
            return $user;
    }

    public function get_by_id($user_id) {
        return $this->db
            ->get_where('users', array('id' => $user_id))->result();
    }

    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    /*
     * login
     *
     * @return 登录成功: session token 登录失败: false
     */
    public function login($username, $password) {
        $query = $this->db
            ->get_where('users', array(
                'login_name' => $username,
                'password' => $this->encrypt($password)
            ), 0);
        if (!$query->result())
            return false;

        $user = $query->result()[0];

        /* 创建 session */
        $token = $this->encrypt($username . time());
        $this->db->insert('sessions', array(
            'key' => $token,
            'user_id' => $user->id
        ));
        return $token;
    }

    public function logout($username, $token) {
        $query = $this->db
            ->select('id')
            ->get_where('users', array('login_name' => $username));
        if (!$query->result())
            return;

        $user_id = $query->result()[0]->id;
        $this->db
            ->where(array('key' => $token, 'user_id' => $user_id))
            ->delete('sessions');
    }

    public function create($lname, $dname, $pwd, $roles) {
        if (!$this->is_unique_login_name($lname))
            return false;
        if (!$this->is_unique_display_name($dname))
            return false;

        $this->db->insert('users', array(
            'login_name' => $lname,
            'display_name' => $dname,
            'password' => $this->encrypt($pwd)
        ));
        $user_id = $this->db->insert_id();
        if (!$user_id)
            return false;

        for ($i = 0;$i < count($roles);$i++) {
            $this->db->insert('users_roles', array(
                'user_id' => $user_id,
                'role_id' => $roles[$i]
            ));
        }
        return $user_id;
    }

    public function update($user_id, $lname, $dname, $pwd, $roles) {
        $update = array(
            'login_name' => $lname,
            'display_name' => $dname
        );
        if ($pwd)
            $update['password'] = $this->encrypt($pwd);
        $this->db
            ->where('id', $user_id)
            ->update('users', $update);

        // 先把之前的用户组信息删除
        $this->db
            ->where('user_id', $user_id)
            ->delete('users_roles');
        for ($i = 0;$i < count($roles);$i++) {
            $this->db->insert('users_roles', array(
                'user_id' => $user_id,
                'role_id' => $roles[$i]
            ));
        }

        return $user_id;
    }

    public function update_display_name($user_id, $display_name) {
        if (!$this->is_unique_display_name($display_name, $user_id))
            return false;

        $this->db
            ->where('id', $user_id)
            ->update('users', array('display_name' => $display_name));
        return true;
    }

    public function update_password($user_id, $password) {
        $this->db
            ->where('id', $user_id)
            ->update('users', array('password' => $this->encrypt($password)));
        return true;
    }

    public function is_login($username, $token) {
        $ret = $this->get_by_token($username, $token);
        if ($ret)
            return true;
        return false;
    }

    public function get_roles($user_id) {
        $query = $this->db
            ->join('roles', 'roles.id = users_roles.role_id')
            ->get_where('users_roles', array('users_roles.user_id' => $user_id));
        return $query->result();
    }

    public function is_role($user_id, $role_name) {
        $roles = $this->get_roles($user_id);

        foreach ($roles as $role)
            if ($role->name === $role_name)
                return true;
        return false;
    }

    public function is_active($user_id) {
        $query = $this->db
            ->select('active')
            ->get_where('users', array('id' => $user_id), 1);
        if (!$query->result())
            return false;
        return (intval($query->result()[0]->active) === 1);
    }

    protected function is_unique($field, $value, $user_id = 0) {
        $query = $this->db
            ->get_where('users', array($field => $value));
        if ($query->result() && $query->result()[0]->id != $user_id)
            return false;
        return true;
    }

    public function is_unique_display_name($display_name, $user_id = 0) {
        return $this->is_unique('display_name', $display_name, $user_id);
    }

    public function is_unique_login_name($login_name, $user_id = 0) {
        return $this->is_unique('login_name', $login_name, $user_id);
    }

    private function encrypt($raw) {
        return sha1($raw . $this->salt);
    }
}

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

    public function is_login($username, $token) {
        $ret = $this->get_by_token($username, $token);
        if ($ret)
            return true;
        return false;
    }

    private function encrypt($raw) {
        return sha1($raw . $this->salt);
    }
}

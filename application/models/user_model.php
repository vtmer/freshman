<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    private $table = 'users';

    private function encrypt($raw) {
        return sha1($raw);
    }

    private function set_roles($user_id, $role_name) {
        $query = $this->db
            ->select('id')
            ->get_where('roles', array('name' => $role_name), 1);
        if (!$query->result())
            return;

        $role_id = $query->result()[0]->id;
        $this->db->insert('users_roles', array(
            'user_id' => $user_id,
            'role_id' => $role_id
        ));
        return $this->db->insert_id();
    }

    function create($login_name, $display_name, $password, $role_name) {
        if (!$this->validate($login_name, $display_name, $role_name))
            return -1;

        $salt = $this->config->item('encryption_key');
        $this->db->insert($this->table, array(
            'login_name' => $login_name,
            'display_name' => $display_name,
            'password' => $this->encrypt($password . $salt)
        ));
        $id = $this->db->insert_id();
        $this->set_roles($id, $role_name);

        return $id;
    }

    function validate($login_name, $display_name, $role_name) {
        /* ensure the name is unique */
        $query = $this->db
            ->where(array('login_name', $login_name))
            ->or_where(array('display_name', $display_name))
            ->get($this->table);
        if ($query->result())
            return false;

        /* ensure the role is correct */
        $query = $this->db
            ->where(array('name', $role_name))
            ->get('roles', 1);
        if (!$query->result())
            return false;

        return true;
    }

    function get_roles($user_id, $fields = null) {
        $fields = $fields ? $fields : '*';
        $query = $this->db
            ->select($fields)
            ->join('roles', 'roles.id = users_roles.role_id')
            ->where(array('user_id' => $user_id))
            ->get('users_roles');
        return $query->result();
    }

    function check_permissions($user_id, $scope, $right) {
        $pattern = $scope . ':' . $right;
        $query = $this->db
            ->where(array('pattern' => $pattern))
            ->get('permissions', 1);
        /* if there is no rule for this, you can use this. */
        if (!$query->result())
            return true;

        $permission_id = $query->result()[0]->id;
        $role_ids = array();
        foreach ($this->get_roles($user_id, array('role_id')) as $row)
            array_push($role_ids, $row->role_id);
        if (!$role_ids)
            return false;

        /* check if the roles and the permissions grant for match */
        $query = $this->db
            ->where_in('role_id', $role_ids)
            ->where(array('permission_id' => $permission_id))
            ->get('roles_permissions');
        if ($query->result())
            return true;
        return false;
    }
}

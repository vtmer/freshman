<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * Role 模型
 */
class Role_model extends CI_Model {
    function get_all_roles() {
        return $this->db->get('roles')->result();
    }

    function get_all_role_ids() {
        $role_ids = array();
        $roles = $this->get_all_roles();
        foreach ($roles as $role) {
            array_push($role_ids, $role->id);
        }

        return $role_ids;
    }
}

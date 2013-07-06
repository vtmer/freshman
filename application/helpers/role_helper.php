<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_roles')) {
    function get_roles() {
        $CI =& get_instance();
        $CI->load->model('site_metas_model');

        $roles = array();
        foreach ($CI->site_metas_model->get('role') as $value) {
            $role = explode(':', $value->value);
            $roles[$role[0]] = $role[1];
        }

        return $roles;
    }
}

if (!function_exists('is_admin')) {
    function is_admin($user_roles) {
        $roles = get_roles();

        foreach ($user_roles as $role) {
            if ($role->name === $roles['admin'])
                return true;
        }
        return false;
    }
}

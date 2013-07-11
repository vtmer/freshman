<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_all_campus')) {
    function get_all_campus() {
        $CI =& get_instance();
        $CI->load->model('site_metas_model');

        $campus = array();
        foreach ($CI->site_metas_model->get('campus') as $c) {
            $campus[] = $c->value;
        }

        return $campus;
    }
}

if (!function_exists('default_campus')) {
    function default_campus() {
        $result = get_all_campus();
            return $result[0];
    }
}

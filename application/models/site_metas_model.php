<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

/*
 * Site_metas 模型
 */
class Site_metas_model extends CI_Model {
    public function get($key) {
        return $this->db
            ->get_where('site_metas', array('key' => $key))
            ->result();
    }
}

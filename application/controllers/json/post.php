<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->library('json_resp');
    }

    public function post($post_id) {
        $post = $this->post_model->get_by_id($post_id);
        $this->post_model->update_viewtimes($post->id);

        $this->json_resp->display($post);
    }

    public function category($category_id) {
        $categories = $this->get_by_id($category_id);
    }
}

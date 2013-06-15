<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

class Hello extends CI_Controller {
    public function index() {
        $this->load->model('post_model');
        $this->twig->display('front/index.html', array(
            'posts' => $this->post_model->get_all_posts()
        ));
    }
}

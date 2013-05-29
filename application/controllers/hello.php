<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Hello extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->library('twig');
        $this->load->model('user_model', 'model');
    }

    public function index() {
        $this->model->check_permissions(9, 'post', 'read');
        $this->twig->display('hello.html');
    }
}

<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Hello extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('twig');
    }

    public function index() {
        $this->twig->display('hello.html');
    }
}

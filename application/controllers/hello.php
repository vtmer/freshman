<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Hello extends CI_Controller {
    public function index() {
        $this->twig->display('hello.html');
    }
}

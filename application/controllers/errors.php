<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

class Errors extends CI_Controller {
    public function not_found() {
        $this->twig->display('errors/404.html');
    }
}

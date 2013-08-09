<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once 'skel.php';

class Faq extends Skel {
    public function index() {
        $this->display('front/faq/faq.html');
    }
}

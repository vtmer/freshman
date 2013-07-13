<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

require_once 'skel.php';

/*
 * E 眼工大控制器
 */
class Map extends Skel {
    public function __construct() {
        parent::__construct();
    }

    /*
     * /map
     */
    public function index() {
        $this->display('front/map.html',array($this->visitor['campus']));
    }
}

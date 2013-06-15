<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

// 骨架控制器
//
// 提供基本渲染元素
class Skel extends CI_Controller {
    protected $display;
    protected $visitor;

    public function __construct() {
        parent::__construct();

        $this->setupsession();
        $this->prepare();
    }

    // 根据 GET 输入设置 session 信息
    protected function setupsession() {
        $this->load->model('site_metas_model');

        // 设置校区
        $campus = $this->input->get('c', TRUE);
        if ($campus) {
            $this->session->set_userdata(array(
                'campus' => $campus
            ));
        };
    }

    protected function prepare() {
        $this->load->model('site_metas_model');
        $this->load->model('category_model');

        $campus = array();
        foreach ($this->site_metas_model->get('campus') as $c) {
            $campus[] = $c->value;
        }

        // 获取当前浏览用户信息
        $this->visitor = array(
            'campus' => $this->session->userdata('campus')
        );
        if (!$this->visitor['campus'] ||
            !in_array($this->visitor['campus'], $campus)) {
            $this->visitor['campus'] = $campus[0];
        }

        $this->display = array(
            'campus' => $campus,
            'categories' => $this->category_model->get_all(),
            'visitor' => $this->visitor
        );
    }

    protected function display($tmpl, $value = array()) {
        $this->twig->display($tmpl, array_merge($this->display, $value));
    }
}

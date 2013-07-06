<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

/*
 * 骨架控制器
 *
 * 提供基本渲染功能和 session 记录管理功能
 */
class Skel extends CI_Controller {
    // 渲染数据
    protected $display;
    // 当前浏览用户
    protected $visitor;

    public function __construct() {
        parent::__construct();

        $this->setupsession();
        $this->prepare();
    }

    /*
     * 根据 GET 输入设置 session 信息
     */
    protected function setupsession() {
        $this->load->model('site_metas_model');

        // 设置校区 (c)
        $campus = $this->input->get('c', TRUE);
        if ($campus)
            $this->session->set_userdata(array(
                'campus' => $campus
            ));
    }

    protected function prepare() {
        $this->load->helper('campus');
        $this->load->model('category_model');

        // 获取所有校区信息
        $campus = get_all_campus();

        // 获取当前浏览用户信息
        $this->visitor = array(
            'campus' => $this->session->userdata('campus')
        );
        // 获取当前用户校区信息，默认为 大学城
        if (!$this->visitor['campus'] ||
            !in_array($this->visitor['campus'], $campus))
            $this->visitor['campus'] = default_campus();

        $this->display = array(
            'campus' => $campus,
            'visitor' => $this->visitor,
            // FIXME 减少重复的 categories 获取
            'categories' => $this->category_model->get_all()
        );
    }

    protected function display($tmpl, $value = array()) {
        // $value 具有更高的优先度
        $this->twig->display($tmpl, array_merge($this->display, $value));
    }
}

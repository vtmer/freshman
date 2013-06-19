<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

/*
 * Twig 渲染接口
 *
 * 调用 twig 渲染模板
 */
class Twig {
    private $CI;
    private $_twig;
    private $_template_dir;
    private $_cache_dir;

    function __construct($debug = false) {
        $this->CI =& get_instance();
        $this->CI->config->load('twig');

        require_once(VENDORPATH . 'autoload.php');

        log_message('debug', "Twig Autoloader Loaded");

        Twig_Autoloader::register();

        $this->_template_dir = $this->CI->config->item('template_dir');
        $this->_cache_dir = $this->CI->config->item('cache_dir');

        $loader = new Twig_Loader_Filesystem($this->_template_dir);

        $this->_twig = new Twig_Environment($loader, array(
            'cache' => $this->_cache_dir,
            'debug' => $debug,
        ));

        // 将所有已定义的函数添加到渲染域中
        foreach(get_defined_functions() as $functions) {
            foreach($functions as $function) {
                $this->_twig->addFunction($function,
                    new Twig_Function_Function($function));
            }
        }

        // 静态文件 url 生成函数
        $static_url = new Twig_SimpleFunction('static_url', function($file) {
            $CI =& get_instance();
            $base_url = $CI->config->item('base_url');
            $static = $CI->config->item('static_path');
            if (!$static)
                $static = '/static/';
            return $base_url . $static . $file;
        });
        $this->_twig->addFunction($static_url);

        // 站点 url 生成函数
        // FIXME site_url('abc' + obj.id) 时显示不正常
        $site_url = new Twig_SimpleFunction('site_url', function($path) {
            $CI = &get_instance();
            $CI->load->helper('url');
            return site_url($path);
        });
        $this->_twig->addFunction($site_url);
    }

    public function add_function($name) {
        $this->_twig->addFunction($name, new Twig_Function_Function($name));
    }

    public function render($template, $data = array()) {
        $template = $this->_twig->loadTemplate($template);
        return $template->render($data);
    }

    public function display($template, $data = array()) {
        $template = $this->_twig->loadTemplate($template);
        /* elapsed_time and memory_usage */
        $data['elapsed_time'] = $this->CI->benchmark->elapsed_time(
            'total_execution_time_start',
            'total_execution_time_end'
        );
        $memory = (!function_exists('memory_get_usage')) ? '0' :
            round(memory_get_usage()/1024/1024, 2) . 'MB';
        $data['memory_usage'] = $memory;
        $template->display($data);
    }
}

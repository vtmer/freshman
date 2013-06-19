<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/*
 * freshman
 *
 * 新生网
 *
 * @author     hbc
 */

/*
 * JSON response
 *
 * 生成 JSON 响应
 */
class Json_resp {
    private $CI;

    public function __construct($debug = false) {
        // 获取 CI 超类
        // 参考：http://codeigniter.org.cn/user_guide/general/creating_libraries.html
        $this->CI =& get_instance();
    }

    /*
     * 显示数据
     *
     * @param   object  $data 被 json 序列化的数据
     * @param   string  $status_code HTTP 响应头
     */
    public function display($data, $status_code = '200') {
        $this->CI->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }
}

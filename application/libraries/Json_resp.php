<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/*
 * JSON response
 *
 * 生成 JSON 响应
 */
class Json_resp {
    private $CI;

    public function __construct($debug = false) {
        $this->CI =& get_instance();
    }

    public function display($data, $status_code = '200') {
        $this->CI->output
            ->set_content_type('application/json')
            ->set_status_header($status_code)
            ->set_output(json_encode($data));
    }
}

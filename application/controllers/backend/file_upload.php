<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/*
 * freshman
 *
 * 新生网后台
 *
 * @author     hbc
 */

require_once 'auth.php';

/*
 * Upload 控制器
 *
 * 提供文件上传功能
 */
class File_upload extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    // /backend/file/upload
    //
    // 上传失败：返回错误信息
    // 上传成功：返回附件完整地址
    public function save() {
        $this->load->library('upload');
        $this->load->config('upload');

        if (!$this->upload->do_upload($this->config->item('field_name'))) {
            $this->json_resp->display(array(
                'error' => $this->upload->display_errors()
            ), 403);
            return;
        }

        $this->json_resp->display(array(
            'url' => $this->upload->data()['full_path']
        ));
    }
}

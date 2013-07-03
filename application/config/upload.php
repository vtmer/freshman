<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['upload'] = array(
    'upload_path' => STATICPATH . 'uploads',
    'allowed_types' => 'gif|jpg|png',
    'encrypt_name' => true,
    'field_name' => 'upload'
);

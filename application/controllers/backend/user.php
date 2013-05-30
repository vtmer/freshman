<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

class User extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('user_model', 'model');
        $this->load->helper('url');
    }

    private function is_login() {
        $token = $this->input->cookie('token');
        $username = $this->input->cookie('username');
        return $this->model->check_session($username, $token);
    }

    function login() {
        $display = array();

        /* get next destination */
        $next = $this->input->get('next') or '/';
        if ($this->is_login())
            redirect($next);

        /* build form */
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'username',
                'label' => 'Username:',
                'rules' => 'required|xss_clean'
            ),
            array(
                'field' => 'password',
                'label' => 'Password:',
                'rules' => 'required|xss_clean'
            )
        ));
        $display['form'] = form_open(
            site_url('backend/login') .'?next=' . $next
        );

        if ($this->form_validation->run()) {
            $payload = $this->input->post();
            if ($this->model->
                check_password($payload['username'], $payload['password'])) {       /* login successfully */
                $token = $this->model->generate_token($payload['username']);
                $this->input->set_cookie(array(
                    'name' => 'token',
                    'value' => $token,
                    'expire' => 365 * 24 * 3600,
                    'path' => '/'
                ));
                $this->input->set_cookie(array(
                    'name' => 'username',
                    'value' => $payload['username'],
                    'expire' => 365 * 24 * 3600,
                    'path' => '/'
                ));

                redirect($next);
                } else {                                                            /* login failed */
                    $display['error'] = 'Username or password incorrect!';
                }
        }
        $this->twig->display('backend/login.html', $display);
    }

    function logout() {
        $next = $this->input->get('next') or '/';
        if (!$this->is_login())
            redirect(site_url('/backend/login'));

        $token = $this->input->cookie('token');
        $username = $this->input->cookie('username');
        $this->model->destory_session($username, $token);
        $this->input->set_cookie(array(
            'name' => 'username',
            'expire' => -1
        ));
        $this->input->set_cookie(array(
            'name' => 'token',
            'expire' => -1
        ));

        redirect($next);
    }
}

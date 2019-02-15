<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('m_login');
    }

    public function index($info = null) {

        $info['titulo'] = "NetCar - Login";

//

        $this->load->view('header', $info);
        $this->load->view('v_login');
        $this->load->view('footer');
    }

    public function logar() {

        $idt = $this->input->post('idt');
        $senha = $this->input->post('senha');
        $acao = $this->input->post('acao');
        if (isset($acao) && $acao === 'logar') {
            if ((isset($idt) && !empty($idt)) && (isset($senha) && !empty($senha))) {
                $valida = $this->m_login->existeUsuario($idt, $senha);

                if ($valida) {
                    $dados = $this->m_login->getUsuario($idt, $senha);
                    $this->session->set_userdata('dados_usuario', $dados);
                    $this->session->set_userdata('logado', TRUE);
                    $this->showTemplate('v_inicio', $dados);
                } else {
                    $info['mensagem'] = "Usuário e/ou senha inválido";
                    $this->index($info);
                }
            } else {
                $info['mensagem'] = "Usuário e/ou senha inválido";
                $this->index($info);
            }
        } else {
            $info['mensagem'] = "Usuário e/ou senha inválido";
            $this->index($info);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('c_login');
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_Control extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        /**
         * redirige l'utilisateur vers sa page concerné tant qu'il ne s'est pas déconnecté
         */
        if ($this->session->userdata('admin')!=null) {
            redirect(base_url('admin_control'));
        }else if ($this->session->userdata('gestionnaire')!=null){
            redirect(base_url('gestionnaire_control'));
        }else if ($this->session->userdata('parents')!=null){
            redirect(base_url('parents_control'));
        }
    }

    public function index(){
        $this->template->load('layout', 'accueil');
    }
    
    public function jesuisperdu() {
        header("HTTP/1.1 404 Not Found");
        $this->template->load('layout', 'view_404');
    } 

}

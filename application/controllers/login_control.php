<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_Control extends CI_Controller {

    public function index() {
        redirect(base_url());
    }

    public function login() {

        //Récupérer les données saisies envoyées en POST
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //valide les données
        $this->form_validation->set_rules('email', '"email"', 'trim|required|valid_email|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('password', '"password"', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');

        $result = $this->user_model->userLogin($email,$password);
        

        if ($this->form_validation->run() == false) {//Si les données du formulaire ne sont pas valides
            $this->session->set_flashdata('message', 'Formulaire non valide');
        
           redirect(base_url());
        } else if ($this->form_validation->run() == true && empty($result)) {//Si il n'y a pas d'utilisateur possédant le mail dans la BD
            $this->session->set_flashdata('message', 'Aucun compte ne correspond à vos identifiants ');
          
           redirect(base_url());
        } else {//si tout est ok
            $this->session->set_userdata('id_user', $result[0]->id_responsable);

            if ($result[0]->admin == 1) {//si l'utilisateur est un admin
                $this->session->set_userdata('admin', 1);
                redirect(base_url("admin_control"));
            }

            if ($result[0]->gestionnaire == 1) {//si l'utilisateur est le gestionnaire
                $this->session->set_userdata('gestionnaire', 1);
                redirect(base_url('gestionnaire_control'));
            }
        }

        if ($result[0]->admin == 0 && $result[0]->gestionnaire == 0) {
            $this->session->set_userdata('parents', 1);
            redirect(base_url("parents_control"));
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
   

}

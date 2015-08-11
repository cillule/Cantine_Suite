<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gestionnaire_Control extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('gestionnaire'))) {
            redirect();
        }
        $this->template->set('page', 'gestionnaire');
    }

    public function index() {
        $data['query'] = $this->gestionnaire_model->get_enfant_gestionnaire(); //recupere nom prenom classe et id de l'enfant
        $this->template->load('layout', 'gestionnaire/index', $data);
    }

    public function affiche_tableau_suivi() {
        $this->template->load('layout', 'gestionnaire/suivi_inscrits');
    }

    public function pointage() {
        $id_enfant = $this->input->post('id_enfant');
        $this->form_validation->set_rules('id_enfant', '"id_enfant"', 'trim|numeric|required|encode_php_tags|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            $this->gestionnaire_model->insert_enfant_gestionnaire($id_enfant);
        }
    }

    public function recherche() {
        $data = $this->gestionnaire_model->get_enfant();
        $data_json = array();
        foreach ($data->result() as $row) {
            array_push($data_json, "$row->nom" . " $row->prenom");
        }
        echo json_encode($data_json);
    }

    public function ajouter_enfant() {
        $recherche = $this->input->post('recherche');
        $tmp = explode(" ", $recherche);
        $prenom_enfant = $tmp[1];
        $nom_enfant = $tmp[0];
        $this->form_validation->set_rules('recherche', '"recherche"', 'trim|required|encode_php_tags|xss_clean');
        if ($this->form_validation->run() == TRUE) {
            if ($this->gestionnaire_model->insert_enfant_non_inscrit($nom_enfant, $prenom_enfant) == false) {
                $this->session->set_flashdata('message', "Erreur lors de l'ajout de l'enfant!");
            } else {
                $this->session->set_flashdata('message', "Enfant ajouté avec succès!");
            }
        } else {
            $this->session->set_flashdata('message', "Erreur lors de l'ajout de l'enfant!");
        }
        redirect(base_url('gestionnaire_control'));
    }

    public function generer_tableau_suivi() {

        $date = $this->input->post('date_suivi_inscrit');
        $tmp = explode("/", $date);
        $mois = $tmp[0];
        $annee = $tmp[1];
        $this->excel_model->export_tableau_suivi($mois, $annee);
    }

    public function generer_feuille_presence() {
        $date = $this->input->post("date_suivi_presence");

        $tmp = explode("/", $date);
        $jour = $tmp[0];
        $mois = $tmp[1];
        $annee = $tmp[2];
        $this->excel_model->export_feuille_presence($annee . "-" . $mois . "-" . $jour);
    }

    public function reglages() {

        $this->template->load('layout', 'gestionnaire/reglages_gestionnaire');
    }

    public function sauvegarder_mdp() {

        $this->form_validation->set_rules('password_1', 'Password', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required|matches[password_2]');
        $this->form_validation->set_rules('password_2', 'Password Confirmation', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required|matches[password_1]');

        if ($this->form_validation->run() == TRUE) {
            $new_mdp = $this->input->post('password_1');
            $this->gestionnaire_model->enregistrer_nouveau_mdp($new_mdp);
            $this->session->set_flashdata('message', 'Changement de mot de passe réussi');
            redirect(base_url('gestionnaire_control/reglages'));
        } else {
            $this->form_validation->set_message('matches[password_1]');
            $this->reglages();
        }
    }

}

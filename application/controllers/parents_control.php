<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parents_Control extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (empty($this->session->userdata('parents'))) {
            redirect();
        }

        $id_famille = $this->parents_model->get_id_famille();
        $this->session->set_userdata('id_famille', $id_famille);
        $this->template->set('page', 'parent');
    }

    public function index() {
        $this->info_parents();
    }

    public function info_parents() {
        $data['query'] = $this->parents_model->recuperer_info_parents();
        $this->template->load('layout', 'parents/info_parents', $data);
    }

    public function sauvegarder_infos_famille() {

        $this->form_validation->set_rules('demail', 'Email', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dmobile', 'trim|required|min_length[10]|max_length[10]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dtel_travail', 'trim|required|min_length[10]|max_length[10]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('daddress', 'trim|required|min_length[5]|max_length[150]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dville', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');



        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'adresse' => $this->input->post('daddress'),
                'mail' => $this->input->post('demail'),
                'tel_mobile' => $this->input->post('dmobile'),
                'tel_travail' => $this->input->post('dtel_travail'),
                'ville' => $this->input->post('dville'),
            );

            $this->parents_model->form_parents($data); //sauvegarde les infos dans la base
            $this->session->set_flashdata('message', 'Modification effectuée avec succès!');
            redirect(base_url("parents_control/info_parents"));
        }
    }

    public function changer_mdp() {

        $this->form_validation->set_rules('password_1', 'Password', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required');
        $this->form_validation->set_rules('password_2', 'Password Confirmation', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required|matches[password_1]');


        if ($this->form_validation->run() == TRUE) {

            $new_mdp = $this->input->post('password_2');
            $this->parents_model->enregitrer_nouveau_mdp($new_mdp);
            $this->session->set_flashdata('message', 'Changement de mot de passe réussi');
            redirect(base_url("parents_control/info_parents"));
        } else {
            $this->form_validation->set_message('matches[password_1]');
            $this->info_parents();
        }
    }

    public function affiche_enfants() {

        $data['query'] = $this->parents_model->get_enfants();
        $data['affiche_calendrier'] = 0;
        $this->template->load('layout', 'parents/affiche_enfants', $data);
    }

    //redirige vers le formulaire ajout d'un enfant
    function ajouter_enfants() {

        $data["liste_classe"] = $this->parents_model->get_liste_classes();
        $this->template->load('layout', 'parents/add_enfant_parents', $data);
    }

    //redirige vers le formulaire ajout d'un enfant
    function sauvegarder_enfant() {

        //recupération des données du POST 
        $nom = $this->input->post('nom');
        $prenom = $this->input->post('prenom');
        $classe = $this->input->post('select_classe');
        $regime_alimentaire = $this->input->post('select_regime');
        $allergie = $this->input->post('allergie');
        $inscription = $this->input->post('select_abonnement');

        $this->form_validation->set_rules('nom', '"nom"', 'trim|required|min_length[2]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('prenom', '"prenom"', 'trim|required|min_length[2]|max_length[52]|encode_php_tags|xss_clean');
        //$this->form_validation->set_rules('select_classe', '"select_classe"', 'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('allergie', '"allergie"', 'trim|max_length[250]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('select_regime', '"select_regime"', 'trim|required|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('select_abonnement', '"select_abonnement"', 'trim|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $this->parents_model->add_enfant($nom, $prenom, $classe, $regime_alimentaire, $allergie, $inscription);
            $this->session->set_flashdata('message', 'Ajout effectué avec succès! ');
            redirect(base_url("parents_control/affiche_enfants"));
        } else {
            $this->session->set_flashdata('message', "Le formulaire n'a pas été remplis correctement! ");
            redirect(base_url("parents_control/ajouter_enfants"));
        }
    }

    //redirige vers un formaulaire permettant de changer les information concernant l'enfant dont l'id est en paramètre
    public function modifier_informations_enfant($id_enfant = '') {
        if ($this->parents_model->is_enfant_from_famille($id_enfant) == true) {
            $data["infos_enfant"] = $this->parents_model->get_enfant($id_enfant);
            $data["liste_classe"] = $this->parents_model->get_liste_classes();
            $this->template->load('layout', 'parents/edit_enfant_parents', $data);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function sauvegarder_infos_enfant() {
        $this->form_validation->set_rules('id_enfant', 'trim|required|min_length[2]|max_length[29]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('id_famille', 'trim|required|min_length[2]|max_length[29]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('nom_enfant', 'trim|required|min_length[2]|max_length[29]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('prenom_enfant', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('classe_enfant', 'trim||min_length[10]|max_length[10]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('select_regime', 'trim|min_length[10]|max_length[50]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('allergie', 'trim|min_length[5]|max_length[200]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $id_enfant = $this->input->post("id_enfant");


            $data = array(
                'nom' => $this->input->post('nom_enfant'),
                'prenom' => $this->input->post('prenom_enfant'),
                'classe' => $this->input->post('classe_enfant'),
                'regime_alimentaire' => $this->input->post('select_regime'),
                'allergie' => $this->input->post('allergie')
            );


            if ($this->parents_model->is_enfant_from_famille($id_enfant) == true) {
                $this->parents_model->set_enfant($data, $id_enfant);
                $this->session->set_flashdata('message', 'Modification effectuée avec succès!');
                $this->affiche_enfants();
            } else {
                $this->session->set_flashdata('message', 'La modification a echoué');
                $this->template->load('layout', 'view_404');
            }
        }
    }

    // Fonction pour afficher le calendrier
    public function afficher_Calendrier_Inscriptions($id_enfant = '') {

        if ($this->parents_model->is_enfant_from_famille($id_enfant) == true) {
            $dates = $this->calendrier_model->get_MoisSuivants($id_enfant, 3);

            $data['query'] = $this->parents_model->get_enfants();
            $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
            $months = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
            $data["id_enfant"] = $id_enfant;
            $data["elem_calendrier"]["dates"] = $dates;

            $data["elem_calendrier"]["jours"] = $days;
            $data["elem_calendrier"]["mois"] = $months;
            $data['affiche_calendrier'] = 1;
            $this->template->load('layout', 'parents/affiche_enfants', $data);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    //pour enregistrer les modifications d'inscriptions en provenance du calendrier
    public function enregistrerInscriptionsRepas($id_enfant = '') {

        if ($this->parents_model->is_enfant_from_famille($id_enfant) == true) {

            $liste_date_serialise = $this->input->post('checkbox');
            $liste_date_serialise_HD = $this->input->post('checkbox_HD');
            $liste_date_deserialisee = array();

            foreach ($liste_date_serialise as $date) {

                array_push($liste_date_deserialisee, unserialize($date));
            }

            foreach ($liste_date_serialise_HD as $date) {

                array_push($liste_date_deserialisee, unserialize($date));
            }

            $this->parents_model->setInscriptions($liste_date_deserialisee, $id_enfant);
            $this->session->set_flashdata('message', "Les changements ont bien été enregistrés");
            $this->afficher_Calendrier_Inscriptions($id_enfant);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    public function affiche_factures() {

        $data['infos_factures'] = $this->parents_model->get_facturation();
        $this->template->load('layout', 'parents/affiche_facturation', $data);
    }

    public function export_facture_PDF($id_facture) {
        if ($this->parents_model->is_facture_from_famille($id_facture) == true) {
            $this->pdf_model->export_facture($id_facture);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    public function contact() {
        $this->template->load('layout', 'parents/contact');
    }

    public function message() {
        $data['liste_messages'] = $this->parents_model->get_message();
        $this->template->load('layout', 'parents/message_parents', $data);
    }

    function supprimer_message($id_message) {
        $this->parents_model->delete_message($id_message);
        $this->session->set_flashdata('message', 'Suppression effectuée avec succès ');
        redirect(base_url("parents_control/message"));
    }

    public function envoi_message() {
        $Intitule = $this->input->post('Intitule');
        $Contenu = $this->input->post('Contenu');
       

        $this->form_validation->set_rules('Intitule', 'trim|required|min_length[2]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('Contenu', 'trim|max_length[350]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $this->parents_model->insertMessage($Intitule, $Contenu);
            $this->session->set_flashdata('message', 'Message envoyé avec succés!');
            redirect(base_url("parents_control/message"));
        } else {
            $this->session->set_flashdata('message', 'Erreur lors de la validation du formulaire!');
            redirect(base_url("parents_control/message"));
        }
    }

    function affiche_documents() {
        $data['liste_tarif'] = $this->parents_model->recuperer_tarifs();
        $data['query2'] = $this->parents_model->get_document();
        $this->template->load('layout', 'parents/documents_parents', $data);
    }

    function telecharger_document($nom_doc) {
        $this->load->helper('download');
        $file_name = "./assets/documents/$nom_doc";
        $data = file_get_contents($file_name);
        force_download($nom_doc, $data);
    }

    function affiche_faq() {
        $data['query'] = $this->parents_model->recuperer_QR();
        $this->template->load('layout', 'parents/faq_parents', $data);
    }

}

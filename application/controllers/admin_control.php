<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//Cette classe gère toutes les actions qui peuvent être déclanchée par le module 
class Admin_Control extends CI_Controller {

    public function __construct() {
        parent::__construct();

        /**
         * Réserve l'accès à ces pages à l'admin
         */
        if (empty($this->session->userdata('admin'))) {
            redirect();
            exit();
        }

        $config['upload_path'] = './assets/documents';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $this->load->library('upload', $config);
        $this->template->set('page', 'admin');
    }

    //afficher les familles pour la première page
    function index() {
        $data['query'] = $this->admin_model->get_familles();
        $data['affiche_tuille'] = 0;
        $this->template->load('layout', 'admin/famille', $data);
    }

    //afficher les tuiles correspondant à la famille
    function afficher_tuille_info($id_famille = '') {
        if ($this->admin_model->is_famille($id_famille) == true) {
            $data['query'] = $this->admin_model->get_familles();
            $data['infos_famille'] = $this->admin_model->get_info_famille($id_famille);
            $data['affiche_tuille'] = 1;
            $this->template->load('layout', 'admin/famille', $data);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function edit_famille() {

        $id_famille = $this->input->post("id_famille"); //on recupère l'id de la famille en post
        $data['infos_famille'] = $this->admin_model->get_info_famille($id_famille);

        if ($this->admin_model->is_famille($id_famille) == true) {
            $this->template->load('layout', 'admin/edit_famille', $data);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function changement_mdp_famille() {

        $this->form_validation->set_rules('id_famille', 'trim|required|encode_php_tags|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $id_famille = $this->input->post("id_famille"); //on recupère l'id de la famille en post

            if ($this->admin_model->is_famille($id_famille) == true) {
                $this->admin_model->set_mdp_famille($id_famille);
            } else {
                $this->template->load('layout', 'view_404');
            }
        } else {
            
        }
    }

    function enregistrer_infos_responsable() {

        $this->form_validation->set_rules('dnom', 'Email', 'trim|required|min_length[2]|max_length[29]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dprenom', 'trim|required|min_length[2]|max_length[29]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('demail', 'Email', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dmobile', 'trim||min_length[10]|max_length[10]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dtel_travail', 'trim|min_length[10]|max_length[10]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('daddress', 'trim|min_length[5]|max_length[150]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('dville', 'trim|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('did_famille', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('did_resp', 'trim|required|min_length[5]|max_length[52]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {

            $data = array(
                'nom' => $this->input->post('dnom'),
                'prenom' => $this->input->post('dprenom'),
                'adresse' => $this->input->post('daddress'),
                'mail' => $this->input->post('demail'),
                'adresse' => $this->input->post('daddress'),
                'mail' => $this->input->post('demail'),
                'tel_mobile' => $this->input->post('dmobile'),
                'tel_travail' => $this->input->post('dtel_travail'),
                'ville' => $this->input->post('dville'),
            );

            $id_famille = $this->input->post("did_famille");
            $id_resp = $this->input->post("did_resp");

            if ($this->admin_model->is_famille($id_famille)) {
                $this->admin_model->set_infos_responsable($data, $id_resp); //sauvegarde les infos dans la base
                $this->session->set_flashdata('message', 'Modification effectuée avec succès!');
                $this->afficher_tuille_info($id_famille);
            } else {
                $this->session->set_flashdata('message', 'La modification a echoué');
                $this->template->load('layout', 'view_404');
            }
        }
    }

    function modifier_info_enfant($id_enfant = '') {
        if ($this->admin_model->is_enfant($id_enfant) == true) {

            $data["infos_enfant"] = $this->admin_model->get_infos_enfant($id_enfant);
            $data["liste_classe"] = $this->admin_model->get_liste_classes();
            $this->template->load('layout', 'admin/edit_enfant_admin', $data);
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
            $id_famille = $this->input->post('id_famille');

            $data = array(
                'nom' => $this->input->post('nom_enfant'),
                'prenom' => $this->input->post('prenom_enfant'),
                'classe' => $this->input->post('classe_enfant'),
                'regime_alimentaire' => $this->input->post('select_regime'),
                'allergie' => $this->input->post('allergie')
            );


            if ($this->admin_model->is_enfant($id_enfant) == true) {
                $this->admin_model->set_infos_enfant($data, $id_enfant);
                $this->session->set_flashdata('message', 'Modification effectuée avec succès!');
                $this->afficher_tuille_info($id_famille);
            } else {
                $this->session->set_flashdata('message', 'La modification a echoué');
                $this->template->load('layout', 'view_404');
            }
        }
    }

    function supprimer_enfant($id_enfant = '') {

        if ($this->admin_model->is_enfant($id_enfant) == true) {
            $this->admin_model->delete_enfant($id_enfant);
            $this->session->set_flashdata('message', 'Suppression effectuée avec succès ');
            redirect(base_url("admin_control"));
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function affiche_facturation() {

        $data['query'] = $this->admin_model->get_familles();
        $data['affiche_tuille'] = 0;
        $this->template->load('layout', 'admin/facturation', $data);
    }

    function affiche_facturation_info($id_famille = "") {
        $data['infos_famille'] = array();
        $data['query'] = $this->admin_model->get_familles();

        if (empty($id_famille)) {//si l'id de la famille n'est pas en paramètre dans l'url
            $id_famille = $this->input->post("select_famille"); //on recupère l'id de la famille en post
        }
        if ($this->admin_model->is_famille($id_famille) == true) {
            $data['infos_famille'] = $this->admin_model->get_facturation_famille($id_famille);
            $data['id_famille'] = $id_famille;
            $data['affiche_tuille'] = 1;

            $this->template->load('layout', 'admin/facturation', $data);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function reglages() {

        $data["vacances"] = $this->admin_model->get_vacances_scolaires();
        $data["classes"] = $this->admin_model->get_liste_classes();
        $this->template->load('layout', 'admin/reglages_admin', $data);
    }

    function sauvegarder_vacances_scolaires() {

        $dates = array();

        $dates["1"]["debut"] = $this->input->post("debut_toussaint");
        $dates["1"]["fin"] = $this->input->post("fin_toussaint");
        $dates["2"]["debut"] = $this->input->post("debut_noel");
        $dates["2"]["fin"] = $this->input->post("fin_noel");
        $dates["3"]["debut"] = $this->input->post("debut_hiver");
        $dates["3"]["fin"] = $this->input->post("fin_hiver");
        $dates["4"]["debut"] = $this->input->post("debut_printemps");
        $dates["4"]["fin"] = $this->input->post("fin_printemps");
        $dates["5"]["debut"] = $this->input->post("debut_ete");
        $dates["5"]["fin"] = $this->input->post("fin_ete");

        $this->admin_model->sauvegarder_vacances_scolaires($dates);
        redirect(base_url("admin_control/reglages"));
    }

    public function enregistrer_classe() {

        $this->form_validation->set_rules('InputNomEnseignant', 'trim|required|min_length[5]|max_length[50]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('InputNiveau', 'trim|required|min_length[5]|max_length[50]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $nom_enseignant = $this->input->post('InputNomEnseignant');
            $niveau = $this->input->post('InputNiveau');
            $id_classe = $this->input->post('IdClasse');

            $this->admin_model->enregistrer_classe($nom_enseignant, $niveau, $id_classe);

            $this->session->set_flashdata('message', 'Enregistrement Réussi');
            redirect(base_url("admin_control/reglages"));
        } else {
            $this->session->set_flashdata('message', 'Tout les champs requis ne sont pas renseignés');
            redirect(base_url("admin_control/reglages"));
        }
    }

    public function editer_classe($id_classe) {
        $data["classe"] = $this->admin_model->get_classe_id($id_classe);
        $this->template->load('layout', 'admin/edit_classe', $data);
    }

    public function supprimer_classe($id_classe) {

        if ($this->admin_model->is_classe($id_classe) && $this->admin_model->is_empty_classe($id_classe)) {
            $this->admin_model->supprimer_classe($id_classe);
            $this->session->set_flashdata('message', 'Suppression effectuée');
            redirect(base_url("admin_control/reglages"));
        } else {
            $this->session->set_flashdata('message', 'Impossible de supprimer la classe: des enfants y sont encore rattachés');
            redirect(base_url("admin_control/reglages"));
        }
    }

    public function changer_mdp() {

        $this->form_validation->set_rules('password_1', 'Password', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required|matches[password_2]');
        $this->form_validation->set_rules('password_2', 'Password Confirmation', 'trim|min_length[8]|max_length[16]|encode_php_tags|xss_clean|required|matches[password_1]');

        if ($this->form_validation->run() == TRUE) {
            $new_mdp = $this->input->post('password_1');
            $this->admin_model->enregitrer_nouveau_mdp($new_mdp);
            $this->session->set_flashdata('message', 'Changement de mot de passe réussi');
            redirect(base_url("admin_control/reglages"));
        } else {
            $this->session->set_flashdata('error', 'Les deux champs ne correspondent pas');
            redirect(base_url("admin_control/reglages"));
        }
    }

    //supprimer une famille
    function supprimer_famille($id_famille = '') {
        if ($this->admin_model->is_famille($id_famille) == true) {
            $this->admin_model->delete_famille($id_famille); //Admin_model->on supprime la famille
            $this->session->set_flashdata('message', 'La famille a bien été supprimée');
            redirect(base_url("admin_control"));
        } else {
            redirect(base_url("admin_control"));
        }
    }

    //redirige vers le formulaire ajout d'une famille
    function ajouter_famille() {
        $this->template->load('layout', 'admin/ajouter_famille');
    }

    //redirige vers le formulaire ajout d'une famille
    function sauvegarder_famille() {

        //recupération des données du POST 
        $nom = strtoupper($this->input->post('nom'));
        $prenom = $this->input->post('prenom');
        $mail = $this->input->post('mail');

        $this->form_validation->set_rules('nom', '"nom"', 'trim|required|min_length[3]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('prenom', '"prenom"', 'trim|required|min_length[3]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('mail', '"mail"', 'trim|required|valid_email|is_unique[responsable.mail]|min_length[5]|max_length[52]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == true) {
            $this->admin_model->add_famille($nom, $mail, $prenom);
            $this->session->set_flashdata('message', "Famille ajoutée avec succès!");
        } else {
            $this->session->set_flashdata('error', "Echec lors de l'ajout de la famille. <br/>   Vérifiez que l'adresse mail n'est pas déja utilisée");
        }
        redirect(base_url("admin_control"));
    }

    //affiche la page suivi des inscrits
    function suivi_inscrits() {
        $this->template->load('layout', 'admin/suivi_inscrits');
    }

    //permet de générer les factures (voir pour planifier la tache)
    public function generer_factures() {

        $this->admin_model->generer_factures();
        $this->affiche_facturation();
    }

    //permet d'exporter la facture au format PDF
    public function export_facture_PDF($id_facture) {
        $this->pdf_model->export_facture($id_facture);
    }

    public function generer_feuille_presence() {
        $date = $this->input->post("date_suivi_presence");

        $tmp = explode("/", $date);
        $jour = $tmp[0];
        $mois = $tmp[1];
        $annee = $tmp[2];
        $this->excel_model->export_feuille_presence($annee . "-" . $mois . "-" . $jour);
    }

    public function generer_tableau_suivi() {

        $date = $this->input->post('date_suivi_inscrit');
        $tmp = explode("/", $date);
        $mois = $tmp[0];
        $annee = $tmp[1];
        $this->excel_model->export_tableau_suivi($mois, $annee);
    }

    public function facture_reglee($id_famille, $id_facture) {
        if ($this->admin_model->is_famille($id_famille) == true && $this->admin_model->is_facture($id_facture) == true) {
            $this->admin_model->set_facture_reglee($id_facture);
            $this->affiche_facturation_info($id_famille);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    public function generer_recapitulatif() {

        $date = $this->input->post('date_suivi_inscrit');
        $tmp = explode("/", $date);
        $mois = $tmp[0];
        $annee = $tmp[1];
        $this->admin_model->export_recapitulatif($mois, $annee);
    }

    public function generer_echeancier() {

        $date = $this->input->post('date_echeancier');
        $tmp = explode("/", $date);
        $mois = $tmp[0];
        $annee = $tmp[1];

        $this->excel_model->export_echeancier($mois, $annee);
    }

    function message() {
        $data['query'] = $this->admin_model->get_id_famille();
        $data['message'] = $this->admin_model->get_message();
        $this->template->load('layout', 'admin/message', $data);
    }

    function supprimer_message($id_message) {
        $this->admin_model->delete_message($id_message);
        $this->session->set_flashdata('message', 'Suppression effectuée avec succès ');
        redirect(base_url("admin_control/message"));
    }

    function envoi_message() {
        $Intitule = $this->input->post('Intitule');
        $Contenu = $this->input->post('Contenu');
        $idfamille = $this->input->post('familleselect');

        $this->form_validation->set_rules('Intitule', '"Intitule"', 'trim|required|min_length[2]|max_length[52]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('Contenu', '"Contenu"', 'trim|required|max_length[350]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('familleselect', 'trim|min_length[1]|alpha|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == true) {
            foreach ($idfamille as $r) {//insertion
                $this->admin_model->insertMessage($r, $Intitule, $Contenu); // L'insert se passe ici
            }
            $this->session->set_flashdata('message', 'Message envoyé avec succés!');
        } else {
            $this->session->set_flashdata('message', 'Erreur lors de la validation du formulaire!');
        }
        redirect(base_url('admin_control/message'));
    }

    function affiche_documents() {
        $data['liste_tarif'] = $this->admin_model->recuperer_tarifs();
        $data['query2'] = $this->admin_model->get_document();
        $this->template->load('layout', 'admin/documents', $data);
    }

    function ajouter_document() {
        if ($this->upload->do_upload('fichier') == FALSE) {
            $this->session->set_flashdata('message', "Echec lors de l'import du document!");
        } else {
            $this->admin_model->load_document();
            $this->session->set_flashdata('message', 'Import réalisé avec succès!');
        }
        redirect(base_url("admin_control/affiche_documents"));
    }

    function supprimer_document($id_document) {
        $this->admin_model->delete_document($id_document); //Admin_model->on supprime la famille
        $this->session->set_flashdata('message', 'Suppression réalisé avec succès!');
        redirect(base_url("admin_control/affiche_documents"));
    }

    function sauvegarder_tarifs() {

        $prixAetM = $this->input->post('prixAetM');
        $prixHebdo = $this->input->post('prixHebdo');
        $prixHD = $this->input->post('prixHD');
        $prixPasInscrit = $this->input->post('prixPasInscrit');

        $this->form_validation->set_rules('$prixAetM', 'trim|numeric|required|min_length[1]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('$prixHebdo', 'trim|numeric|required|min_length[1]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('$prixHD', 'trim|numeric|required|min_length[1]|encode_php_tags|xss_clean');
        $this->form_validation->set_rules('$prixPasInscrit', 'trim|numeric|required|min_length[1]|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == true) {
            $data = array(
                'prixAetM' => $prixAetM,
                'prixHebdo' => $prixHebdo,
                'prixHD' => $prixHD,
                'prixPasIns' => $prixPasInscrit,
            );
            $this->admin_model->form_tarifs($data); //sauvegarde les infos dans la base
            $this->session->set_flashdata('message', 'Tarifs modifiés avec succès!');
        } else {
            $this->session->set_flashdata('message', 'Erreur lors de la modification des tarifs!');
        }
        redirect(base_url("admin_control/affiche_documents"));
    }

    function modifer_facturation($id_enfant = '') {

        if ($this->admin_model->is_enfant($id_enfant) == true) {
            $liste_date_serialise = $this->input->post('checkbox');
            $type = $this->input->post('traitement_facture');
            $liste_date_deserialisee = array();

            foreach ($liste_date_serialise as $date) {
                $date_deserialisee = unserialize($date);
                array_push($liste_date_deserialisee, $date_deserialisee["date"]);
            }

            $this->admin_model->set_facturation_repas($id_enfant, $liste_date_deserialisee, $type);
            $id_famille = $this->admin_model->get_famille_by_enfant($id_enfant);

            $this->affiche_facturation_info($id_famille->id_famille);
        } else {
            $this->template->load('layout', 'view_404');
        }
    }

    function affiche_edit_facturation($id_enfant = '') {
        $id_famille = $this->input->post("id_famille"); //on recupère l'id de la famille en post
        $infos_famille = $this->admin_model->get_facturation_famille($id_famille);
        foreach ($infos_famille as $key => $row) {
            if ($key == $id_enfant) {

                $data["info_enfant"] = $row;
            }
        }

        $data["info_enfant"]["id_famille"] = $id_famille;
        $this->template->load('layout', 'admin/edit_facturation', $data);
    }

    function affiche_liste_factures() {

        $data["liste_factures"] = $this->admin_model->get_liste_factures();
        $this->template->load('layout', 'admin/liste_factures', $data);
    }

    public function change_etat_facture() {

        $id_facture = $this->input->post('id_facture');
        $this->form_validation->set_rules('id_facture', '"id_enfant"', 'trim|numeric|required|encode_php_tags|xss_clean');

        if ($this->form_validation->run() == TRUE) {
            $this->admin_model->set_etat_facture($id_facture);
        }
    }

}

<?php

class Admin_model extends CI_Model {

    protected $table_responsable = 'responsable';

    public function get_familles() {
        $this->db->select('famille.id_famille, famille.nom_famille, id_resp_1, count(id_enfant) as nb_enfants')
                ->from('famille')
                ->join('enfant', 'famille.id_famille = enfant.id_famille', 'left')
                ->group_by('famille.id_famille')
                ->order_by('nom_famille');

        $query = $this->db->get();
        return $query;
    }

    //get_info_famille: Recupérer les informations utiles lors de l'affichage
    public function get_info_famille($id_famille) {

        $this->db->select('id_resp_1')
                ->from('famille')
                ->where('id_famille', $id_famille);

        $row = $this->db->get()->result();

        $id_resp1 = $row[0]->id_resp_1;

        $this->db->select('id_responsable, nom, prenom, adresse, tel_mobile, tel_travail, mail, ville, id_famille, nom_famille')
                ->from('responsable')
                ->where('id_responsable', $id_resp1)
                ->join('famille', "famille.id_resp_1=responsable.id_responsable");

        $result["resp_1"] = $this->db->get()->result();

        $this->db->select('id_enfant, nom, prenom, niveau, nom_enseignant, regime_alimentaire, allergie, type_inscription')
                ->from('enfant')
                ->where('id_famille', $id_famille)
                ->join('classe', "enfant.classe=classe.id_classe", "left");

        $result["enfants"] = $this->db->get()->result();

        return $result;
    }

    public function set_infos_responsable($data, $id_responsable) {

        $this->db->where('id_responsable', $id_responsable);
        $this->db->update('responsable', $data);
    }

    // delete_famille: détruire les données reliée à l'id_famille passé en paramètre dans le base Cantine
    public function delete_famille($id_famille) {

        //on récupère l'id des responsables de la famille
        $this->db->select('id_resp_1')
                ->from('famille')
                ->where('id_famille', $id_famille);

        $row = $this->db->get()->result();

        $id_resp1 = $row[0]->id_resp_1;

        $this->db->delete('responsable', array('id_responsable' => $id_resp1));

        $this->db->delete('famille', array('id_famille' => $id_famille)); //on supprime les entrées correspondantes dans la table famille

        $this->db->delete('enfant', array('id_famille' => $id_famille)); //on supprime les enfants correspondants dans la table enfants
    }

    // add_famille: Ajouter une famille
    public function add_famille($nom, $mail, $prenom) {

        //on récupère deux id pour les responsables
        $this->db->select('max(id_responsable) as id_max')
                ->from('responsable');

        $row = $this->db->get()->result();
        $id_resp_1 = ($row[0]->id_max) + 1; //pour le responsable 1
        //on prépare les données à inserer dans la table famille
        $to_insert = array(
            'id_famille' => "",
            'nom_famille' => $nom,
            'id_resp_1' => $id_resp_1,
        );

        $this->db->insert('famille', $to_insert); //et on les insert
        //on genère un mdp au hasard et on le crypte
        $mdp_non_crypte = $this->generer_mot_de_passe();
        $mdp = password_hash($mdp_non_crypte, PASSWORD_BCRYPT);


        //On prépare les données à insérer pour le responsable 1
        $insert_resp_1 = array(
            'id_responsable' => $id_resp_1,
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'mdp' => $mdp,
        );

        //On les ajoute à la base
        $this->db->insert('responsable', $insert_resp_1);
        //et on envoie le mail
        $this->mail_ajout_famille($mail, $mdp_non_crypte);
    }

    private function mail_ajout_famille($mail, $mdp) {

        $this->load->library('email');

        $this->email->from('admin@cantine-treffort.fr', 'Cantine');
        $this->email->to($mail);

        $this->email->subject('Inscription Cantine');
        $this->email->message("Bonjour, \nVoici votre identifiant: " . $mail . " \nVoici votre mot de passe: " . $mdp);

        $this->email->send();
    }

    public function set_infos_enfant($liste_infos, $id_enfant) {
        $this->db->where('id_enfant', $id_enfant);
        $this->db->update('enfant', $liste_infos);
    }

    // delete_enfant: détruire les données reliée à l'id_enfant passé en paramètre dans le base Cantine
    public function delete_enfant($id_enfant) {

        $this->db->delete('enfant', array('id_enfant' => $id_enfant)); //on supprime les enfants correspondants dans la table enfants
        $this->db->delete('repas', array('id_enfant_repas' => $id_enfant));
        $this->db->delete('facture', array('id_enfant' => $id_enfant));
        $this->db->delete('facture', array('id_enfant' => $id_enfant));
        $this->db->delete('schema_inscription_annuelle', array('schem_id_enfant' => $id_enfant));
    }

    public function is_enfant($id_enfant) {

        $this->db->select('*')
                ->from('enfant')
                ->where('id_enfant', $id_enfant);

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function is_famille($id_famille) {

        //on vérifie que l'id passé en paramètre est dans la base
        $this->db->select('*')
                ->from('famille')
                ->where('id_famille', $id_famille);

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function is_facture($id_facture) {

        //on vérifie qu'une facture corespondant à l'id passé en paramètres se trouve dans la base
        $this->db->select('*')
                ->from('facture')
                ->where('id_facture', $id_facture);

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function enregitrer_nouveau_mdp($new_mdp) {

        $mdp = password_hash($new_mdp, PASSWORD_BCRYPT);

        $this->db->query("UPDATE responsable set mdp='$mdp' where id_responsable = 1");
    }

    public function get_facturation_famille($id_famille) {

        $this->db->select('id_enfant, prenom, nom, classe, type_inscription')
                ->from('enfant')
                ->where('id_famille', $id_famille);

        $row = $this->db->get()->result();

        $to_return = array();
        if (!empty($row)) {

            foreach ($row as $it) {

                $array1 = Array(
                    "id_enfant" => $it->id_enfant,
                    "prenom" => $it->prenom,
                    "nom" => $it->nom,
                    "classe" => $it->classe,
                    "type_inscription" => $it->type_inscription,
                );

                $to_return[$it->id_enfant]["info_enfant"] = $array1;
                $to_return[$it->id_enfant]["factures_associées"] = $this->get_factures_enfant($it->id_enfant);
                $to_return[$it->id_enfant]["calendrier_inscrip"] = $this->get_liste_inscriptions($it->id_enfant);
            }
        }

        return $to_return;
    }

    public function generer_factures() {
        $datecourante = new DateTime;
        $moiscourant = $datecourante->format('n');
        $anneecourante = $datecourante->format('Y');

        if ($this->facture_mois_existante() == true) {//si la facturation a déja été lancée
            //on supprime les factures existantes
            $this->db->delete('facture', array("année" => $anneecourante, "mois" => $moiscourant));
        }
        
        $where="YEAR(date)=".$anneecourante." AND MONTH(date)=".$moiscourant." AND  DATE_FORMAT( date, '%Y-%m-%d' ) <= '".$datecourante->format('Y-m-d')."'";
        $this->db->select('YEAR(date) as annee, MONTH(date) as mois, id_enfant_repas as id_enfant, sum(prix) as montant ')
                ->from('repas')
                ->where($where)
                ->group_by( "id_enfant");
        $listes_factures = $this->db->get()->result();

        foreach ($listes_factures as $it) {

            $to_insert = array(
                "montant" => $it->montant,
                "mois" => $it->mois,
                "année" => $it->annee,
                "id_enfant" => $it->id_enfant,
                "date_crea"=> $datecourante->format('Y-m-d')
            );

            $this->db->insert("facture", $to_insert);
        }
    }

    private function facture_mois_existante() {

        $datecourante = new DateTime;
        $moiscourant = $datecourante->format('n');
        $anneecourante = $datecourante->format('Y');

        $this->db->select('* ')
                ->from('facture')
                ->where(array("année" => $anneecourante, "mois" => $moiscourant));

        $result = $this->db->get()->result();

        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    private function get_factures_enfant($id_enfant) {

        //a utiliser pour tache planifiée -> -> -> $this->db->select('YEAR(date) as annee, MONTH(date) as mois, sum(prix) as somme ')->from('repas')->where('id_enfant', $id_enfant)->group_by(array("YEAR(date)", "MONTH(date)"));

        $this->db->select('* ')->from('facture')->where('id_enfant', $id_enfant);

        $to_return = $this->db->get()->result();

        return $to_return;
    }

    public function set_facture_reglee($id_facture) {

        $data = array(
            'reglee' => 1,
        );
        $this->db->where('id_facture', $id_facture);
        $this->db->update('facture', $data);
    }

    public function get_vacances_scolaires() {

        $this->db->select('*')->from('vacances');
        $row = $this->db->get()->result();
        $to_return = array();

        foreach ($row as $vacances) {
            $to_return["vac" . $vacances->id_vacances]["debut"] = $vacances->date_debut;
            $to_return["vac" . $vacances->id_vacances]["fin"] = $vacances->date_fin;
        }

        return $to_return;
    }

    public function sauvegarder_vacances_scolaires($liste_dates) {

        $this->db->empty_table('vacances');

        foreach ($liste_dates as $key => $dates) {

            $to_insert = array(
                'id_vacances' => $key,
                'date_debut' => $dates["debut"],
                'date_fin' => $dates["fin"],
            );
            $this->db->insert('vacances', $to_insert);
        }
    }

    public function get_liste_classes() {

        $this->db->select('*')
                ->from('classe');

        $to_return = $this->db->get()->result();
        return $to_return;
    }

    public function get_classe_id($id_classe) {
        $this->db->select('*')
                ->from('classe')
                ->where('id_classe', $id_classe);

        $query = $this->db->get()->result();
        return $query;
    }

    public function is_classe($id_classe) {

        //on vérifie que l'id passé en paramètre est dans la base
        $this->db->select('*')
                ->from('classe')
                ->where('id_classe', $id_classe);

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function is_empty_classe($id_classe) {

        //on vérifie que l'id passé en paramètre est dans la base
        $this->db->select('*')
                ->from('classe')
                ->where('id_classe', $id_classe)
                ->join('enfant', 'enfant.classe = classe.id_classe');

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return true;
        } else {
            return false;
        }
    }

    public function enregistrer_classe($nom_enseignant, $niveau, $id_classe) {

        $to_insert = array(
            'niveau' => $niveau,
            'nom_enseignant' => $nom_enseignant
        );

        $this->db->select('*')
                ->from('classe')
                ->where('id_classe', $id_classe);

        $classe_existe = $this->db->get()->result();

        if (empty($classe_existe)) {
            $this->db->insert('classe', $to_insert);
        } else {
            $this->db->where('id_classe', $id_classe);
            $this->db->update('classe', $to_insert);
        }
    }

    public function supprimer_classe($id_classe) {

        $this->db->delete('classe', array('id_classe' => $id_classe));
    }

    private function generer_mot_de_passe() {
        $mot_de_passe = "";
        $nb_caractere = 12;
        $chaine = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $longeur_chaine = strlen($chaine);

        for ($i = 1; $i <= $nb_caractere; $i++) {
            $place_aleatoire = mt_rand(0, ($longeur_chaine - 1));
            $mot_de_passe .= $chaine[$place_aleatoire];
        }

        return $mot_de_passe;
    }

    public function get_id_famille() {
        $this->db->select('id_resp_1, nom_famille')
                ->from('famille');
        $query = $this->db->get();
        return $query;
    }

    public function get_message() {
        $this->db->select('*')
                ->from('message inner join famille on message.id_expediteur=famille.id_resp_1')
                ->where('id_recepteur', 0);

        $query = $this->db->get();
        return $query;
    }

    public function delete_message($id_message) {
        $this->db->delete('message', array('id_message' => $id_message));
    }

    public function insertMessage($idf, $intitule, $contenu) {
        $data = array(
            'intitule' => $intitule,
            'contenu' => $contenu,
            'id_expediteur' => 0,
            'id_recepteur' => $idf,
        );
        $this->db->insert('message', $data);
    }

    function recuperer_tarifs() {

        $this->db->select('tarif_id, tarif_mont')
                ->from('tarifs');

        $query = $this->db->get()->result();

        foreach ($query as $row) {

            $to_return[$row->tarif_id] = $row->tarif_mont;
        }

        return $to_return;
    }

    function form_tarifs($liste_tarifs) {

        foreach ($liste_tarifs as $key => $value) {

            $data = array(
                'tarif_mont' => $value
            );

            $this->db->where('tarif_id', $key);
            $this->db->update('tarifs', $data);
        }
    }

    public function load_document() {
        $upload_data = $this->upload->data();
        $this->db->set('nom_document', $upload_data['file_name']);
        return $this->db->insert('document');
    }

    public function get_document() {
        $this->db->select('*')
                ->from('document');
        $query2 = $this->db->get();
        return $query2;
    }

    public function delete_document($id_document) {
        $this->load->helper('file');
        $this->db->select('nom_document')->from('document')->where('id_document', $id_document);
        $nom_fichier = $this->db->get();
        $this->db->delete('document', array('id_document' => $id_document)); //on supprime l'entrée correspondantes dans la table document
        delete_files("./assets/documents/" . $nom_fichier);
    }

    public function get_liste_inscriptions($id_enfant = '') {

        $dates = $this->calendrier_model->get_liste_repas_enfant($id_enfant);

        $days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        $months = array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

        $data["inscrip_enfant"]["dates"] = $dates;
        $data["inscrip_enfant"]["jours"] = $days;
        $data["inscrip_enfant"]["mois"] = $months;

        return $data;
    }

    public function set_facturation_repas($id_enfant, $liste_date_repas, $type) {

        $liste_tarif = $this->recuperer_tarifs();
        $prix_non_inscrit = $liste_tarif["prixPasIns"];
        $prix_hebdo = $liste_tarif["prixHebdo"];
        $prix_hd = $liste_tarif["prixHD"];
        $is_suppression = false;

        switch ($type) {
            case "normal":
                $data = array(
                    'hors_delais' => 0,
                    'pas_inscrit' => 0,
                    'prix' => $prix_hebdo
                );


                break;
            case "hors_delais":
                $data = array(
                    'hors_delais' => 1,
                    'pas_inscrit' => 0,
                    'prix' => $prix_hd
                );


                break;
            case "sans_inscrip":
                $data = array(
                    'hors_delais' => 0,
                    'pas_inscrit' => 1,
                    'prix' => $prix_non_inscrit
                );
                break;

            case "suppression":
                $is_suppression = true;

                break;
        }

        foreach ($liste_date_repas as $date_repas) {

            unset($data['date']);
            unset($data['id_enfant_repas']);

            if ($is_suppression == false) {
                if ($this->is_repas_existant($id_enfant, $date_repas) == true) {
                    $this->db->where(array('id_enfant_repas' => $id_enfant, 'date' => $date_repas));
                    $this->db->update('repas', $data);
                } else {
                    $data['date'] = $date_repas;
                    $data['id_enfant_repas'] = $id_enfant;
                    $this->db->insert('repas', $data);
                }
            } else {
                $this->db->where(array('id_enfant_repas' => $id_enfant, 'date' => $date_repas));
                $this->db->delete('repas');
            }
        }
    }

    private function is_repas_existant($id_enfant, $date_repas) {

        //on vérifie que l'id passé en paramètre est dans la base
        $this->db->select('*')
                ->from('repas')
                ->where(array('id_enfant_repas' => $id_enfant, 'date' => $date_repas));

        $query = $this->db->get();
        $row = $query->result();

        if (empty($row)) {
            return false;
        } else {
            return true;
        }
    }

    public function get_famille_by_enfant($id_enfant) {

        $this->db->select('famille.id_famille')
                ->from('famille')
                ->join('enfant', 'enfant.id_famille=famille.id_famille')
                ->where('enfant.id_enfant', $id_enfant);

        $query = $this->db->get();
        $row = $query->result();

        return $row[0];
    }

    public function get_infos_enfant($id_enfant) {

        $this->db->select('*')
                ->from('enfant')
                ->where('id_enfant', $id_enfant)
                ->join('classe', "enfant.classe=classe.id_classe", "left");

        $query = $this->db->get();
        $row = $query->result();
        if (!empty($row)) {
            return $row[0];
        } else {

            return array();
        }
    }

}

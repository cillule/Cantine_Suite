<?php

class Parents_model extends CI_Model {

    protected $table_responsable = 'responsable';
    private $id_resp;
    private $id_famille;

    function __construct() {
        parent::__construct();

        $this->id_resp = $this->session->userdata('id_user');
    }

//get_id_famille: permet de connaitre l'id de la famille à laq
    function get_id_famille() {

        $this->db->select('id_famille')
                ->from('famille')
                ->where('id_resp_1', $this->id_resp);


        $return = $this->db->get()->result();



        return $return[0]->id_famille;
    }

    function form_parents($data) {

        $this->db->where('id_responsable', $this->id_resp);
        $this->db->update('responsable', $data);
    }

    function is_enfant_from_famille($id_enfant) {

        $id_famille = $this->get_id_famille();
        $this->db->select('id_enfant')
                ->from('enfant')
                ->where(array('id_famille' => $id_famille, 'id_enfant' => $id_enfant));

        $query = $this->db->get();
        $rowcount = $query->num_rows();

        if ($rowcount == 0) {
            return false;
        } else {

            return true;
        }
    }

    function recuperer_info_parents() {
        $this->db->select('nom, adresse, prenom, tel_mobile, mail,tel_travail, ville')
                ->from('responsable')
                ->where('id_responsable', $this->id_resp);
        $query = $this->db->get();

        return $query;
    }

    public function enregitrer_nouveau_mdp($new_mdp) {

        $mdp = password_hash($new_mdp, PASSWORD_BCRYPT);

        $this->db->query("UPDATE responsable set mdp='$mdp' where id_responsable = $this->id_resp");
    }

// get_enfant: Recupérer les enfant dans la base de données
    function get_enfants() {

        $id_famille = $this->session->userdata('id_famille');

        $this->db->select('id_enfant, nom, prenom, niveau, nom_enseignant, regime_alimentaire,allergie,type_inscription')
                ->from('enfant')
                ->where('id_famille', $id_famille)
                ->join('classe', 'enfant.classe=classe.id_classe');

        $query = $this->db->get();

        return $query;
    }

    //Permet d'avoir la liste des classes + enseignant
    function get_liste_classes() {

        $this->db->select('*')
                ->from('classe');

        $query = $this->db->get();
        return $query->result();
    }

// add_enfant: Ajouter un enfant
    function add_enfant($nom, $prenom, $classe, $regime_alimentaire, $allergie, $type_inscription) {

        $id_famille = $this->session->userdata('id_famille');

        $this->db->select('max(id_enfant) as id_max')
                ->from('enfant');

        $query = $this->db->get();
        $row = $query->result();
        $id_enfant = ($row[0]->id_max) + 1; //on selectionne un ID max pour l'enfant à ajouter

        $to_insert = array(//preparation des données à ajouter
            'id_enfant' => $id_enfant,
            'id_famille' => $id_famille,
            'nom' => $nom,
            'prenom' => $prenom,
            'classe' => $classe,
            'regime_alimentaire' => $regime_alimentaire,
            'allergie' => $allergie,
            'type_inscription' => $type_inscription,
        );

        $this->db->insert('enfant', $to_insert); //insertion dans la DB
        //on va ensuite gérer l'inscription de l'enfant si celle-ci est annuelle
        if ($type_inscription == 'Annuelle') {

            $schema_inscription = $this->input->post('schema_inscrip');
            $this->set_inscription_annuelle($id_enfant, $schema_inscription);
        }
    }

//ajoute tout les repas de l'entfat pour l'année en suivant le schema d'inscription 
    function set_inscription_annuelle($id_enfant, $schema_inscription) {

        $begin = new DateTime; // On récupère la date actuelle 
        //On récupère le premier jour des vacances d'été dans la base de données
        $this->db->select('date_debut')
                ->from('vacances')
                ->where('id_vacances', 3); //remettre 5

        $row = $this->db->get()->result();
        $end = new DateTime($row[0]->date_debut);

        //On sauvegarde le schéma d'inscription dans la base de données
        $this->set_schema_inscription_database($id_enfant, $schema_inscription);

        foreach ($schema_inscription as $daynumber) {

            switch ($daynumber) {

                case 0:
                    $interval = DateInterval::createFromDateString('next monday');
                    break;

                case 1:
                    $interval = DateInterval::createFromDateString('next tuesday');
                    break;

                case 2:
                    $interval = DateInterval::createFromDateString('next wednesday');
                    break;

                case 3:
                    $interval = DateInterval::createFromDateString('next thursday');
                    break;

                case 4:
                    $interval = DateInterval::createFromDateString('next friday');
                    break;
            }

            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {

                if ($this->calendrier_model->jour_ok($dt->format('Y-m-d')) && $dt->format('Y-m-d') != $begin->format('Y-m-d')) {//si le jour n'est pas durant les vacances
                    $to_insert = array(//preparation des données à ajouter
                        'date' => $dt->format('Y-m-d'),
                        'id_enfant_repas' => $id_enfant,
                        'prix' => 3.5,
                        'present' => 0,
                    );

                    $this->db->insert('repas', $to_insert); //insertion dans la DB
                }
            }
        }
    }

    private function set_schema_inscription_database($id_enfant, $schema_inscription) {

        //On ajoute l'enfant dans la table
        $to_insert = array(
            'schem_id_enfant' => $id_enfant,
        );
        $this->db->insert('schema_inscription_annuelle', $to_insert); //insertion dans la DB
        //On update la table en fonction du schema
        foreach ($schema_inscription as $daynumber) {

            switch ($daynumber) {

                case 0://LUNDI
                    $this->db->query("UPDATE schema_inscription_annuelle set schem_lundi=1 where schem_id_enfant = $id_enfant");
                    break;

                case 1://MARDI
                    $this->db->query("UPDATE schema_inscription_annuelle set schem_mardi=1 where schem_id_enfant = $id_enfant");
                    break;

                case 2://MERCREDI
                    $this->db->query("UPDATE schema_inscription_annuelle set schem_mercredi=1 where schem_id_enfant = $id_enfant");
                    break;

                case 3://JEUDI
                    $this->db->query("UPDATE schema_inscription_annuelle set schem_jeudi=1 where schem_id_enfant = $id_enfant");
                    break;

                case 4://VENDREDI
                    $this->db->query("UPDATE schema_inscription_annuelle set schem_vendredi=1 where schem_id_enfant = $id_enfant");
                    break;
            }
        }
    }

    public function setInscriptions($liste_dates, $id_enfant = " ") {

        //on ajoute les données reçus en POST du calendrier (normalement ok car tout les enregistrements ont été éffacés)
        if (!empty($liste_dates)) {

            /* $this->db->select('schem_lundi,schem_mardi, schem_mercredi, schem_jeudi, schem_vendredi')
              ->from('schema_inscription_annuelle')
              ->where('schem_id_enfant', $id_enfant);

              $result_1 = $this->db->get()->result();
              $schema_inscrip = $result_1[0]; */

            $this->db->select('')
                    ->from('tarifs');

            $result = $this->db->get()->result();

            $prix_annuel = $result[0]->prixAetM;
            $prix_hebdo = $result[0]->prixHebdo;
            $prix_hd = $result[0]->prixHD;

            //on efface les entrées des deux mois à venir
            $this->db->query("DELETE FROM `repas` WHERE (MONTH(date) = MONTH(CURDATE()) OR MONTH(date) = MONTH(CURDATE())+1  OR MONTH(date) = MONTH(CURDATE())+2 ) and date > CURDATE() AND id_enfant_repas = " . $id_enfant);

            foreach ($liste_dates as $value) {
                $date = new DateTime($value["date"]);
                $type_inscription = $value["type"];

                if ($type_inscription == 0 || $type_inscription == 1) {

                    $prix = $prix_hebdo;
                } elseif ($type_inscription == 3) {
                    $prix = $prix_hd;
                }

                $to_insert = array(//preparation des données à ajouter
                    'date' => $date->format('Y-m-d'),
                    'id_enfant_repas' => $id_enfant,
                    'prix' => $prix,
                    'present' => 0,
                );

                $this->db->insert('repas', $to_insert);
            }
        }
    }

    function get_facturation() {

        $id_famille = $this->get_id_famille();

        $this->db->select('id_enfant, prenom, classe, type_inscription')
                ->from('enfant')
                ->where('id_famille', $id_famille);

        $row = $this->db->get()->result();

        $to_return = array();
        if (!empty($row)) {

            foreach ($row as $it) {

                $array1 = Array(
                    "id_enfant" => $it->id_enfant,
                    "prenom" => $it->prenom,
                    "classe" => $it->classe,
                    "type_inscription" => $it->type_inscription,
                );

                $to_return[$it->id_enfant]["info_enfant"] = $array1;
                $to_return[$it->id_enfant]["factures_associées"] = $this->get_factures_enfant($it->id_enfant);
            }
        }

        return $to_return;
    }

    function get_factures_enfant($id_enfant) {

        //a utiliser pour tache planifiée -> -> -> $this->db->select('YEAR(date) as annee, MONTH(date) as mois, sum(prix) as somme ')->from('repas')->where('id_enfant', $id_enfant)->group_by(array("YEAR(date)", "MONTH(date)"));
        $this->db->select('* ')->from('facture')->where('id_enfant', $id_enfant);
        $to_return = $this->db->get()->result();
        return $to_return;
    }

    function insertMessage($intitule, $contenu) {

        $id_resp = $this->session->userdata('id_user');
        $data = array(
            'intitule' => $intitule,
            'contenu' => $contenu,
            'id_expediteur' => $id_resp,
            'id_recepteur' => 0,
        );
        $this->db->insert('message', $data);
    }

    function get_document() {
        $this->db->select('*')
                ->from('document');
        $query2 = $this->db->get();
        return $query2;
    }

    function recuperer_tarifs() {
        $this->db->select('*')
                ->from('tarifs');
        $query = $this->db->get();
        return $query;
    }

    function recuperer_QR() {
        $this->db->select('question, reponse')
                ->from('faq');
        $query = $this->db->get();
        return $query;
    }

    function getmessage() {

        $id_resp = $this->session->userdata('id_user');
        $this->db->select('contenu')
                ->from('message')
                ->where(array('id_expediteur' => 0, 'id_recepteur' => $id_resp));

        $result = $this->db->get();
        return $result;
    }

}

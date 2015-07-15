<?php

class Cron_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function cron_gestion_facture() {
        
        $this->cron_creer_facture();
        $this->cron_envoyer_facture();
        
    }

    private function cron_envoyer_facture() {
        
    }

    private function cron_creer_facture() {


        //on recupère les dates utiles
        $now = new DateTime();
        $mois_courant = $now->format('m');
        $annee_courante = $now->format('Y');
      

        //requete SQLnth(date)= '" . $mois_courant 
        $where = "MONTH(date)= " . $mois_courant . " AND YEAR(date)=  " . $annee_courante;
        $this->db->select('id_enfant_repas as id_enfant, sum(prix) as montant ')
                ->from('repas')
                ->where($where)
                ->group_by(array(" id_enfant_repas"));
        $listes_factures = $this->db->get()->result();


        //insertion dans la base
        foreach ($listes_factures as $it) {

            $to_insert = array(
                "montant" => $it->montant,
                "mois" => $now->format('m'),
                "année" => $now->format('Y'),
                "id_enfant" => $it->id_enfant,
            );

            $this->db->insert("facture", $to_insert);
        }
    }

}

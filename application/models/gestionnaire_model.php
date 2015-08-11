<?php

class Gestionnaire_Model extends CI_Model {

    //retourne seulement les enfants présents dans la table repas
    function get_enfant_gestionnaire() {
        $date = date("Y-m-d");

        $this->db->select('*')
                ->from('repas')
                ->where('date', $date)
                ->join('enfant', 'enfant.id_enfant = repas.id_enfant_repas', 'left')
                ->join('classe', 'enfant.classe = classe.id_classe', 'left');

        $query = $this->db->get();
        return $query;
    }

    //retourne tout les enfants existants
    function get_enfant() {
        $sql = "select nom, prenom from enfant where id_enfant not in (select id_enfant_repas from repas where date = CURDATE())";
        $query = $this->db->query($sql);
        return $query;
    }

    /*function insert_enfant_gestionnaire($id_enfant) { // insertion de l'enfant dans la BD
        $date = date("Y-m-d");
        $sql = "SELECT *
                FROM repas
                WHERE id_enfant_repas = '" . $id_enfant . "' AND date = '" . $date . "' AND present=1";
        $query = $this->db->query($sql);

        if ($query->num_rows() == 0) {
            $data = array('present' => 1);
        } else {
            $data = array('present' => 0);
        }

        $this->db->where(array('id_enfant_repas' => $id_enfant, 'date' => $date));
        $this->db->update('repas', $data);
    }*/

    function insert_enfant_non_inscrit($nom_enfant, $prenom_enfant) {
        $date = date("Y-m-d");
        $this->db->select('id_enfant, tarif_mont')
                ->from('enfant, tarifs')
                ->where(array('nom' => $nom_enfant, 'prenom' => $prenom_enfant, 'tarif_id' => "prixPasIns"));
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            foreach ($query->result() as $row) {
                $id_enfant = $row->id_enfant;
                $prix = $row->tarif_mont;
            }

            $data = array(
                'id_enfant_repas' => $id_enfant,
                'date' => $date,
                'hors_delais' =>0,
                'pas_inscrit'=>1,
                'prix' => $prix
            );

            $this->db->insert('repas', $data);
            return true;
        } else {
            return false;
        }
    }

    
      public function enregistrer_nouveau_mdp($new_mdp) {

        $mdp = password_hash($new_mdp, PASSWORD_BCRYPT);

        $this->db->query("UPDATE responsable SET mdp='$mdp' WHERE id_responsable = 2 AND gestionnaire=1");
    }
}

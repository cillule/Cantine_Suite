<?php

/**
 * Permet de gérer toutes les actions liée à l'utilisation du calendrier 
 *
 * @author Lucille
 * 
 * Inscription géré par les parents :
  Délai pour les modifications d'inscription :  jeudi soir pour la semaine suivante  (une fois le délai passé, bloquer la possibilité de modifier)
  ANNUEL : choix des jours de la semaine pour inscription à l'année (remplissage des jours choisis en automatique) mais possibilité de modifier tout au long de l'année dans la limite du délai cité ci dessus.
  MENSUEL : Possibilité de remplir au maximum les 2 mois suivants ou au minimum les 2 semaines suivantes avec la limite du délai ci dessus.
 * 
 * 
 * 
 */
class Calendrier_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Cette fonction permet de savoir si un jour  passé en paramètre est ou pas pendant une période de vacances
     * @param Date $jour une date est passée en paramètre
     * @return un booléen. True si le jour passé en paramètre n'est pas pendant une période de vacances, False autrement

     *  */
    public function jour_ok($jour) {

        $dates_vacances = $this->admin_model->get_vacances_scolaires();

        $date_actu = strtotime($jour);

        $interval_fin_toussaint = $date_actu - strtotime($dates_vacances["vac1"]["fin"]);
        $interval_debut_toussaint = $date_actu - strtotime($dates_vacances["vac1"]["debut"]);
        $interval_fin_noel = $date_actu - strtotime($dates_vacances["vac2"]["fin"]);
        $interval_debut_noel = $date_actu - strtotime($dates_vacances["vac2"]["debut"]);
        $interval_fin_hiver = $date_actu - strtotime($dates_vacances["vac3"]["fin"]);
        $interval_debut_hiver = $date_actu - strtotime($dates_vacances["vac3"]["debut"]);
        $interval_fin_printemps = $date_actu - strtotime($dates_vacances["vac4"]["fin"]);
        $interval_debut_printemps = $date_actu - strtotime($dates_vacances["vac4"]["debut"]);
        $interval_fin_ete = $date_actu - strtotime($dates_vacances["vac5"]["fin"]);
        $interval_debut_ete = $date_actu - strtotime($dates_vacances["vac5"]["debut"]);

        if ($interval_fin_toussaint < 0 && $interval_debut_toussaint > 0 || $interval_fin_noel < 0 && $interval_debut_noel > 0 || $interval_fin_hiver < 0 && $interval_debut_hiver > 0 || $interval_fin_printemps < 0 && $interval_debut_printemps > 0 || $interval_fin_ete < 0 && $interval_debut_ete > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Cette fonction permet d'obtenir des information utiles lors de l'affichage du calendrier permetant de gérer les inscriptions
     * @param int $id_enfant l'identifiant de l'enfant pour lequel on veut obtenir des informations
     * @return array contenant: les dates du mois courant + des deux suivants, les années

     *  */
    public function get_MoisSuivants($id_enfant) {

        $to_return = array();
        $to_return['type'] = array();
        $to_return['annees'] = array();
        $datecourante = new DateTime;

        $moiscourant = $datecourante->format('n');
        $anneecourante = $datecourante->format('Y');

        $date = new DateTime(date('Y-m-d', mktime(0, 0, 0, $moiscourant, 1, $anneecourante)));

        $jours_inscrit = $this->getJoursInscrit($id_enfant, $moiscourant);
        $this->get_inscription_enfant($id_enfant);

        while ($date->format('n') < $moiscourant + 3) {//pour le mois courant + les 2 suivants
            $y = $date->format('Y');
            $m = $date->format('n');
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));

            $to_return[$y][$m][$d] = $w;

            if (!in_array($y, $to_return['annees'])) {

                array_push($to_return['annees'], $y);
            }
            array_push($to_return["type"], $this->getType($jours_inscrit, $date, $id_enfant));
            $date->add(new DateInterval('P1D'));
        }


        return $to_return;
    }

    /**
     * Cette fonction permet d'obtenir des information utiles lors de l'affichage du calendrier permetant de gérer les inscriptions
     * @param array $jours_inscrit liste contenant des dates pour lesquelles un enfant est inscrit
     * @param DateTime $date date pour laquelle 
     * @return array contenant: les dates du mois courant + des deux suivants, les années

     *  */
//retourne: 1 -> l'enfant est inscrit et le jour est dans les délais
//          2 -> l'enfant est inscrit mais le jour n'est pas dans les délais 
//          0 -> l'enfant n'est pas inscrit mais le jour est dans les délais
//          3 -> l'enfant n'est pas inscrit et le jour n'est pas dans les délais 
//          4 -> jours pendant les vacances ou le week end
//          5 -> inscription annuelle dans les délais
    private function getType($jours_inscrit, $date, $id_enfant) {

        $now = new DateTime; //aujourd'hui
        $W_now = $now->format('W');
        $N_now = $now->format('N');

    //Pour la comparaison
        $y = $date->format('Y');
        $m = $date->format('m');
        $d = $date->format('d');
        $w = str_replace('0', '7', $date->format('w'));
        $W_date = $date->format('W');
        $N_date = $date->format('N');
       
        if ($w == 6 || $w == 7 || $this->jour_ok($y . "-" . $m . "-" . $d) == false) {//si le jour est pendant le WE ou les vacances
            
            return 4; //jour de vacance ou week end
        }

        if (in_array($y . "-" . $m . "-" . $d, $jours_inscrit)) {//SI l'enfant est déja inscrit pour ce jour
            if ($W_now == $W_date || $N_now > 4 && $W_now + 1 == $W_date) {// si on est hors délais
         
                return 2; //inscription hors délais 
            } else {


                return 1; //inscription dans les délais 
            }
        } else {// l'enfant n'est pas inscrit
            if ($W_now == $W_date || $N_now > 4 && $W_now + 1 == $W_date) {// si on est hors délais
                return 3; //pas inscrit et hors délais 
            } else {

                return 0; //pas inscrit mais jour dans les délais 
            }
        }
    }

    public function getJoursInscrit($id_enfant, $moiscourant) {
        $to_return = array();

        $where = "id_enfant_repas =" . $id_enfant . " AND (month(date)= " . $moiscourant . " OR month(date)= " . ($moiscourant + 1) . " OR month(date)= " . ($moiscourant + 2) . ")";

        $this->db->select('date ')
                ->from('repas')
                ->where($where);

        $row = $this->db->get()->result();

        foreach ($row as $key) {
            array_push($to_return, $key->date);
        }

        return $to_return;
    }

    public function getCalendrierMois($mois, $annee) {

        $to_return = array();

        $moiscourant = $mois;
        $anneecourante = $annee;

        $date = new DateTime(date('Y-m-d', mktime(0, 0, 0, $moiscourant, 1, $anneecourante))); //le premier jour du mois

        while ($date->format('n') < $moiscourant + 1) {//pour le mois courant + les 2 suivants
            $d = $date->format('j');
            $w = str_replace('0', '7', $date->format('w'));

            $to_return[$d] = $w;

            $date->add(new DateInterval('P1D'));
        }

        return $to_return;
    }

    private function get_inscription_enfant($id_enfant) {

        $this->db->select('id_enfant, type_inscription')
                ->from('enfant')
                ->where('id_enfant', $id_enfant);

        $result = $this->db->get()->result();

        if (strcmp($result[0]->type_inscription, "Annuelle") == 0) {

            $this->db->select('schem_lundi, schem_mardi, schem_mercredi, schem_jeudi, schem_vendredi')
                    ->from('schema_inscription_annuelle')
                    ->where('schem_id_enfant', $id_enfant);

            $jours_inscript_annuelle = $this->db->get()->result();

            $i = 1;
            foreach ($jours_inscript_annuelle[0] as $row) {
                $schema_inscript[$i] = $row;
                $i++;
            }
        } else {

            $i = 1;
            while ($i < 6) {
                $schema_inscript[$i] = 0;
                $i++;
            }
        }

        return $schema_inscript;
    }

}

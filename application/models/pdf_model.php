<?php

/**
 * Permet de créer des documents format PDF (facture, tableaux,...)
 *
 * @author Lucille
 *
 * 
 */
class PDF_model extends CI_Model {

    private $pdf;
    private $infos_facture;
    private $infos_enfant;
    private $infos_famille;

    function __construct() {

        require_once('./FPDF/invoice.php');
        parent::__construct();
    }

    public function export_facture($id_facture) {
        $this->infos_facture = $this->get_infos_facture($id_facture);
        $this->infos_enfant = $this->get_infos_enfant();
        $this->infos_famille = $this->get_infos_famille();

        $this->pdf = new PDF_Invoice('P', 'mm', 'A4');
        $this->pdf->AddPage();
        $this->pdf->temporaire("DUPLICATA");
        $this->creation_entete_facture();
        $this->creation_corps_facture();
        $this->pdf->Output($this->get_infos_enfant()->prenom . "_" . $this->get_infos_enfant()->nom . "_" . $this->infos_facture->annee . "/" . $this->infos_facture->mois . ".pdf", 'D');
        $this->pdf->Close();
    }

    private function creation_entete_facture() {

        $now = new DateTime;
        $this->pdf->addSociete("Cantine de Treffort-Cuisiat", "89 Impasse du Pecheur\n" .
                "01370 Treffort\n" .
                "Association");
        $date = new DateTime($this->infos_facture->annee . "-" . $this->infos_facture->mois);
        $this->pdf->fact_dev("Facture du", $date->format('m-Y'));
        $this->pdf->addDate($now->format('d-m-Y'));
        $this->pdf->addClient($this->infos_enfant->prenom . " " . $this->infos_enfant->nom);
        $this->pdf->addPageNumber("1");
        $this->pdf->addClientAdresse($this->get_adresse_facturation());
        $this->pdf->addReglement("Rendre facture + chèque");
    }

    private function creation_corps_facture() {

        $liste_repas = $this->get_liste_repas();


        $cols = array("DATE" => 70,
            "TARIF" => 70,
            "MONTANT LIGNE" => 50);
        $this->pdf->addCols($cols);

        $cols = array("DATE" => "C",
            "TARIF" => "R",
            "MONTANT LIGNE" => "R");
        $this->pdf->addLineFormat($cols);
        $this->pdf->addLineFormat($cols);

        $y = 109;

        $montant_facture = array();

        foreach ($liste_repas as $it) {

            $date = new DateTime($it->date);

            $line = array("DATE" => "Repas du " . $date->format('d-m-Y'),
                "TARIF" => $it->prix . " " . EURO,
                "MONTANT LIGNE" => $it->prix . " " . EURO);
            $size = $this->pdf->addLine($y, $line);
            $y += $size + 2;

            array_push($montant_facture, array("px_unit" => $it->prix, "qte" => 1, "tva" => 1));
        }

        $tab_tva = array("1" => 0);

        $params = array("RemiseGlobale" => 1,
            "remise_tva" => 0, // {la remise s'applique sur ce code TVA}
            "remise" => 0, // {montant de la remise}
            "remise_percent" => 0, // {pourcentage de remise sur ce montant de TVA}
            "FraisPort" => 0,
            "portTTC" => 0, // montant des frais de ports TTC
            // par defaut la TVA = 19.6 %
            "portHT" => 0, // montant des frais de ports HT
            "portTVA" => 5.5, // valeur de la TVA a appliquer sur le montant HT
            "AccompteExige" => 0,
            "accompte" => 0, // montant de l'acompte (TTC)
            "accompte_percent" => 0, // pourcentage d'acompte (TTC)
            "Remarque" => " ");

        $this->pdf->addTVAs($params, $tab_tva, $montant_facture);
        $this->pdf->addCadreTVAs();
        $this->pdf->addCadreEurosFrancs();
    }

    private function get_infos_facture($id_facture) {

        $this->db->select('id_facture, mois, année as annee')
                ->from('facture')
                ->where('id_facture', $id_facture);

        $row = $this->db->get()->result();


        return $row[0];
    }

    private function get_infos_enfant() {

        $this->db->select('id_enfant')
                ->from('facture')
                ->where('id_facture', $this->infos_facture->id_facture);

        $row = $this->db->get()->result();

        $id_enfant = $row[0]->id_enfant;


        $this->db->select('id_enfant, id_famille, nom, prenom, type_inscription')
                ->from('enfant')
                ->where('id_enfant', $id_enfant);


        $to_return = $this->db->get()->result();

        return $to_return[0];
    }

    private function get_infos_famille() {

        $this->db->select('*')
                ->from('famille')
                ->where('id_famille', $this->infos_enfant->id_famille);


        $row = $this->db->get()->result();

        $to_return["famille"] = $row[0];

        $id_resp1 = $row[0]->id_resp_1;

        $this->db->select('id_responsable, nom, prenom, adresse, ville')
                ->from('responsable')
                ->where('id_responsable', $id_resp1);


        $row1 = $this->db->get()->result();
        $to_return["resp_1"] = $row1[0];

        return $to_return;
    }

    private function get_liste_repas() {

        //on recupère les dates utiles
        $date = new DateTime($this->infos_facture->annee . "-" . $this->infos_facture->mois . "-01");
        $date_fin = $date->format('Y-m') . "-25";
        $date_2 = new DateTime($this->infos_facture->annee . "-" . $this->infos_facture->mois . "-01 -1 month");
        $date_debut = $date_2->format('Y-m') . "-25";

        //requete SQL
        $where = "(date BETWEEN '" . $date_debut . "' AND '" . $date_fin . "') AND (id_enfant_repas=" . $this->infos_enfant->id_enfant . ")";
        $this->db->select('date, prix')
                ->from('repas')
                ->where($where);

        $liste_repas = $this->db->get()->result();

        return $liste_repas;
    }

    private function get_adresse_facturation() {

        $info_resp = $this->infos_famille['resp_1'];

        $adresse = $info_resp->nom . " " . $info_resp->prenom . "\n";
        $adresse = $adresse . $info_resp->adresse . "\n" . strtoupper($info_resp->ville) . "\n";

        return $adresse;
    }

}

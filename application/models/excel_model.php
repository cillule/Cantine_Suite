<?php

class Excel_model extends CI_Model {

    private $workbook;
    private $sheet;
    private $infos_facture;
    private $infos_enfant;
    private $infos_famille;
    private $mois_tab;
    private $annee_tab;
    private $allborders;
    private $allborders_fin;
    private $style1;
    private $ligne_courante;
    private $liste_cell;

    function __construct() {

        require_once('./PHPExcel.php');
        parent::__construct();

        $this->allborders = array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
                'color' => array(
                    'rgb' => '808080'
                )
            )
        );

        $this->allborders_fin = array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                    'rgb' => '808080'
                )
            )
        );

        $this->style1 = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID
            ),
            'font' => array(
                'bold' => true,
                'center' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
    }

// <editor-fold defaultstate="collapsed" desc="Fonctions pour la création des factures">

    public function export_facture($id_facture) {

        $this->infos_facture = $this->get_infos_facture($id_facture);
        $this->infos_enfant = $this->get_infos_enfant();
        $this->infos_famille = $this->get_infos_famille();

        $this->workbook = new PHPExcel;
        $this->sheet = $this->workbook->getActiveSheet();

        $this->creation_entete_facture();
        $this->creation_corps_facture();
        $this->mise_en_page_facture();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename='Facture_" . $this->get_infos_enfant()->prenom . "_" . $this->get_infos_enfant()->nom . "_" . $this->infos_facture->annee . "/" . $this->infos_facture->mois . ".xls'");

        $writer = new PHPExcel_Writer_Excel5($this->workbook);
        $writer->save('php://output');
    }

    /*     * ********************************
     * FONCTIONS POUR LA CREATION DE FACTURE***
     * ************************************** */

    private function creation_entete_facture() {
        $styleFont = new PHPExcel_Style_Font();

        $styleFont->setBold(true);
        $styleFont->setSize(12);
        $styleFont->setName('Arial');
        $this->sheet->setCellValue('A1', 'Cantine de Treffort Cuisiat');
        $styleFont->setBold(false);
        $this->sheet->setCellValue('A2', '87 Impasse du Pecheur');
        $this->sheet->setCellValue('A3', '01370 Treffort-Cuisiat');
        $this->sheet->setCellValue('A4', 'Tel: 04 75 89 65');
        $this->sheet->setCellValue("C5", $this->get_adresse_facturation());
        $this->sheet->getStyle('C5')->getAlignment()->setWrapText(true);

        //Facture du...
        $date = new DateTime($this->infos_facture->annee . "-" . $this->infos_facture->mois);
        $this->sheet->setCellValue('C1', 'Facture du ' . $date->format('m-Y'));

        //Enfant
        $this->sheet->setCellValue('C3', 'Enfant: ' . $this->infos_enfant->prenom . " " . $this->infos_enfant->nom);
    }

    private function creation_corps_facture() {

        $liste_repas = $this->get_liste_repas();
        $ligne = 8;
        //entete du tableau
        $this->sheet->setCellValue('A' . $ligne, "Date");
        $this->sheet->getStyle('A' . $ligne)->getBorders()->applyFromArray($this->allborders);
        $this->sheet->setCellValue('B' . $ligne, "Tarif");
        $this->sheet->getStyle('B' . $ligne)->getBorders()->applyFromArray($this->allborders);
        $this->sheet->setCellValue('C' . $ligne, "Montant Ligne");
        $this->sheet->getStyle('C' . $ligne)->getBorders()->applyFromArray($this->allborders);

        $ligne++;

        foreach ($liste_repas as $it) {
            $date = new DateTime($it->date);

            $this->sheet->setCellValue('A' . $ligne, "Repas du " . $date->format('d-m-Y'));
            $this->sheet->getStyle('A' . $ligne)->getBorders()->applyFromArray($this->allborders_fin);
            $this->sheet->setCellValue('B' . $ligne, $it->prix);
            $this->sheet->getStyle('B' . $ligne)->getBorders()->applyFromArray($this->allborders_fin);
            $this->sheet->setCellValue('C' . $ligne, $it->prix);
            $this->sheet->getStyle('C' . $ligne)->getBorders()->applyFromArray($this->allborders_fin);

            $ligne++;
        }

        $ligne_fin = count($liste_repas) + 1;

        //TOTAL
        $this->sheet->setCellValue('B' . $ligne, "TOTAL");
        $this->sheet->getStyle('B' . $ligne)->getBorders()->applyFromArray($this->allborders);

        $this->sheet->setCellValue('C' . $ligne, '=SUM(C7:C' . $ligne_fin . ')');
        $this->sheet->getStyle('C' . $ligne)->getBorders()->applyFromArray($this->allborders);
    }

    private function mise_en_page_facture() {

        $this->sheet->getColumnDimension('A')->setWidth(25);
        $this->sheet->getColumnDimension('B')->setWidth(20);
        $this->sheet->getColumnDimension('C')->setWidth(23);
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Fonctions pour la création du tableau de suivi">

    public function export_tableau_suivi($mois, $annee) {

        $this->annee_tab = $annee;
        $this->mois_tab = $mois;
        $this->workbook = new PHPExcel;
        $this->sheet = $this->workbook->getActiveSheet();

        ///Creation du tableau
        $this->creation_entete_tableau();
        $this->creation_corps_tableau();
        $this->mise_en_page();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename='tableau_suivi" . $mois . "/" . $annee . ".xls'");
        $writer = new PHPExcel_Writer_Excel5($this->workbook);
        $writer->save('php://output');
    }

    private function creation_entete_tableau() {

        $this->sheet->setCellValue('A3', "Position");
        $this->sheet->setCellValue('B3', "Nom");
        $this->sheet->setCellValue('C3', "Prenom");
        $this->sheet->setCellValue('D3', "Classe-Enseignant");
        $this->sheet->setCellValue('E3', "Régime");
        $this->sheet->setCellValue('F3', "Allergie");
        $this->sheet->setCellValue('G3', "Type Inscription");

        $calendrier = $this->calendrier_model->getCalendrierMois($this->mois_tab, $this->annee_tab);

        $col = 7;
        foreach ($calendrier as $key => $value) {
            switch ($value) {
                case 1:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Lun');
                    break;

                case 2:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Mar');
                    break;

                case 3:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Mer');
                    break;

                case 4:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Jeu');
                    break;

                case 5:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Ven');
                    break;
                case 6:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Sam');
                    break;
                case 7:
                    $this->sheet->setCellValueByColumnAndRow($col, 2, 'Dim');
                    break;
            }
            $cell2 = $this->sheet->getCellByColumnAndRow($col, 2);
            $cell = $this->sheet->getCellByColumnAndRow($col, 3);
            $this->sheet->getColumnDimension($cell->getColumn())->setWidth(7);
            $cell->setValue($key);
            $col++;
        }

        $this->sheet->getStyle("A3:" . $cell->getCoordinate())->getBorders()->applyFromArray($this->allborders);
        $this->sheet->getStyle("A3:" . $cell->getCoordinate())->applyFromArray($this->style1);

        $this->sheet->getStyle("G2:" . $cell2->getCoordinate())->getBorders()->applyFromArray($this->allborders);
        $this->sheet->getStyle("G2:" . $cell2->getCoordinate())->applyFromArray($this->style1);
    }

    private function creation_corps_tableau() {

        //on récupère la liste des enfants
        $liste = $this->get_liste_enfants();
        $liste_triee = $this->tri_liste($liste);
        $this->ligne_courante = 5;
        $size = count($liste_triee);
        $i = $size;

        while ($i != 0) {
            $classe = $liste_triee[$i];

            if (!empty($classe)) {

                $this->creation_ligne_classe($classe);
                $this->ligne_courante = $this->ligne_courante + 2;
            }

            $i--;
        }

        $calendrier = $this->calendrier_model->getCalendrierMois($this->mois_tab, $this->annee_tab);
        $col = 7;
        $this->sheet->setCellValueByColumnAndRow(6, $this->ligne_courante, "TOTAL :");
        $cell_debut = $this->sheet->getCellByColumnAndRow(6, $this->ligne_courante)->getCoordinate();

        foreach ($calendrier as $date => $day) {

            $this->sheet->setCellValueByColumnAndRow($col, $this->ligne_courante, $this->make_sum($this->liste_cell[$date]));
            $col++;
        }

        $cell_fin = $this->sheet->getCellByColumnAndRow($col - 1, $this->ligne_courante)->getCoordinate();

        $this->sheet->getStyle($cell_debut . ":" . $cell_fin)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'F28A8C')
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                )
        );
        
        $this->sheet->getStyle($cell_debut . ":" . $cell_fin)->getBorders()->applyFromArray($this->allborders);
    }

    private function tri_liste($liste) {
        $i = count($liste) - 1;
        $tab_trie = array(array(), array(), array(), array(), array(), array(), array(), array(), array(), array());

        while ($i != -1) {

            $enfant = $liste[$i];
            $niveau_inf = explode("-", $enfant->niveau);

            switch (strtoupper($niveau_inf[0])) {

                case "MATERNELLE":
                    array_push($tab_trie[0], $enfant);
                    break;

                case "PS":
                    array_push($tab_trie[1], $enfant);
                    break;

                case "MS":
                    array_push($tab_trie[2], $enfant);
                    break;

                case "GS":
                    array_push($tab_trie[3], $enfant);
                    break;

                case "GRANDE SECTION":
                    array_push($tab_trie[3], $enfant);
                    break;


                case "CP":
                    array_push($tab_trie[4], $enfant);
                    break;

                case "CE1":
                    array_push($tab_trie[5], $enfant);
                    break;

                case "CE2":
                    array_push($tab_trie[6], $enfant);
                    break;

                case "CM1":
                    array_push($tab_trie[7], $enfant);
                    break;

                case "CM2":
                    array_push($tab_trie[8], $enfant);
                    break;

                default :
                    array_push($tab_trie[9], $enfant);
                    break;
            }

            array_pop($liste);
            $i--;
        }

        return $tab_trie;
    }

    private function creation_ligne_classe($liste_classe, $ligne = "") {

        $ligne_debut = $this->ligne_courante;
        $calendrier = $this->calendrier_model->getCalendrierMois($this->mois_tab, $this->annee_tab);
        $i = 1;

        foreach ($liste_classe as $enfant) {

            $this->sheet->setCellValueByColumnAndRow(0, $this->ligne_courante, $i);
            $this->sheet->setCellValueByColumnAndRow(1, $this->ligne_courante, $enfant->nom);
            $this->sheet->setCellValueByColumnAndRow(2, $this->ligne_courante, $enfant->prenom);
            $this->sheet->setCellValueByColumnAndRow(3, $this->ligne_courante, $enfant->niveau . " - " . $enfant->nom_enseignant);
            $this->sheet->setCellValueByColumnAndRow(4, $this->ligne_courante, $enfant->regime_alimentaire);
            $this->sheet->setCellValueByColumnAndRow(5, $this->ligne_courante, $enfant->allergie);
            $this->sheet->getStyle('F' . $this->ligne_courante)->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12,
                    'name' => Arial,
                    'color' => array(
                        'rgb' => 'FF0000'))
            ));
            $this->sheet->setCellValueByColumnAndRow(6, $this->ligne_courante, $enfant->type_inscription);

            //remplissage du calendrier
            $this->crea_ligne_repas($enfant->id_enfant, $this->ligne_courante);
            $cell_fin = $this->sheet->getCellByColumnAndRow($this->ligne_courante, 7)->getCoordinate();
            $i++;
            $this->ligne_courante++;
        }

        $col = 7;
        $this->sheet->setCellValueByColumnAndRow(3, $this->ligne_courante, $enfant->niveau . " - " . $enfant->nom_enseignant);
        $this->sheet->setCellValueByColumnAndRow(5, $this->ligne_courante, "TOTAL " . $enfant->classe . ": ");

        foreach ($calendrier as $date => $day) {

            $cell_debut = $this->sheet->getCellByColumnAndRow($col, $ligne_debut)->getCoordinate();
            $cell_fin = $this->sheet->getCellByColumnAndRow($col, $this->ligne_courante - 1)->getCoordinate();

            $this->sheet->setCellValueByColumnAndRow($col, $this->ligne_courante, "=SUM(" . $cell_debut . ":" . $cell_fin . ")");

            if (empty($this->liste_cell[$date])) {
                $this->liste_cell[$date] = array();
            }
            array_push($this->liste_cell[$date], $this->sheet->getCellByColumnAndRow($col, $this->ligne_courante)->getCoordinate());
            $col++;
        }

        $cell_1 = $this->sheet->getCellByColumnAndRow(0, $this->ligne_courante)->getCoordinate();
        $cell_2 = $this->sheet->getCellByColumnAndRow($col - 1, $this->ligne_courante)->getCoordinate();
        $this->sheet->getStyle($cell_1 . ":" . $cell_2)->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'F28A8C')
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                )
        );

        $this->sheet->getStyle($cell_1 . ":" . $cell_2)->getBorders()->applyFromArray($this->allborders);
    }

    private function crea_ligne_repas($id_enfant, $ligne = "") {
        $ligne_debut = $this->ligne_courante;
        $calendrier = $this->calendrier_model->getCalendrierMois($this->mois_tab, $this->annee_tab);
        $col = 7;

        foreach ($calendrier as $day => $value) {

            $date = new DateTime($this->annee_tab . '-' . $this->mois_tab . '-' . $day);
            $this->db->select('*')
                    ->from('repas')
                    ->where(array('id_enfant_repas' => $id_enfant, 'date' => $date->format("Y-m-d")));

            $row = $this->db->get()->result();


            if ($value == 6 || $value == 7) {

                $cell = $this->sheet->getCellByColumnAndRow($col, $this->ligne_courante)->getCoordinate();
                $this->sheet->getStyle($cell)->applyFromArray(
                        array(
                            'fill' => array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => '666666')
                            )
                        )
                );
            }

            if (!empty($row)) {
                $calendrier[$day] = 1;
            } else {
                $calendrier[$day] = 0;
            }

            $col++;
        }


        $col = 7;
        $cell_debut = $this->sheet->getCellByColumnAndRow($col, $this->ligne_courante)->getCoordinate();
        foreach ($calendrier as $day => $value) {

            if ($value == 1) {
                $this->sheet->setCellValueByColumnAndRow($col, $this->ligne_courante, 1);
            } else {

                $this->sheet->setCellValueByColumnAndRow($col, $this->ligne_courante, 0);
            }
            $cell_fin = $this->sheet->getCellByColumnAndRow($col, $this->ligne_courante)->getCoordinate();
            $col++;
        }


        $this->sheet->getStyle("A" . $ligne_debut . ":" . $cell_fin)->getBorders()->applyFromArray($this->allborders_fin);
    }

    private function make_sum($liste_cellule) {

        $formule = "=";
        $lastKey = array_pop(array_keys($liste_cellule));
        foreach ($liste_cellule as $key => $cell) {
            if ($key != $lastKey) {
                $formule = $formule . $cell . "+";
            } else {
                $formule = $formule . $cell;
            }
        }

        return $formule;
    }

    private function mise_en_page() {

        $this->sheet->getColumnDimension('A')->setWidth(10);
        $this->sheet->getColumnDimension('B')->setWidth(15); //colonne Nom
        $this->sheet->getColumnDimension('C')->setWidth(15); //colonne Prenom
        $this->sheet->getColumnDimension('D')->setWidth(25); //colonne Classe-Enseignant
        $this->sheet->getColumnDimension('E')->setWidth(25); //colonne Regime
        $this->sheet->getColumnDimension('F')->setWidth(20); //colonne Allergie
        $this->sheet->getColumnDimension('G')->setWidth(20); //colonne Allergie
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Fonctions pour la creation de la feuille de presence"> 

    public function export_feuille_presence($date) {

        $this->workbook = new PHPExcel;

        $this->sheet = $this->workbook->getActiveSheet();

        $this->creation_entete_feuille_presence($date);
        $this->creation_feuille_presence($date);
        $this->mise_en_page_fp();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename='feuille_presence_" . $date . ".xls'");
        $writer = new PHPExcel_Writer_Excel5($this->workbook);
        $writer->save('php://output');
    }

    private function creation_feuille_presence($date) {

        $this->db->select('id_enfant, nom, prenom, niveau, nom_enseignant, regime_alimentaire, allergie')
                ->from('repas')
                ->join('enfant', 'enfant.id_enfant = repas.id_enfant_repas')
                ->join('classe', 'enfant.classe = classe.id_classe')
                ->where('date', $date);

        $liste = $this->db->get()->result();

        $ligne = 4;

        if (!empty($liste)) {


            $liste_triee = $this->tri_liste($liste);

            foreach ($liste_triee as $classe) {

                if (!empty($classe)) {
                    $this->ecriture_presence_classe($classe, $ligne);
                    $this->sheet->getStyle("A" . $ligne . ":D" . $ligne)->getBorders()->applyFromArray($this->allborders_fin);
                    $ligne = $ligne + count($classe) + 1;
                }
            }
        }
    }

    private function creation_entete_feuille_presence($date) {
        $this->sheet->getStyle("A1")->applyFromArray($this->style1);
        $this->sheet->setCellValue('A1', "Feuille de présence du " . $date);
        $this->sheet->mergeCells('A1:D1');
        $this->sheet->setCellValue('A3', "Position");
        $this->sheet->setCellValue('B3', "Nom");
        $this->sheet->setCellValue('C3', "Prenom");
        $this->sheet->setCellValue('D3', "Classe-Enseignant");
        $this->sheet->setCellValue('E3', " Regime Alimentaire");
        $this->sheet->setCellValue('F3', "Allergie");
        $this->sheet->setCellValue('G3', "Présent");
    }

    private function ecriture_presence_classe($classe, $ligne) {
        $position_enfant = 1;
        foreach ($classe as $enfant) {

            $this->sheet->setCellValueByColumnAndRow(0, $ligne, $position_enfant);
            $this->sheet->setCellValueByColumnAndRow(1, $ligne, strtoupper($enfant->nom));
            $this->sheet->setCellValueByColumnAndRow(2, $ligne, $enfant->prenom);
            $this->sheet->setCellValueByColumnAndRow(3, $ligne, $enfant->niveau . " - " . $enfant->nom_enseignant);
            $this->sheet->setCellValueByColumnAndRow(4, $ligne, $enfant->regime_alimentaire);
            $this->sheet->setCellValueByColumnAndRow(5, $ligne, $enfant->allergie);
            $this->sheet->getStyle('F' . $ligne)->applyFromArray(array(
                'font' => array(
                    'bold' => true,
                    'size' => 12,
                    'name' => Arial,
                    'color' => array(
                        'rgb' => 'FF0000'))
            ));
            $this->sheet->setCellValueByColumnAndRow(6, $ligne, " ");
            $this->sheet->getStyle("A" . $ligne . ":G" . $ligne)->getBorders()->applyFromArray($this->allborders_fin);
            $position_enfant++;
            $ligne++;
        }
    }

    private function mise_en_page_fp() {
        //taille des cellules
        $this->sheet->getColumnDimension('A')->setWidth(10); //colonne Position
        $this->sheet->getColumnDimension('B')->setWidth(20); //colonne Nom
        $this->sheet->getColumnDimension('C')->setWidth(20); //colonne Prenom
        $this->sheet->getColumnDimension('D')->setWidth(20); //colonne Classe-Enseignant
        $this->sheet->getColumnDimension('E')->setWidth(25); //colonne RA
        $this->sheet->getColumnDimension('F')->setWidth(20); //colonne Allergi
        $this->sheet->getColumnDimension('G')->setWidth(10);


        $this->sheet->getStyle("A3:G3")->getBorders()->applyFromArray($this->allborders);
    }

    // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Fonctions pour la creation de l'echeancier"> 
    public function export_echeancier($mois, $annee) {

        $this->annee_tab = $annee;
        $this->mois_tab = $mois;
        $this->workbook = new PHPExcel;
        $this->sheet = $this->workbook->getActiveSheet();

        ///Creation du tableau
        $this->creation_entete_echeancier();
        $this->creation_corps_echeancier();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename='recap_prelevement_" . $mois . "/" . $annee . ".xls'");
        $writer = new PHPExcel_Writer_Excel5($this->workbook);
        $writer->save('php://output');
    }

    public function creation_entete_echeancier() {

        $this->sheet->getStyle("A1")->applyFromArray($this->style1);
        $this->sheet->setCellValue('A1', "Echéancier du  " . $this->mois_tab . "/" . $this->annee_tab);
        $this->sheet->mergeCells('A1:C1');

        $this->sheet->setCellValue('A3', "Responsable");
        $this->sheet->setCellValue('B3', "Enfant");
        $this->sheet->setCellValue('C3', "MONTANT A PRELEVER");
        $this->sheet->getStyle('A3:C3')->getBorders()->applyFromArray($this->allborders);
    }

    public function creation_corps_echeancier() {

        $liste_montant = $this->get_liste_montant_mois();
        $num_ligne = 4;

        foreach ($liste_montant as $famille) {
            $total_famille = 0;
            $this->sheet->setCellValueByColumnAndRow(0, $num_ligne, strtoupper($famille["resp_nom"]) . " " . $famille["resp_prenom"]);
            $this->sheet->getStyle('A' . $num_ligne)->getBorders()->applyFromArray($this->allborders_fin);
            foreach ($famille["liste_enfants"] as $enfant) {

                $this->sheet->setCellValueByColumnAndRow(1, $num_ligne, strtoupper($enfant["enf_nom"]) . " " . $enfant["enf_prenom"]);
                $this->sheet->getStyle('B' . $num_ligne)->getBorders()->applyFromArray($this->allborders_fin);

                $this->sheet->setCellValueByColumnAndRow(2, $num_ligne, number_format($enfant["montant"], 2));
                $this->sheet->getStyle('C' . $num_ligne)->getBorders()->applyFromArray($this->allborders_fin);
                $this->sheet->getStyle('C' . $num_ligne)->getNumberFormat()->applyFromArray(
                        array(
                            'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                        )
                );
                $total_famille = $total_famille + $enfant["montant"];
                $num_ligne = $num_ligne + 1;
            }

            $this->sheet->setCellValueByColumnAndRow(0, $num_ligne, strtoupper($famille["resp_nom"]) . " " . $famille["resp_prenom"]);
            $this->sheet->getStyle('A' . $num_ligne)->getBorders()->applyFromArray($this->allborders);
            $this->sheet->setCellValueByColumnAndRow(1, $num_ligne, "TOTAL: ");
            $this->sheet->getStyle('B' . $num_ligne)->getBorders()->applyFromArray($this->allborders);
            $this->sheet->setCellValueByColumnAndRow(2, $num_ligne, number_format($total_famille, 2));
            $this->sheet->getStyle('C' . $num_ligne)->getNumberFormat()->applyFromArray(
                    array(
                        'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00
                    )
            );
            $this->sheet->getStyle('C' . $num_ligne)->getBorders()->applyFromArray($this->allborders);
            $num_ligne = $num_ligne + 1;
        }

        $this->sheet->setCellValueByColumnAndRow(1, $num_ligne, "TOTAL DES PRELEVEMENT: ");
        $this->sheet->getStyle('B' . $num_ligne)->getBorders()->applyFromArray($this->allborders);
        $this->sheet->setCellValueByColumnAndRow(2, $num_ligne, '=SUM(C2:C' . ($num_ligne - 1) . ')');
        $this->sheet->getStyle('C' . $num_ligne)->getBorders()->applyFromArray($this->allborders);

        $this->sheet->getColumnDimension('A')->setWidth(30);
        $this->sheet->getColumnDimension('B')->setWidth(30);
        $this->sheet->getColumnDimension('C')->setWidth(25);
    }

    // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Fonctions pour la recherche d'informations"> 

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

        $this->db->select('id_enfant, id_famille, nom, prenom, type_inscription ')
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
        $adresse = $adresse . $info_resp->adresse . "\n" . strtoupper($info_resp->ville);

        return $adresse;
    }

    private function get_liste_enfants() {

        $this->db->select('id_enfant, nom, prenom, niveau, nom_enseignant, regime_alimentaire, allergie, type_inscription')
                ->from('enfant')
                ->join('classe', 'enfant.classe=classe.id_classe', "left")
                ->order_by('classe.niveau, classe.nom_enseignant, nom');

        return $this->db->get()->result();
    }

    private function get_liste_montant_mois() {

        $this->db->select('facture.montant, enfant.nom as enf_nom, enfant.prenom as enf_prenom, responsable.nom as resp_nom, responsable.prenom as resp_prenom, responsable.id_responsable as id_resp')
                ->from('facture')
                ->join('enfant', 'enfant.id_enfant=facture.id_enfant')
                ->join('famille', 'enfant.id_famille=famille.id_famille')
                ->join('responsable', 'famille.id_resp_1=responsable.id_responsable')
                ->where("facture.mois = " . $this->mois_tab . " AND facture.année = " . $this->annee_tab);

        $result = $this->db->get()->result();

        $liste_facture = array();

        foreach ($result as $ligne) {
            $liste_facture[$ligne->id_resp]["resp_nom"] = $ligne->resp_nom;
            $liste_facture[$ligne->id_resp]["resp_prenom"] = $ligne->resp_prenom;
            $liste_facture[$ligne->id_resp]["liste_enfants"][] = array("enf_nom" => $ligne->enf_nom, "enf_prenom" => $ligne->enf_prenom, "montant" => $ligne->montant);
        }


        return $liste_facture;
    }

    // </editor-fold>
}

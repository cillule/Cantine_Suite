<div class="row">

    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Factures <i class="fa fa-euro"></i></h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="<?php echo base_url('admin_control/affiche_facturation_info'); ?>">
                <fieldset>
                    <label> Sélectionnez une famille : </label>
                    <select class="selectpicker" data-style="btn-warning" name="select_famille">
                        <?php
                        foreach ($query->result() as $row):
                            ?>    
                            <option value="<?php echo $row->id_famille; ?>"><?php echo $row->nom_famille; ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                    <input type="submit" class="btn btn-success pull-right">
                </fieldset>
            </form>
        </div>

    </div>

</div>

<div class="row">
    <?php
    $somme_due = 0;
    if ($affiche_tuille == 1)://gestion de l'affichage de la tuille 
        if (!empty($infos_famille)) {
            foreach ($infos_famille as $key => $row):
                ?>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"> <i class="fa fa-info-circle"></i> Factures de <?php echo $row['info_enfant']['prenom']; ?></h3>
                    </div>
                    <div class="panel-body">
                        <table class="table text-uppercase">

                            <?php
                            if (!empty($row['factures_associées'])) {
                                ?> 

                                <thead>
                                    <tr>
                                        <th>Facture num </th>
                                        <th>Montant</th>
                                        <th>Situation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($row['factures_associées'] as $row2):
                                        ?>
                                        <tr>
                                            <td><?php echo '0' . $row2->mois . "/" . $row2->année ?></td>
                                            <td><?php echo $row2->montant; ?> <i class="fa fa-eur"></i></td>
                                            <td>
                                                <?php
                                                if ($row2->reglee == 1) {
                                                    ?>
                                                    <i style="color:green;" class="fa fa-2x fa-check"></i>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <i style="color:red;" class="fa fa-2x fa-remove"></i>
                                                    <?php
                                                    $somme_due = $somme_due - $row2->montant;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('admin_control/facture_reglee/' . $id_famille . '/' . $row2->id_facture); ?>" class="btn btn-success">Réglé</a> 
                                                <a href="<?php echo base_url('admin_control/export_facture_PDF/' . $row2->id_facture); ?>"  class="btn btn-warning">Générer PDF</a> 
                                                <a class="btn btn-danger" <a href="<?php echo base_url('admin_control/export_facture_Excel/' . $row2->id_facture); ?>" >Générer Excel</a>
                                            </td>
                                        </tr>

                                        <?php
                                    endforeach;
                                } else {
                                    ?>
                                <h4>Pas de facture associée à cette enfant!</h4>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>


                    <?php
                    $i = 0;
                    $now = new DateTime;

                    foreach ($row["calendrier_inscrip"]["inscrip_enfant"]["dates"]["annees"] as $year):
                        foreach ($row["calendrier_inscrip"]["inscrip_enfant"]["dates"][$year] as $m => $jours):
                            ?>

                            <div class ="month" id="mois<?php echo $m ?>">
                                <h2><?php echo $row["calendrier_inscrip"]["inscrip_enfant"]['mois'][$m - 1] . " - " . $year ?></h2>
                                <table class="table  table-responsive table-bordered">
                                    <thead>
                                        <tr>
                                            <?php
                                            foreach ($row["calendrier_inscrip"]["inscrip_enfant"]["jours"] as $jour):
                                                ?>
                                                <th>
                                                    <?php echo substr($jour, 0, 3) ?>
                                                </th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                            $end = end($jours);
                                            foreach ($jours as $d => $w):
                                                ?>
                                                <?php if ($d == 1 and $w != 1): ?>
                                                    <td colspan="<?php
                                                    echo $w - 1;
                                                    ?>"> </td>
                                                    <?php endif; ?>

                                                <?php
                                                if (new DateTime($year . "-" . $m . "-" . $d) < $now) {//
                                                    $type = $row["calendrier_inscrip"]["inscrip_enfant"]["dates"]['type'][$i];

                                                    $array_to_post = serialize(array("date" => "2015" . "-" . $m . "-" . $d, "type" => $type));

                                                    switch ($type) {
                                                        case 0://pas de repas
                                                            echo "<td>";
                                                            echo $d;
                                                            echo "</td>";
                                                            break;
                                                        
                                                        case 1://repas normal
                                                            //cellule verte 
                                                            echo "<td style='background-color: #3AF70A'>";
                                                            echo $d;
                                                            echo "</td>";
                                                            break;
                                                        case 2://repas hors delais
                                                            //cellule orange 
                                                            echo "<td style='background-color: #F7C00A'>";
                                                            echo $d;
                                                            echo "</td>";
                                                            break;
                                                        case 3://repas non inscrit
                                                            //cellule rouge
                                                            echo "<td style='background-color: #F7690A'>";
                                                            echo $d;
                                                            echo '</td>';
                                                            break;

                                                        case 5://le jour est pendant le week end ou les vacances
                                                            //cellule grisée non checkable
                                                            echo "<td style='background-color: #A2B5BF'>";
                                                            echo $d;
                                                            echo '</td>';
                                                            break;

                                                        default:
                                                            break;
                                                    }
                                                } else {
                                                    echo "<td>";
                                                    echo $d;
                                                    echo "</td>";
                                                } $i++;
                                                ?> 
                                                <?php if ($w == 7): ?>

                                                </tr><tr>
                                                    <?php
                                                endif;
                                            endforeach;
                                            if ($end != 7):
                                                ?>
                                                <td colspan="<?php echo 7 - $end; ?>"> </td>
                                            <?php endif; ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        endforeach;
                    endforeach;
                    ?>
                        <form method="post" class="pull-right" role="form" id="form_edit_facturation_<?php echo $key ?>" action="<?php echo base_url('admin_control/affiche_edit_facturation/' . $key); ?> "> 
                            <input type="hidden" name="id_famille" value="<?php echo $id_famille ?>">
                            <button class='btn btn-success' type="submit" form="form_edit_facturation_<?php echo $key ?>" >Gérer la facturation</button>
                        </form>
                    
                </div>
                <?php
            endforeach;
        } else {
            ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <span class="glyphicon glyphicon-info-sign"></span> Pas de factures associées à cette famille !
            </div>  
            <?php
        }
        ?>
        <div class="panel panel-info">
            <div class="panel-heading text-center">
                <h3 class="panel-title"> Situation au <?php echo date("d-m-Y"); ?> <i class="fa fa-info-circle"></i></h3>
            </div> 
            <div class="panel-body">
                <h4> Somme due: <?php echo abs($somme_due) . " Euros" ?>  </h4>    
            </div>
        </div>
        <?php
    endif;
    ?>

</div>

<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Générer le récapitulatif des prélèvements <i class="fa fa-euro"></i></h3>
        </div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="<?php echo base_url('admin_control/generer_echeancier'); ?>">
                <fieldset>
                    <label> Sélectionnez un mois : </label>
                    <div class="panel-body">
                        <div class="input-group">
                            <input required type="text" id="date_suivi_inscrit" name="date_echeancier" class="form-control"/>
                            <span class="input-group-btn">
                                <input type="submit" name="generer_excel" class="btn btn-success"  value="Générer Excel">
                            </span>
                        </div>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>

</div>

<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Générer la facturation pour le mois</h3>
        </div>

        <div class="panel-body">
            <p>Lancer la facturation: </p>
            <a class="btn btn-warning" href="<?php echo base_url('admin_control/generer_factures'); ?>">Lancer</a>
        </div>
    </div>

</div>

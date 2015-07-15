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
            
            foreach ($infos_famille as $row):
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

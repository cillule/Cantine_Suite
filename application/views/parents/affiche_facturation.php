<div class="row text-center">
    <?php
    $somme_due = 0;

    if (!empty($infos_factures)) {
        foreach ($infos_factures as $row):
            ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Factures de <?php echo $row['info_enfant']['prenom']; ?> </h3>
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
                                            <a href="<?php echo base_url('parents_control/export_facture_PDF/' . $row2->id_facture); ?>"  class="btn btn-warning">Générer PDF</a> 
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

        echo'Aucune facture...';
    }
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> Situation au <?php echo date("d-m-Y"); ?> </h3>

        </div> 
        <br/>
        <h4> Somme due: <?php echo abs($somme_due) . " Euros" ?>  </h4>
        <div class="panel-body">

        </div>
    </div>

</div>

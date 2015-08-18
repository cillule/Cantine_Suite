<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Pointage<i class="fa fa-thumb-tack"></i></h3>
        </div>
        <div class="panel-body">
            <h3 class="text-warning">Liste des factures </h3>
            <table id="table_liste_facture" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Enfant</th>
                        <th>Montant</th>
                        <th>Réglée</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Famille</th>
                        <th>Enfant</th>
                        <th>Montant</th>
                        <th>Réglée</th>
                    </tr>
                </tfoot>
                <tbody class="text-center">
                    <?php foreach ($liste_factures as $facture):
                        
                        ?>
                        <tr>
                            <td><?php echo $facture->mois . "/" . $facture->année; ?></td>
                            <td><?php echo $facture->nom_famille; ?></td>
                            <td><?php echo $facture->enf_nom . " " . $facture->enf_prenom; ?></td>
                            <td><?php echo $facture->montant; ?></td>

                            <?php if ($facture->reglee == 1) { ?>
                            <td><input checked class="checkbox_liste_facture" data-toggle="toggle" data-on="Réglée" data-off="Non Réglée" type="checkbox" value="<?php echo $facture->id_facture; ?>"/><p class ="hidden">1</p></td>
                            <?php } else { ?>
                                <td><input class="checkbox_liste_facture" data-toggle="toggle" data-on="Réglée" data-off="Non Réglée" type="checkbox" value="<?php echo $facture->id_facture; ?>"/><p class ="hidden">0</p></td>
                                <?php } ?>
                        </tr>
                    <?php endforeach; ?>   
                </tbody>
            </table>
        </div>
    </div>

<?php
$date_affiche = date("d-m-Y");
$date = date("Y-m-d");
?>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Pointage Des Absents <i class="fa fa-thumb-tack"></i></h3>
        </div>
        <div class="panel-body">
            <h3 class="text-warning">
                <?php
                echo $date_affiche;
                ?>
            </h3>
            <table id="table_gestion" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Régime spécial</th>
                        <th>Allergie</th>
                        <th>Abonnement</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Régime spécial</th>
                        <th>Allergie</th>
                        <th>Abonnement</th>
                    </tr>
                </tfoot>
                <tbody class="text-center">
                    <?php
                    foreach ($query->result() as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row->nom; ?></td>
                            <td><?php echo $row->prenom; ?></td>
                            <td><?php echo $row->niveau." - ".$row->nom_enseignant; ?></td>
                            <td><?php echo $row->regime_alimentaire; ?></td>
                            <td><?php echo $row->allergie; ?></td>
                            <td><?php echo $row->type_inscription; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Recherche d'enfant non inscrit ce jour <i class="fa fa-search"></i></h3>
        </div>
        <div class="panel-body">
            <form role="form" method="post" action="<?php echo base_url("gestionnaire_control/ajouter_enfant"); ?>">
                <fieldset>
                    <div class="form-group">
                        <label for="text">Recherche : </label>
                        <input required id="recherche" name="recherche" type="text" class="form-control" placeholder="Recherche d'enfant">
                        <input type="submit" value="Ajouter enfant" class="btn btn-success pull-right">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

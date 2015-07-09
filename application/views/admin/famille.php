<div class="row">

    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Liste des familles inscrites <i class="fa fa-folder"></i></h3>
        </div>
        <div class="panel-body">
            <?php if ($query->num_rows() > 0): //si on a déja des familles inscrites ?>

                <table id="table_liste_famille" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Famille</th>
                            <th>Nombre d'enfants</th>
                            <th>Supprimer</th>
                            <th>Voir info</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Famille</th>
                            <th>Nombre d'enfants</th>
                            <th>Supprimer</th>
                            <th>Voir info</th>
                        </tr>
                    </tfoot>
                    
                    <tbody>
                        <?php foreach ($query->result() as $row): //pour chaque ligne de la requete?>
                            <tr class="text-center">

                                <td><?php echo $row->nom_famille; ?></td>
                                <td><?php echo $row->nb_enfants; ?></td>
                                <td><a href="<?php echo base_url("admin_control/supprimer_famille/" . $row->id_famille); ?>"><i class="fa fa-2x fa-trash"></i></a></td>
                                <td><a href="<?php echo base_url("admin_control/afficher_tuille_info/" . $row->id_famille); ?>"><i class="fa fa-2x fa-search"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php endif; ?>
            <a href="<?php echo base_url('admin_control/ajouter_famille'); ?>" class="btn btn-success pull-right">Ajouter Famille</a>
        </div>
    </div>
</div>

<?php if ($affiche_tuille == 1): //gestion de l'affichage de la tuille ?>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title text-center"><span class="glyphicon glyphicon-info-sign"></span> Informations famille </h3>
            </div>
            <div class="panel-body">

                <p><strong>Responsable : </strong></p>
                <p><?php echo $infos_famille['resp_1'][0]->nom . " " . $infos_famille['resp_1'][0]->prenom; ?></p>
                <p><strong>Adresse: <?php echo $infos_famille['resp_1'][0]->adresse . " " . strtoupper($infos_famille['resp_1'][0]->ville) ?></strong></p>
                <p><strong>Téléphone : <?php echo $infos_famille['resp_1'][0]->tel_mobile ?></strong></p>

                <p><strong>Enfants: </strong></p>
                <form role="form" method="post" action="<?php echo base_url('admin_control/supprimer_enfant'); ?>">
                    <fieldset>
                        <table class="table table-hover table-responsive table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Classe</th>
                                    <th>Régime alimentaire</th>
                                    <th>Allergies</th>
                                    <th>Type d'inscription</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>



                            <?php
                            if ($infos_famille['enfants'] != null):
                                foreach ($infos_famille['enfants'] as $row):
                                    ?>
                                    <tbody class="text-center">
                                        <tr>
                                            <td><?php echo $row->nom ?></td>
                                            <td><?php echo $row->prenom ?></td>
                                            <td><?php echo $row->niveau."  -  ".$row->nom_enseignant ?></td>
                                            <td><?php echo $row->regime_alimentaire ?></td>
                                            <td><?php echo $row->allergie ?></td>
                                            <td> <?php echo $row->type_inscription ?></td>
                                            <td><a href="<?php echo base_url("admin_control/supprimer_enfant/" . $row->id_enfant); ?>">
                                                    <i class="fa fa-2x fa-trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>



                            <?php endif; ?>
                        </table>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <?php





 endif;




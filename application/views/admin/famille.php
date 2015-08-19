<div class="row">

    <div class="panel panel-primary">
        <div class="panel-heading text-center descAuto" id="div_liste_famille">
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

<?php if ($affiche_tuille == 1): //gestion de l'affichage de la tuille ;?>
    <div class="row">
        <div class="panel panel-primary ">
            <div class="panel-heading descAuto" id="div_info_famille">
                <h3 class="panel-title text-center"><span class="glyphicon glyphicon-info-sign"></span> Informations famille </h3>
            </div>
            <div class="panel-body">

                <p><strong>Responsable : </strong></p>
                <p><?php echo $infos_famille['resp_1'][0]->nom . " " . $infos_famille['resp_1'][0]->prenom; ?></p>
                <p><strong>Adresse: </strong><br/><?php echo $infos_famille['resp_1'][0]->adresse . " <br/> " . strtoupper($infos_famille['resp_1'][0]->ville) ?></p>
                <p><strong>Mail: </strong><br/><?php echo $infos_famille['resp_1'][0]->mail ?></p>
                <p><strong>Téléphone portable:</strong><br/> <?php echo $infos_famille['resp_1'][0]->tel_mobile ?></strong></p>
                <p><strong>Téléphone travail:</strong> <br/><?php echo $infos_famille['resp_1'][0]->tel_travail ?></strong></p>

                <form method="post" class='pull-left' role="form" id="form_modif_infos_famille" action="<?php echo base_url('admin_control/edit_famille') ?> "> 
                    <input type="hidden" name="id_famille" value="<?php echo $infos_famille['resp_1'][0]->id_famille ?>">
                    <button class='btn btn-success' type="submit" form="form_modif_infos_famille" >Modifier les informations</button>
                </form>

                <br/>
                <br/>

                <form method="post" class='pull-left' role="form" id="form_chg_mdp_famille" action="<?php echo base_url('admin_control/changement_mdp_famille') ?> "> 
                    <input type="hidden" name="id_famille" value="<?php echo $infos_famille['resp_1'][0]->id_famille ?>">
                    <button class='btn btn-warning' type="submit" form="form_chg_mdp_famille" >Attribuer un nouveau mot de passe</button>
                </form>

                <br/>
                <br/>
                <br/>

                <p><strong>Enfants: </strong></p>

                <table id="liste_enfant_famille" class="table table-striped table-bordered">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Régime alimentaire</th>
                            <th>Allergies</th>
                            <th>Type d'inscription</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Régime alimentaire</th>
                            <th>Allergies</th>
                            <th>Type d'inscription</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </tfoot>
                    <tbody >
                        <?php
                        if ($infos_famille['enfants'] != null):
                            foreach ($infos_famille['enfants'] as $row):
                                ?>

                                <tr>
                                    <td><?php echo $row->nom ?></td>
                                    <td><?php echo $row->prenom ?></td>
                                    <td><?php echo $row->niveau . "  -  " . $row->nom_enseignant ?></td>
                                    <td><?php echo $row->regime_alimentaire ?></td>
                                    <td><?php echo $row->allergie ?></td>
                                    <td> <?php echo $row->type_inscription ?></td>
                                    <td><a href="<?php echo base_url("admin_control/modifier_info_enfant/" . $row->id_enfant); ?>">
                                            <i class="fa fa-2x fa-pencil"></i></a></td>
                                    <td><a href="<?php echo base_url("admin_control/supprimer_enfant/" . $row->id_enfant); ?>">
                                            <i class="fa fa-2x fa-trash"></i></a></td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <?php
















 endif;




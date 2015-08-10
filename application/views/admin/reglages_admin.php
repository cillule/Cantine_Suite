<div class="row">
    <div class="panel panel-primary descAuto" id="div_modif_vacances">
        <div class="panel-heading text-center">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Modification des Vacances Scolaires</a>
                <i class="fa fa-sun-o"></i>
            </div>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">

                <form class="form-horizontal" role="form" method="post" action="<?php echo base_url("admin_control/sauvegarder_vacances_scolaires") ?>">
                    <fieldset>
                        <p><strong>Vacances de la Toussaint:</strong></p>
                        <div class="form-group">

                            <label  class="control-label col-md-2" for="debut_toussaint">Début: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="debut_toussaint" value= "<?php echo $vacances["vac1"]["debut"]; ?>"/>
                            </div>
                            <label class="control-label col-md-2" for="fin_toussaint">Fin: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="fin_toussaint" value= "<?php echo $vacances["vac1"]["fin"]; ?>"/>
                            </div>
                        </div>

                        <p><strong>Vacances de Noël:</strong></p>
                        <div class="form-group">

                            <label  class="control-label col-md-2">Début: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="debut_noel" value= "<?php echo $vacances["vac2"]["debut"]; ?>">
                            </div>
                            <label class="control-label col-md-2">Fin: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="fin_noel" value= "<?php echo $vacances["vac2"]["fin"]; ?>">
                            </div>
                        </div>

                        <p><strong>Vacances d'hiver:</strong></p>
                        <div class="form-group">

                            <label  class="control-label col-md-2">Début: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="debut_hiver" value= "<?php echo $vacances["vac3"]["debut"]; ?>">
                            </div>
                            <label class="control-label col-md-2">Fin: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="fin_hiver" value= "<?php echo $vacances["vac3"]["fin"]; ?>">
                            </div>
                        </div>

                        <p><strong>Vacances de printemps:</strong></p>
                        <div class="form-group">

                            <label  class="control-label col-md-2">Début: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="debut_printemps" value= "<?php echo $vacances["vac4"]["debut"]; ?>">
                            </div>
                            <label class="control-label col-md-2">Fin: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="fin_printemps" value= "<?php echo $vacances["vac4"]["fin"]; ?>">
                            </div>
                        </div>


                        <p><strong>Vacances d'été:</strong></p>
                        <div class="form-group">

                            <label  class="control-label col-md-2">Début: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="debut_ete" value= "<?php echo $vacances["vac5"]["debut"]; ?>">
                            </div>
                            <label class="control-label col-md-2">Fin: </label>
                            <div class="col-md-3">
                                <input type="date" class="form-control " name="fin_ete" value= "<?php echo $vacances["vac5"]["fin"]; ?>">
                            </div>
                        </div>
                        <input type="submit" name="sauvegarder" class="btn btn-success  pull-right"  value="Enregistrer Changements">
                    </fieldset>
                </form>

            </div>
        </div>
    </div>

    <div class="panel panel-primary descAuto" id="div_liste_classes">
        <div class="panel-heading text-center">
            <div class="panel-title">

                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Liste des classes</a>
                <i class="fa fa-pencil-square"></i>

            </div>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
            
            <div class="panel-body">
                <table class="table table-hover table-responsive table-bordered text-center">
                    <tr class="info">

                        <th>Nom enseignant</th>
                        <th>Niveau</th>
                        <th>Supprimer</th>


                    </tr>
                    <?php foreach ($classes as $row): ?>
                        <tr>          
                            <td><?php echo $row->nom_enseignant; ?></td>
                            <td><?php echo $row->niveau; ?></td>
                            <td>
                                <a href="<?php echo base_url("admin_control/editer_classe/" . $row->id_classe); ?>"><i class="fa fa-2x fa-pencil"></i></a>
                                <a href="<?php echo base_url("admin_control/supprimer_classe/" . $row->id_classe); ?>"><i class="fa fa-2x fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <form role="form" class="form-inline" method="post" action="<?php echo base_url('admin_control/enregistrer_classe'); ?>">

                    <fieldset>
                        <input type="text" class="form-control" name="InputNomEnseignant" name="nom" placeholder="Nom de l'enseignant">
                        <input type="test" name="InputNiveau" class="form-control" placeholder="Niveau" required>
                        <input type="submit" name="sauvegarder" class="btn btn-success form-control"  value="Ajouter">
                    </fieldset>

                </form>
            </div>

        </div>
    </div>
    
    
        <div class="panel panel-primary descAuto" id="div_chgment_admin">
            <div class="panel-heading text-center">
                <h3 class="panel-title text-capitalize"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3"> Changement mot de passe côté admin</a> <i class="fa fa-shield"></i></h3>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">     

                    <form role="form" method="post" action="<?php echo base_url('admin_control/changer_mdp'); ?>">
                        <fieldset>
                            <div class="form-group">    
                                <label class="control-label" for="password_1">Entrer votre nouveau mot de passe: </label>
                                <input type="password" name="password_1" class="form-control"  minlength="8" maxlength="16"  required="true">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password_2">Répéter le mot de passe: </label>
                                <input type="password" name="password_2"  class="form-control"  minlength="8" maxlength="16" required="true">
                            </div>
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Valider">
                        </fieldset>
                    </form>
                    
                </div>
            </div>
        </div>

</div>







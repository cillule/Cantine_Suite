<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary descAuto" id="div_modif_tarifs">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Modification des tarifs <i class="fa fa-euro"></i></h3>
            </div>
            <div class="panel-body">
             
                <form role="form" method="post" action="<?php echo base_url("admin_control/sauvegarder_tarifs") ?>">
                    <fieldset>
                        <div class="form-group">
                            <label for="prixAetM">Prix d'un repas avec inscription annuelle</label>
                            <input type="text" class="form-control" name="prixAetM" value="<?php echo $liste_tarif["prixAetM"] ?>">
                        </div>

                        <div class="form-group">
                            <label for="prixHebdo" class="control-label">Prix d'un repas avec inscription hebdommadaire</label>
                            <input type="text" class="form-control" name="prixHebdo" value="<?php echo $liste_tarif["prixHebdo"] ?>">
                        </div>

                        <div class="form-group">
                            <label for="prixHD" class="control-label">Prix d'un repas avec inscription hors délai</label>
                            <input type="text" class="form-control" name="prixHD" value="<?php echo $liste_tarif["prixHD"] ?>">
                        </div>

                        <div class="form-group">
                            <label for="prixPasInscrit" class="control-label">Prix d'un repas avec inscription lors du pointage</label>
                            <input type="text" class="form-control" name="prixPasInscrit" value="<?php echo $liste_tarif["prixPasIns"] ?>">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success pull-right" value="Sauvegarder">
                        </div>


                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <?php if ($query2->num_rows() > 0): ?> 
        <div class="col-md-6">
            <div class="panel panel-primary descAuto" id="div_documents">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Gestion des documents <i class="fa fa-folder-open"></i></h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo base_url('admin_control/affiche_liste_document'); ?>">
                        <fieldset>
                            <table class="table table-hover table-responsive table-bordered">
                                <tr class="info">
                                <thead>
                                <th>Document</th>
                                <th>Supprimer</th>
                                </thead>
                                </tr>
                                <?php foreach ($query2->result() as $row): ?>
                                    <tr class="text-center">
                                        <td><a href="<?php echo '../assets/documents/' . $row->nom_document; ?>" target="_blank"><?php echo $row->nom_document; ?></a></td>
                                        <td><a href="<?php echo base_url("admin_control/supprimer_document/" . $row->id_document); ?>" onclick=" return deleteConfirm()" title="Supprimer"><i class="fa fa-2x fa-trash"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>
                        </fieldset>
                    </form>

                <?php endif; ?>

                <form action="<?php echo base_url("admin_control/ajouter_document") ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <fieldset>
                        <input class="filestyle" data-buttonBefore="true" data-buttonName="btn-primary" id="file-admin" type="file" name="fichier"/>
                        <br>
                        <input class="btn btn-success pull-right" type="submit" value="importer" />
                    </fieldset>

                </form>

            </div>
        </div>
    </div>

</div>
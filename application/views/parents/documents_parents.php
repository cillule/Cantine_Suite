<div class='row'>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Tarifs des repas <i class="fa fa-user"></i></div>
            </div>
            <div class="panel-body">
                        <?php $row = $query->result(); ?> 

                        <form role="form" method="post" action="<?php echo base_url('parents_control/affiche_documents'); ?>">
                            <fieldset>
                                <table class="table table-hover table-responsive table-bordered">

                                    <?php foreach ($query->result() as $row): ?>
                                        <tr class="text-center">
                                            <td>Anuelle</td>
                                            <td><?php echo $row->prixAetM ?> €</td> 
                                        </tr>
                                        <tr class="text-center">
                                            <td>Hebdomadaire</td>
                                            <td><?php echo $row->prixHebdo ?> €</td> 
                                        </tr>
                                        <tr class="text-center">
                                            <td>Hors délai</td>
                                            <td><?php echo $row->prixHD ?> €</td> 
                                        </tr>
                                        <tr class="text-center">
                                            <td>Pas Inscrit</td>
                                            <td><?php echo $row->prixPasInscrit ?> €</td> 
                                        </tr>
                                    <?php endforeach; ?>

                                </table>
                            </fieldset>
                        </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Documents et informations parents <i class="fa fa-user"></i></div>
            </div>
            <div class="panel-body">
                    <?php if ($query2->num_rows() > 0): ?> 

                            <form role="form" method="post" action="<?php echo base_url('parents_control/affiche_documents'); ?>">
                                <fieldset>
                                    <table class="table table-hover table-responsive table-bordered">
                                        <tr class="info">
                                        <thead>
                                        <th>Document</th>
                                        <th>Télécharger</th>
                                        </thead>
                                        </tr>
                                        <?php foreach ($query2->result() as $row): ?>
                                            <tr class="text-center">
                                                <td><a href="<?php echo '../assets/documents/' . $row->nom_document; ?>" target="_blank"><?php echo $row->nom_document; ?></a></td>
                                                <td><a href="<?php echo base_url("parents_control/telecharger_document/" . $row->nom_document); ?>" title="Telecharger"><i class="fa fa-2x fa-download"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </table>
                                </fieldset>
                            </form>
                        <?php endif; ?>   
            </div>
        </div>
    </div>
</div>
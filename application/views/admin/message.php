<div class="row">
    <div class="panel panel-primary">
        <div class="panel-heading text-center">
            <h3 class="panel-title">Formulaire de contact <i class="fa fa-send"></i></h3>
        </div>
        <div class="panel-body">
            <form role="form" method="POST" action="<?php echo base_url('admin_control/envoi_message'); ?>">
                <fieldset>
                Selectionnez la(les) famille(s) à contacter :</br>
                <?php
                foreach ($query->result() as $row) {
                    ?>
                    <input type="checkbox" name="familleselect[]" value="<?php echo $row->id_resp_1; ?>"> <?php echo $row->nom_famille; ?><br>
                    <?php
                }
                ?>

                <br>

                
                    <div class="form-group">
                        <label for="InputIntitule">Intitule</label>
                        <input required type="text" class="form-control" id="InputIntitule" name="Intitule" placeholder="Entrer l'intitule">
                    </div>
                    <div class="form-group">
                        <label for="InputContenu">Contenu</label>
                        <textarea required maxlength="350" class="form-control" id="InputContenu" name="Contenu" placeholder="Contenu du message"></textarea>
                    </div>
                    <input type="submit" name="Envoyer" class="btn btn-success pull-right"  value="Envoyer">
                </fieldset>

            </form>
        </div>
    </div>
    <?php foreach ($message->result() as $row): ?>
        <div class="panel panel-default">
            <div class="panel-body">
				<div class="pull-left">
					<b>Message de <?php echo $row->nom_famille; ?></b><br>
					<?php echo $row->contenu; ?>
				</div>
				<div class="pull-right">
                    <a href="<?php echo base_url('admin_control/supprimer_message/' . $row->id_message); ?>"<i class="fa fa-2x fa-trash"></i></a>
				</div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

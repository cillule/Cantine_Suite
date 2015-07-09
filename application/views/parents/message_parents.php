<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form role="form" method="POST" action="<?php echo base_url('parents_control/envoimessage'); ?>">
            <fieldset>
                <div class="form-group">
                    <label for="InputIntitule">Intitule</label>
                    <input required type="text" class="form-control" id="InputIntitule" name="Intitule" placeholder="Entrer l'intitule">
                </div>
                <div class="form-group">
                    <label for="InputContenu">Contenu</label>
                    <textarea required id="textarea" maxlength="350" class="form-control" id="InputContenu" name="Contenu" placeholder="Contenu du message"></textarea>
                </div>
                <input type="submit" name="Envoyer" class="btn btn-success pull-right"  value="Envoyer">
            </fieldset>
        </form>
        <?php foreach ($message->result() as $row) : ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <b>Message de l'admin : </b>
                <?php echo $row->contenu; ?> <br>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
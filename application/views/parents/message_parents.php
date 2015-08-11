<div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Envoi de message <i class="fa fa-user"></i></div>
            </div>
            <div class="panel-body">
                <form role="form" method="POST" action="<?php echo base_url('parents_control/envoi_message'); ?>">
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
            </div>
        </div>
    <?php foreach ($liste_messages as $key => $message): ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="pull-left">
                        <b>Message de la Cantine</b><br>
                        <?php echo $message->contenu; ?>
                </div>
                <div class="pull-right">
                    <a href="<?php echo base_url('parents_control/supprimer_message/' . $message->id_message); ?>"<i class="fa fa-2x fa-trash"></i></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
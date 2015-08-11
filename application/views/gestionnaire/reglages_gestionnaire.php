<div class="row>"
<div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Changer Mot de Passe <i class="fa fa-shield"></i></div>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo base_url('gestionnaire_control/sauvegarder_mdp'); ?>">
                    <fieldset>
                        <div class="form-group">    
                            <label class="control-label" for="password_1">Entrer votre nouveau mot de passe: </label>
                            <input type="password" name="password_1" class="form-control"  minlength="8" maxlength="16" pattern=".{0}|.{8,16}" required title="Mot de passe entre 8 et 16 caractères">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password_2">Répéter le mot de passe: </label>
                            <input type="password" name="password_2"  class="form-control"  minlength="8" maxlength="16" pattern=".{0}|.{8,16}" required title="Mot de passe entre 8 et 16 caractères">
                        </div>
                        <br/>
                        <div class="alert-warning"><?php echo form_error('password_2'); ?></div>

                        <input type="submit" name="submit" class="btn btn-success pull-right" value="Valider">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

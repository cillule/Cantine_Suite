<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Informations Responsable <i class="fa fa-user"></i></div>
            </div>
            <div class="panel-body">

                <form role="form" method="post" action="<?php echo base_url('parents_control/sauvegarder_infos_famille'); ?>">
                    <fieldset>
                        <div class="form-group">    
                            <label class="control-label" for="dname">Nom: </label>
                            <input type="text" name="dname" class="form-control" value="<?php echo $query->nom ?>" placeholder="Nom" required="false"  disabled>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dprenom">Prenom: </label>
                            <input type="text" name="dprenom" class="form-control" value="<?php echo $query->prenom ?>" placeholder="Prenom" required="false"  disabled>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="demail">Mail: </label>
                            <input type="email" name="demail" class="form-control" value="<?php echo $query->mail ?>" placeholder="Email"  required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dmobile">Téléphone Mobile: </label>
                            <input type="text" name="dmobile" class="form-control" value="<?php echo $query->tel_mobile ?>" placeholder="Numéro de téléphone" required="true" data-mask="99-99-99-99-99">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dtel_travail">Téléphone Bureau: </label>
                            <input type="text" name="dtel_travail" class="form-control" value="<?php echo $query->tel_travail ?>" placeholder="Numéro de téléphone" required="true" data-mask="99-99-99-99-99">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="daddress">Adresse: </label>
                            <input type="text" name="daddress" class="form-control" value="<?php echo $query->adresse ?>"  placeholder="Adresse" required="true">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="dville">Ville: </label>
                            <input type="text" name="dville" class="form-control" value="<?php echo $query->ville ?>" required="true">
                        </div>
                        <input type="submit" name="submit" class="btn btn-success pull-right" value="Valider">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <div class="panel-title">Changer Mot de Passe <i class="fa fa-shield"></i></div>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo base_url('parents_control/changer_mdp'); ?>">
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
                        <input type="submit" name="submit" class="btn btn-success pull-right" value="Valider">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>









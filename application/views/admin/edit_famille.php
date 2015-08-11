<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading text-center descAuto" id="div_edit_famille">
                <div class="panel-title">Informations de <?php echo $infos_famille['resp_1'][0]->prenom . " " . $infos_famille['resp_1'][0]->nom ?> <i class="fa fa-user"></i></div>
            </div>
            <div class="panel-body">
                <form role="form" method="post" action="<?php echo base_url('admin_control/enregistrer_infos_responsable'); ?>">
                    <fieldset>
                        <input type="hidden" name="did_famille" value="<?php echo $infos_famille['resp_1'][0]->id_famille ?>">
                        <input type="hidden" name="did_resp" value="<?php echo $infos_famille['resp_1'][0]->id_responsable ?>">
                        <div class="form-group">    
                            <label class="control-label" for="dnom">Nom: </label>
                            <input type="text" name="dnom" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->nom ?>" placeholder="Nom" required="true" >
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dprenom">Prenom: </label>
                            <input type="text" name="dprenom" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->prenom ?>" placeholder="Prenom" required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="demail">Mail: </label>
                            <input type="email" name="demail" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->mail ?>" placeholder="Email"  required="true">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dmobile">Téléphone Mobile: </label>
                            <input type="text" name="dmobile" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->tel_mobile ?>" placeholder="Numéro de téléphone" required="false" data-mask="99-99-99-99-99">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="dtel_travail">Téléphone Bureau: </label>
                            <input type="text" name="dtel_travail" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->tel_travail ?>" placeholder="Numéro de téléphone" required="false" data-mask="99-99-99-99-99">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="daddress">Adresse: </label>
                            <input type="text" name="daddress" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->adresse ?>"  placeholder="Adresse" required="false">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="dville">Ville: </label>
                            <input type="text" name="dville" class="form-control" value="<?php echo $infos_famille['resp_1'][0]->ville ?>" required="false">
                        </div>
                        <input type="submit" name="submit" class="btn btn-success pull-right" value="Valider">

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Edition de classe <i class="fa fa-user"></i></h3>
            </div>
            <div class="panel-body">
                <form  role="form" method="post" action="<?php echo base_url("admin_control/enregistrer_classe") ?>">
                    <fieldset>
                        <input name="IdClasse" type="hidden" value="<?php echo $classe[0]->id_classe; ?>">
                        <div class="form-group">
                            <label for="InputNomEnseignant">Enseignant</label>
                            <input type="text" class="form-control" name="InputNomEnseignant" id="InputNomEnseignant" 
                                   value="<?php echo $classe[0]->nom_enseignant; ?>"
                                   placeholder="<?php echo $classe[0]->nom_enseignant; ?>">
                        </div>

                        <div class="form-group">
                            <label for="InputNiveau">Niveau</label>
                            <input type="text" class="form-control" name="InputNiveau" id="InputNiveau" 
                                   value="<?php echo $classe[0]->niveau; ?>"
                                   placeholder="<?php echo $classe[0]->niveau; ?>">
                        </div>

                        <input type="submit" name="sauvegarder" class="btn btn-success form-control"  value="Sauvegarder">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
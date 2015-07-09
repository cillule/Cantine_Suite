<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Ajout d'une famille <i class="fa fa-user"></i></h3>
            </div>
            <div class="panel-body">
                <form  role="form" method="post" action="<?php echo base_url("admin_control/sauvegarder_famille") ?>">
                    <fieldset>
                        <div class="form-group">
                            <label for="InputNom">Nom</label>
                            <input type="text" class="form-control" id="InputNom" name="nom" placeholder="Entrer le nom de la famille">
                        </div>

                        <div class="form-group">
                            <label for="Inputamil">Mail</label>
                            <input type="email" name="mail" id="InputMail" class="form-control" placeholder="Adresse mail" required>
                        </div>

                        <input type="submit" name="sauvegarder" class="btn btn-success form-control"  value="Sauvegarder">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
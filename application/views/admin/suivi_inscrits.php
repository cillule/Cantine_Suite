<div class="row">
  
    <div class="panel panel-primary text-center">
        <div class="panel-heading">
            <h1 class="panel-title">Tableau suivi des inscrits <i class="fa fa-user"></i></h1>
        </div>

        <form role="form" method="post" action="<?php echo base_url("admin_control/generer_tableau_suivi") ?>">
            <fieldset>
                <div class="panel-body">
                    <label for="date_suivi_inscrit">Sélectionnez le mois et l'année : </label>
                    <div class="input-group">
                        <input required type="text" id="date_suivi_inscrit" name="date_suivi_inscrit" class="form-control"/>
                        <span class="input-group-btn">
                            <input type="submit" name="generer_excel" class="btn btn-success"  value="Générer Excel">
                        </span>
                    </div>
                </div>
            </fieldset>
        </form>

    </div>

    <div class="panel panel-primary text-center">
        <div class="panel-heading">
            <h1 class="panel-title">Feuille de présence <i class="fa fa-thumb-tack"></i></h1>
        </div>

        <form role="form" method="post" action="<?php echo base_url("admin_control/generer_feuille_presence") ?>">
            <fieldset>
                <div class="panel-body">
                    <label for="date_suivi_presence">Sélectionnez un jour: </label>
                    <div class="input-group">
                        <input required type="text" id="date_suivi_presence" name="date_suivi_presence" class="form-control"/>
                        <span class="input-group-btn">
                            <input type="submit" name="generer_excel_presence" class="btn btn-success"  value="Générer Excel">

                        </span>
                    </div>

            </fieldset>
        </form>
    </div>
</div>

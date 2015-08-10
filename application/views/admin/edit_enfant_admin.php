<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary descAuto" id="div_modif_enfant">
            <div class="panel-heading text-center">
                <div class="panel-title">Modifier les informations de <?php echo $infos_enfant->prenom." ".$infos_enfant->nom;  ?> <i class="fa fa-pencil-square"></i></div>
            </div>
            <div class="panel-body">
                <form  role="form" method="post" action="<?php echo base_url("admin_control/sauvegarder_infos_enfant"); ?>">
                    <fieldset>
                         <input type="hidden" name="id_enfant" value="<?php echo $infos_enfant->id_enfant ?>">
                         <input type="hidden" name="id_famille" value="<?php echo $infos_enfant->id_famille ?>">
                        <div class="form-group">
                            <label for="InputNom">Nom</label>
                            <input type="text" class="form-control" id="InputNom" name="nom_enfant" value="<?php echo $infos_enfant->nom ?>" placeholder="Entrer le nom de l'enfant" required>
                        </div>
                        <div class="form-group">
                            <label for="InputPrenom">Prenom</label>
                            <input type="text" class="form-control" id="InputPrenom" name="prenom_enfant" value="<?php echo $infos_enfant->prenom ?>" placeholder="Entrer le prenom de l'enfant" required>
                        </div>
                        <div class="form-group">
                            <label for="classe_enfant">Classe</label>
                            <select id="select_classe" name="classe_enfant" class="selectpicker form-control" value="<?php echo $infos_enfant->id_classe  ?>" data-style="btn-warning" required>
                                <?php
                                foreach ($liste_classe as $classe) {
                                    echo "<option value=" . $classe->id_classe . ">";
                                    echo $classe->niveau . "  -  " . $classe->nom_enseignant;
                                    echo "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select_regime">Régime alimentaire</label>
                            <select id="select_regime" name="select_regime" class="selectpicker form-control" data-style="btn-warning" required>
                                <option value="Végétarien">Végétarien</option>
                                <option value="Sans porc">Sans porc</option>
                                <option value="Rien de particulier" selected>Rien de particulier</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="InputAllergie">Allergie</label>
                            <textarea maxlength="250" class="form-control textarea"  name="allergie" value="<?php echo $infos_enfant->allergie ?>"><?php echo $infos_enfant->allergie ?></textarea>
                        </div>
                        <input type="submit" name="sauvegarde" class="btn btn-success pull-right"  value="Sauvegarder">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
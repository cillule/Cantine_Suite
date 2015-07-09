<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form  role="form" method="post" action="<?php echo base_url("parents_control/sauvegarder_enfant"); ?>">
            <fieldset>
                <div class="form-group">
                    <label for="InputNom">Nom</label>
                    <input type="text" class="form-control" id="InputNom" name="nom" placeholder="Entrer le nom de l'enfant">
                </div>
                <div class="form-group">
                    <label for="InputPrenom">Prenom</label>
                    <input type="text" class="form-control" id="InputPrenom" name="prenom" placeholder="Entrer le prenom de l'enfant">
                </div>
                <div class="form-group">
                    <label for="select_classe">Classe</label>
                    <select id="select_classe" name="select_classe" class="selectpicker form-control" data-style="btn-warning">
                    <?php foreach($liste_classe as $classe){ 
                       echo "<option value=".$classe->id_classe.">";
                       echo  $classe->niveau ."  -  ".$classe->nom_enseignant;
                       echo "</option>";
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="select_regime">Régime alimentaire</label>
                    <select id="select_regime" name="select_regime" class="selectpicker form-control" data-style="btn-warning">
                        <option value="Végétarien">Végétarien</option>
                        <option value="Sans porc">Sans porc</option>
                        <option value="Rien de particulier" selected>Rien de particulier</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="InputAllergie">Allergie</label>

                    <textarea maxlength="250" class="form-control textarea" id="InputAllergie" name="allergie" placeholder="Allergie"></textarea>
                </div>

                <div class="form-group">
                    <label for="select_abonnement">Type d'inscription: </label>
                    <select id="select_abonnement" name="select_abonnement" class="selectpicker form-control" data-style="btn-warning">
                        <option value="Annuelle" id="inscrip_annuelle" >Annuelle</option>
                        <option value="Hebdomadaire" id="inscrip_hebdo">Hebdomadaire</option>
                       
                    </select>
                </div>

                <div id="schema_annuel" class="form-group">

                    <table class='table-bordered table table-hover table-responsive '>
                        <tr class="info">
                            <th>Lundi</th>
                            <th>Mardi</th>
                            <th>Mercredi</th>
                            <th>Jeudi</th>
                            <th>Vendredi</th>
                        </tr>

                        <tr class='text-center'>
                            <?php for ($i = 0; $i < 5; $i++) {
                                ?>
                                <td> <input type="checkbox" name="schema_inscrip[]" value=<?php echo $i; ?>></td>
                                <?php
                            }
                            ?>
                        </tr>
                    </table>
                </div>

                <div id="schema_hebdo" class="form-group hidden">
                    <p><strong>Vous avez opté pour une inscription Hebdomadaire</strong></p>  
                </div>

                <input type="submit" name="sauvegarde" class="btn btn-success pull-right"  value="Sauvegarder">
            </fieldset>
        </form>
    </div>
</div>





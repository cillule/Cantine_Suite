<?php if ($query->num_rows() > 0): //si on a déja des enfants inscrits                                                                                                                                 ?>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <div class="panel-title">Liste des enfants <i class="fa fa-user"></i></div>
                </div>
                <div class="panel-body">
                    <table class="table table-hover table-responsive table-bordered">
                        <tr class="info ">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Régime alimentaire</th>
                            <th>Allergies</th>
                            <th>Type d'inscription</th>
                            <th>Gérer inscription</th>

                        </tr>
                        <?php foreach ($query->result() as $row): //pour chaque ligne de la requete?>
                            <tr class="text-center">
                                <td><?php echo $row->nom; ?></td>
                                <td><?php echo $row->prenom; ?></td>
                                <td><?php echo $row->niveau . " - " . $row->nom_enseignant; ?></td>
                                <td><?php echo $row->regime_alimentaire; ?></td>
                                <td><?php echo $row->allergie; ?></td>
                                <td><?php echo $row->type_inscription; ?></td>
                                <td>
                                    <a href="<?php echo base_url("parents_control/afficher_Calendrier_Inscriptions/" . $row->id_enfant); ?>"  title="Voir_info">
                                        <i class="fa fa-2x fa-calendar"></i>
                                    </a>
                                </td>

                            <input type="hidden" name='id_enfant' value="<?php echo $row->id_enfant; ?>"/>


                            </tr>

                        <?php endforeach; ?>

                    </table>


                <?php endif; ?>

                <a href="<?php echo base_url('parents_control/ajouter_enfants'); ?>" class="btn btn-success pull-right">Ajouter Enfant</a>
                <br/>
                <?php if ($affiche_calendrier == 1): //gestion de l'affichage de la tuille ?>
                    <form method="post" role="form" id='form_calendrier' action="<?php echo base_url("parents_control/enregistrerInscriptionsRepas/" . $id_enfant); ?> ">

                        <?php
                        $i = 0;
                        $now = new DateTime;
                        foreach ($elem_calendrier["dates"]["annees"] as $year):
                            foreach ($elem_calendrier["dates"][$year] as $m => $jours):
                                ?>

                                <div class ="month" id="mois<?php echo $m ?>">
                                    <h2><?php echo $elem_calendrier['mois'][$m - 1] . " - " . $year ?></h2>
                                    <table class="table  table-responsive table-bordered">
                                        <thead>
                                            <tr>
                                                <?php
                                                foreach ($elem_calendrier["jours"] as $jour):
                                                    ?>
                                                    <th>
                                                        <?php echo substr($jour, 0, 3) ?>
                                                    </th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php
                                                $end = end($jours);
                                                foreach ($jours as $d => $w):
                                                    ?>
                                                    <?php if ($d == 1 and $w != 1): ?>
                                                        <td colspan="<?php
                                                        echo $w - 1;
                                                        ?>"> </td>
                                                        <?php endif; ?>

                                                    <?php
                                                    if (new DateTime($year . "-" . $m . "-" . $d) > $now) {//
                                                        $type = $elem_calendrier["dates"]['type'][$i];
                                                        $array_to_post = serialize(array("date" => "2015" . "-" . $m . "-" . $d, "type" => $type));

                                                        switch ($type) {

                                                            case 0://l'enfant n'est pas inscrit mais le jour est dans les délais
                                                                //cellule blanche + checkable
                                                                echo "<td>";
                                                                echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "' >";
                                                                echo $d;
                                                                echo "</td>";
                                                                break;
                                                            case 1:// l'enfant est inscrit et le jour est dans les délais
                                                                //cellule verte claire + checkable
                                                                echo "<td style='background-color: #01FA3B'>";
                                                                echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "' checked >";
                                                                echo $d;
                                                                echo "</td>";
                                                                break;
                                                            case 2://l'enfant est inscrit mais le jour n'est pas dans les délais 
                                                                //cellule verte foncée non cheackable
                                                                echo "<td style='background-color: #00A131'>";
                                                                echo "<input type='hidden' name='checkbox[]' value='" . $array_to_post . "' checked >";
                                                                echo $d;
                                                                echo "</td>";
                                                                break;
                                                            case 3://l'enfant n'est pas inscrit et le jour n'est pas dans les délais 
                                                                //cellule orange checkable
                                                                echo "<td style='background-color: #FAB801'>";
                                                                echo "<input type='checkbox' name='checkbox_HD[]' value='" . $array_to_post . "' >";
                                                                echo $d;
                                                                echo "</td>";
                                                                break;
                                                            case 4://le jour est pendant le week end ou les vacances
                                                                //cellule grisée non checkable
                                                                echo "<td style='background-color: #A2B5BF'>";
                                                                echo $d;
                                                                echo '</td>';
                                                                break;

                                                            default:
                                                                break;
                                                        }
                                                    } else {
                                                        echo "<td>";
                                                        echo $d;
                                                        echo "</td>";
                                                    } $i++;
                                                    ?> 
                                                    <?php if ($w == 7): ?>

                                                    </tr><tr>
                                                        <?php
                                                    endif;
                                                endforeach;
                                                if ($end != 7):
                                                    ?>

                                                    <td colspan="<?php echo 7 - $end; ?>"> </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            endforeach;
                        endforeach;
                        ?>
                        <button class='btn btn-success pull-right' type="submit" form="form_calendrier" id="bouton_enregistrer_inscrip" value="Submit">Enregistrer les changements</button>
                    <?php endif; ?>

                </form>

                <div id="popupconfirmation_inscription" title="Boîte de dialogue de base">


                    <p><strong>Une inscription Hors Délais va être effectuée. </strong>(zone orange)</p>
                    <p>Une fois, cette inscription validée, il vous sera impossible de la modifier</p>
                    <p>Etes vous sur de vouloir continuer ?</p>
                </div>


            </div>
        </div>
    </div>
</div>


<div class="row">

    <div class="panel panel-descAuto" id="div_cal_gestion_facture">
        <div class="panel-heading">
            <h3 class="panel-title"> <i class="fa fa-info-circle"></i> Repas pour le mois --  <?php echo$info_enfant['info_enfant']['prenom'] . "" . $info_enfant['info_enfant']['nom']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" role="form" id="calendrier_gestion_facturation"  action="<?php echo base_url("admin_control/modifer_facturation/" . $info_enfant['info_enfant']['id_enfant']); ?> "> 
                <input type="hidden" id="input_id_famille" value="<?php echo $info_enfant["id_famille"] ?>">

                <?php
                $i = 0;
                $now = new DateTime;

                foreach ($info_enfant["calendrier_inscrip"]["inscrip_enfant"]["dates"]["annees"] as $year):
                    foreach ($info_enfant["calendrier_inscrip"]["inscrip_enfant"]["dates"][$year] as $m => $jours):
                        ?>

                        <div class ="month" id="mois<?php echo $m ?>">
                            <h2><?php echo $info_enfant["calendrier_inscrip"]["inscrip_enfant"]['mois'][$m - 1] . " - " . $year ?></h2>
                            <table class="table  table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <?php
                                        foreach ($info_enfant["calendrier_inscrip"]["inscrip_enfant"]["jours"] as $jour):
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
                                            if (new DateTime($year . "-" . $m . "-" . $d) < $now) {//
                                                $type = $info_enfant["calendrier_inscrip"]["inscrip_enfant"]["dates"]['type'][$i];

                                                $array_to_post = serialize(array("date" => "2015" . "-" . $m . "-" . $d, "type" => $type));

                                                switch ($type) {
                                                    case 0://pas de repas
                                                        echo "<td>";
                                                        echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "'>";
                                                        echo $d;
                                                        echo "</td>";
                                                        break;
                                                    case 1://repas normal
                                                        //cellule verte 
                                                        echo "<td style='background-color: #3AF70A'>";
                                                        echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "'>";
                                                        echo $d;
                                                        echo "</td>";
                                                        break;
                                                    case 2://repas hors delais
                                                        //cellule orange 
                                                        echo "<td style='background-color: #F7C00A'>";
                                                        echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "' >";
                                                        echo $d;
                                                        echo "</td>";
                                                        break;
                                                    case 3://repas non inscrit
                                                        //cellule rouge
                                                        echo "<td style='background-color: #F7690A'>";
                                                        echo "<input type='checkbox' name='checkbox[]' value='" . $array_to_post . "' >";
                                                        echo $d;
                                                        echo '</td>';
                                                        break;

                                                    case 5://le jour est pendant le week end ou les vacances
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
                <button class='btn btn-success pull-right' type="submit" form="calendrier_gestion_facturation" id="bouton_enregistrer_inscrip" value="Submit">Enregistrer les changements</button>
            </form>
        </div>
    </div>
</div>



<div id="popupchoix_facturation" title="Modification repas ">

    <p>Choisissez le type de facturation à appliquer à la sélection</p>

</div>

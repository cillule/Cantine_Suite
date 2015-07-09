<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cantine</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker3.standalone.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-select.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-tour.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jasny-bootstrap.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.css') ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>"/>
    </head>
    <body>
        <header class="navbar navbar-static-top navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">Cantine</a>
                </div>
                <nav id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li id="famille_admin"> <a href="<?php echo base_url('admin_control/affiche_familles'); ?>">Familles <i class="fa fa-group"></i></a></li>
                        <li id="facture_admin"> <a href="<?php echo base_url('admin_control/affiche_facturation'); ?>">Facturation <i class="fa fa-file-text"></i></a></li>
                        <li id="suivi_admin"> <a href="<?php echo base_url('admin_control/suivi_inscrits'); ?>">Suivi des inscrits <i class="fa fa-thumb-tack"></i></a></li>
                        <li id="message_admin"> <a href="<?php echo base_url('admin_control/message'); ?>">Message <i class="fa fa-envelope"></i></a></li>
                        <li id="documents_admin"> <a href="<?php echo base_url('admin_control/affiche_documents'); ?>">Documents <i class="fa fa-folder-open"></i></a></li>
                        <li id="reglages_admin"> <a  href="<?php echo base_url('admin_control/reglages'); ?>">Reglages <i class="fa fa-wrench"></i></a></li>
                        <li id="aide_admin"> <a  href="<?php echo base_url('admin_control'); ?>">Aide <i class="fa fa-heart"></i></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo base_url('login_control/logout'); ?>">Déconnexion <i class="fa fa-power-off"></i></a></li>
                    </ul>
                </nav>
            </div>
        </header> 

        <div class="container"><?= $contents ?></div>

        <footer>
            <?php if ($this->session->flashdata('message') != null) { ?>
                <div class="alert alert-info alert-dismissible col-md-4 col-md-offset-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span class="glyphicon glyphicon-info-sign"></span>  <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </footer>

        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/typehead.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.fr.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-filestyle.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-maxlength.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-tour.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jasny-bootstrap.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/script.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.dataTables.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/dataTables.bootstrap.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/scriptGestionTableau.js"); ?>"></script>
    </body>
</html>

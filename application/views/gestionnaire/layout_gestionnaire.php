<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cantine</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-toggle.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css"/>
    </head>
    <body>
        <header class="navbar navbar-static-top navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"  data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo current_url(); ?>">Cantine</a>
                </div>
                <nav id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li id="famille_admin"> <a href="<?php echo base_url('gestionnaire_control/index'); ?>">Pointage <i class="fa fa-pencil"></i></a></li>
                        <li id="facture_admin"> <a href="<?php echo base_url('gestionnaire_control/affiche_tableau_suivi'); ?>">Suivi des inscrits <i class="fa fa-file-text"></i></a></li>
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
                <div class="alert alert-info alert-dismissible col-md-4 col-md-offset-6" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </footer>

        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/typehead.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-toggle.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.dataTables.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/dataTables.bootstrap.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/scriptPointage.js"); ?>"></script>
    </body>
</html>


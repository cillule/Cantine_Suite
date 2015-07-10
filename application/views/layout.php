<!DOCTYPE html>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cantine</title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/style.css"); ?>"/>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-select.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-tour.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jasny-bootstrap.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-datepicker3.standalone.min.css'); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap-toggle.min.css"); ?>"/>
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/tabletools/2.2.0/css/dataTables.tableTools.min.css"/>
    </head>
    <body>

        <?php 
            if($page == "admin"){
                require_once("menu/menu_admin.php");
            }else if($page == "parent"){
                require_once("menu/menu_parent.php");
            }else if($page == "gestionnaire"){
                require_once("menu/menu_gestionnaire.php");
            }else{
                require_once("menu/menu.php");
            }
        ?>
        <div class="container"><?= $contents ?></div>

        <footer>
            <?php if ($this->session->flashdata('message') != null) { ?>
                <div class="alert alert-info alert-dismissible col-md-4 col-md-offset-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $this->session->flashdata('message'); ?>
                </div>
            <?php } ?>
        </footer>

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/typehead.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-datepicker.fr.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-filestyle.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-select.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-maxlength.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-tour.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/jasny-bootstrap.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/script.js"); ?>"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-toggle.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/scriptPointage.js"); ?>"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.0/js/dataTables.tableTools.min.js"></script>
    </body>
</html>


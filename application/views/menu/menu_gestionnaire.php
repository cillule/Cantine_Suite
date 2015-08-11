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
                <li id="famille_gestionnaire"> <a href="<?php echo base_url('gestionnaire_control/index'); ?>">Pointage <i class="fa fa-pencil"></i></a></li>
                <li id="facture_gestionnaire"> <a href="<?php echo base_url('gestionnaire_control/affiche_tableau_suivi'); ?>">Suivi des inscrits <i class="fa fa-file-text"></i></a></li>
                <li id="reglages_gestionnaire"> <a href="<?php echo base_url('gestionnaire_control/reglages'); ?>">Réglages <i class="fa fa-wrench"></i></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo base_url('login_control/logout'); ?>">Déconnexion <i class="fa fa-power-off"></i></a></li>
            </ul>
        </nav>
    </div>
</header>


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

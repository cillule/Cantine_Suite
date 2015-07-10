<header class="navbar navbar-static-top navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url('parents_control'); ?>">Cantine</a>
                </div>
                <nav id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li id="famille_parents"> <a href="<?php echo base_url('parents_control/info_parents'); ?>" >Familles  <i class="fa fa-group"></i></a></li>
                        <li id="enfant_parents"> <a href="<?php echo base_url('parents_control/affiche_enfants'); ?>">Enfants <i class="fa fa-child"></i></a></li>
                        <li id="facture_parents"> <a href="<?php echo base_url('parents_control/affiche_factures'); ?>">Facturation <i class="fa fa-euro"></i></a></li>
                        <li id="document_parents"> <a href="<?php echo base_url('parents_control/affiche_documents'); ?>">Documents <i class="fa fa-folder-open"></i></a></li>
                        <li id="message_parents"> <a href="<?php echo base_url('parents_control/message'); ?>">Message <i class="fa fa-envelope"></i></a></li>
                        <li id="faq_parents"> <a href="<?php echo base_url('parents_control/affiche_faq'); ?>">FAQ <i class="fa fa-question"></i></a></li>
                        <li id="contact_parents"> <a href="<?php echo base_url('parents_control/contact'); ?>">Contacts <i class="fa fa-phone"></i></a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo base_url('login_control/logout'); ?>">Déconnexion <i class="fa fa-power-off"></i></a></li>
                    </ul>
                </nav>
            </div>
        </header> 


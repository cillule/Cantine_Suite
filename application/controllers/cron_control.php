<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Cron_Control extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {

        $this->cron_model->cron_gestion_facture();
       
    }

}

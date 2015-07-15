<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'responsable';

    public function userLogin($email, $mdp) {


        $result = $this->db->select('id_responsable, mdp, admin, gestionnaire')
                        ->from($this->table)
                        ->where('mail', $email)
                        ->get()->result();
       
        $mdp_1=password_hash($mdp, PASSWORD_DEFAULT);

  
        if (password_verify($mdp, $result[0]->mdp)  && !empty($result)) {
            return $this->db->select('id_responsable,admin, gestionnaire')
                            ->from($this->table)
                            ->where('mail', $email)
                            ->get()
                            ->result();
        } else {
            return array();
        }
    }

}

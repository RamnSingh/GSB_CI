<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    protected function _estUtilisateurConnecte(){
        if(!$this->session->userdata('utilisateur')){
                redirect('gsb/connecter', 'refresh');
        }
    }
    
    protected function  _estUtilisateurDeconnecte(){
        if($this->session->userdata('utilisateur')){
                redirect('gsb/index', 'refresh');
        }
    }
    
    protected function _estVisiteurConnecte(){
        if(!$this->session->userdata('utilisateur')['idType'] === 'V'){
                redirect('gsb/connecter', 'refresh');
        }
    }
    
    protected function _estComptableConnecte(){
        if(!$this->session->userdata('utilisateur')['idType'] === 'C'){
                redirect('gsb/connecter', 'refresh');
        }
    }
}
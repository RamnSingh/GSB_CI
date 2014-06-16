<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comptable extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
         $this->mois = sprintf("%04d%02d", date("Y"), date("m"));
            
            // Inclus une librarie layout
            $this->load->library("Layout", "layout");
            
            //On inclus deux fichiers qui nous permet de communiquer qvec la base de donne en toute securite
            $this->load->model("fichesFrais_db", 'fichesFrais');
            $this->load->model("fichesFraisHorsForfait_db", 'fichesFraisHorsForfait');
    }
    
    
    public function getTousLesMois(){
        $idVisiteur = $this->input->post('idVisiteur',true);
        
        $tousLesMois = $this->fichesFrais->getTousLesMoisFicheCloturee($idVisiteur);
        
        if(is_array($tousLesMois)){
            $baliseSelect = $this->_creerBaliseSelect($tousLesMois);
            echo $baliseSelect;
        }
    }
    
    public function getFraisCorrespondant(){
        $idVisiteur = $this->input->post('idVisiteur',true);
        $mois = $this->input->post('mois',true);
        $fraisCorrespondant = null;
        $ficheDetail = $this->fichesFrais->getDetailFicheFrais($idVisiteur, $mois);
        
        $fraisForfait = $this->fichesFrais->getFraisForfaitPour($idVisiteur, $mois);
        
        if(is_array($ficheDetail)){
            
            $fraisCorrespondant['ficheDetail'] = $ficheDetail;
        }
        
        if(is_array($fraisForfait)){
            $fraisCorrespondant['fraisForfait'] = $fraisForfait;
            $fraisCorrespondant['mois'] = $mois;
            $fraisCorrespondant['idVisiteur'] = $idVisiteur;
        }
        
        $fraisHorsForfait = $this->fichesFraisHorsForfait->getFraisHorsForfaitPour($idVisiteur, $mois);
        
        if(is_array($fraisHorsForfait)){
            $fraisCorrespondant['fraisHorsForfait'] = $fraisHorsForfait;
        }
        
        $pagePourAfficherFrais = $this->_creerPagePourFrais($fraisCorrespondant);
        
        echo $pagePourAfficherFrais;
        
    }
    
    public function actualiserFraisForfait(){
         // utilisation de fonction days_in_month pour obtenir le nnombre du jour d'un mois donnee
            $nbJourDuMois = days_in_month(06);
            //on suppose ici qu'un visiteur medical peut manger maximum 3 fois par jour
            $nbRepasDuMois = $nbJourDuMois * 3;
            
            // Utlisation des fonctions natives du codeigniter pour valider les donnees de formulaire.
            $this->form_validation->set_rules("etape","Forfait Etape","required|trim|xss_clean|numeric|greater_than[0]|less_than[1000]");
	    $this->form_validation->set_rules("kilometre","Frais Kilométrique","required|trim|xss_clean|numeric|greater_than[0]|less_than[1000]");
            $this->form_validation->set_rules("nuitee","Nuitée Hôtel","required|trim|xss_clean||numeric|greater_than[0]|less_than[$nbJourDuMois]");
	    $this->form_validation->set_rules("repas","Repas Restaurant","required|trim|xss_clean|numeric|greater_than[0]|less_than[$nbRepasDuMois]");
            
            // On recupere toutes les donnees enoye par l'utilisateur
            $ajouter = array(
                'ETP'       => $this->input->post('etape', true),
                'KM'        => $this->input->post('kilometre', true),
                'NUI'       => $this->input->post('nuitee', true),
                'REP'       => $this->input->post('repas', true)
            );
            
            $idVisiteur = $this->input->post('idVisiteur',true);
            $mois = $this->input->post('mois',true);
            
            if($this->form_validation->run() === true){
                // On lance une boucle, a chaque tour elle va appeler la fonction miseAJourLigneFraisForfait que l'on passe les elements du tableau $ajouter
                foreach ($ajouter as $id => $quantite) {
                    $this->fichesFrais->miseAJourLigneFraisForfait($id, $quantite, $idVisiteur, $mois);
                }
            }
            
            $errors = validation_errors();
            
            if(!empty($errors)){
                echo '<div class="alert alert-danger bg-danger h4">'.$errors.'</div>';
                $this->getFraisCorrespondant();
            }else{
                echo '<div class="alert alert-success bg-success h4">Les modifications de la fiche de frais ont bien été enregistrées</div>';
                $this->getFraisCorrespondant();
            }
    }
    
    public function refuserFicheFraisHorsForfait(){
        $idFicheFrais = $this->input->post('idFraisHorsForfait',true);
        
        
        $estSupprime = $this->fichesFraisHorsForfait->refuserLigneFraisHorsForfait($idFicheFrais);
        
        if($estSupprime){
            echo '<div class="alert alert-success bg-success h4">La fiche de frais a ete refuse.</div>';
            $this->getFraisCorrespondant(); 
        }else{
            echo '<div class="alert alert-danger bg-danger h4">La fiche de frais n\'a pas ete refuse.Veuillez reesayer.</div>';
            $this->getFraisCorrespondant(); 
        }
    }
    
    private function _creerBaliseSelect($params){
        
        $select = '<select id="moisSelect" class="form-control" name="'.  site_url("comptable/getFraisCorrespondant").'">';
        $select .= '<option>OK</option>';
        foreach ($params as $valeur){
            $select .= '<option value="'.$valeur.'">';
            $select .= obtenirLibelleMois(substr($valeur, 5))." ".substr($valeur, 0, 4);
            $select .= '</option>';
        }
        $select .= '</select>';
        
        return $select;
        
    }
    
    private function _creerPagePourFrais($fraisCorrespondant){
        return $this->load->view('ajax/fraisValider', $fraisCorrespondant, true);
    }
}
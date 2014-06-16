<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gsb extends MY_Controller{

	public function __construct(){

		parent::__construct();
		$this->load->library("Layout", "layout");
	}

	public function index(){
            
            parent::_estUtilisateurConnecte();
            $this->layout->set_titre("GSB - Page d'accueil");
            $this->layout->view("accueil");
                

	}

	public function connecter(){
            parent::_estUtilisateurDeconnecte();
		$this->layout->set_titre("GSB - Se Connecter");
		$this->layout->view("seconnecter");

	}

	public function saisieFicheFrais(){
            parent::_estVisiteurConnecte();
            $mois = sprintf("%04d%02d", date("Y"), date("m"));
            $this->load->model("fichesFrais_db", "fichesFrais");
                
                // si fiche nexiste pas
                if(!$this->fichesFrais->existeFicheFrais($mois)){
                    
                    $dernierMois = $this->fichesFrais->getDernierMoisSaisi();
                    $derniereFicheFrais = $this->fichesFrais->getDetailFicheFrais($this->session->userdata('utilisateur')['idUtilisateur'],$dernierMois['mois']);
                    
                    if($derniereFicheFrais['idEtat'] === 'CR'){
                        
                        //cloturer la fiche de frais de mois precedent avant de creer une nouvelle pour le mois en cours
                        $this->fichesFrais->cloturerFicheFrais($dernierMois['mois']);
                    }
                    
                    $this->fichesFrais->ajouterFicheFrais();
                    $tousID = $this->fichesFrais->getTousIDFraisForfait();
                    
                    foreach ($tousID as $id) {
                        $this->fichesFrais->ajouterLigneFraisForfait($id['id'], 0);
                    }
                    
                }
                
                
		$forfaitElements['forfaitElements'] = $this->fichesFrais->getForfaitElements();
                
                

		$this->layout->set_titre("GSB - Saissez vos fiches");
		$this->layout->view("saisieFicheFrais", $forfaitElements);
	}

	public function consulterFichesFrais(){
                
            parent::_estVisiteurConnecte();

		$this->load->model("fichesFrais_db", "fichesFrais");
		$moisFicheFrais['moisFicheFrais'] = $this->fichesFrais->getTousMoisFicheFrais();



		$this->layout->set_titre("GSB - Consultez vos fiches");
		$this->layout->view("consulterFichesFrais", $moisFicheFrais);
	}

        public function validFichesFrais(){
            parent::_estComptableConnecte();
            $this->load->model("utilisateur_db", "utilisateur");
            $params['visiteurs'] = $this->utilisateur->getTousLesUtilisateurs();
            
            $this->layout->set_titre("GSB - Valider Fiches Frais");
            $this->layout->view("validFichesFrais", $params);
        }
        
        public function misePaiementFichesFrais(){
            parent::_estComptableConnecte();
            $this->layout->set_titre("GSB - Mise en Paiement");
            $this->layout->view("misePaiementFichesFrais");
        }
}
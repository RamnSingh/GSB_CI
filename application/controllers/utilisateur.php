<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utilisateur extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        
		$this->load->library("Layout", "layout");
		$this->load->model("utilisateur_db", "utilisateur");
    }

	public function verifierInfosConnexion(){

		$this->form_validation->set_rules("login","Login","required|trim|xss_clean|callback_existeUtilisateur");
		$this->form_validation->set_rules("motdepasse","Mot de passe","required|trim|xss_clean");
		
		if($this->form_validation->run() == FALSE){
			$this->layout->set_titre("GSB - Se Connecter");
			$this->layout->view("seconnecter");
		}else{
			redirect('gsb/index', 'refresh');
		}


	}


	public function existeUtilisateur(){
		$login = $this->input->post('login');
		$motDePasse = $this->input->post('motdepasse');

		$resultat = $this->utilisateur->getDetailUtilisateur($login, $motDePasse);

		if ($resultat)
		{
			
			$donneesSession = array("idUtilisateur" => $resultat->id, "login" => $resultat->login, "motDePasse" => $resultat->mdp, "nom" => $resultat->nom, "prenom" => $resultat->prenom, "idType" => $resultat->idType);
			$this->session->set_userdata("utilisateur", $donneesSession);
			

			return true;
		}
		else
		{
			$this->form_validation->set_message('existeUtilisateur', 'Pseudo ou Mot de Passe incorrect !');
     		return false;

		}
	}


	public function deconnecter()
	{
		$this->session->sess_destroy();
		redirect("gsb/index","refresh");
	}
}
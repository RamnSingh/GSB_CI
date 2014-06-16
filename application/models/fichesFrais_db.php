<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fichesFrais_db extends CI_Model{
    
    private $mois = null;

    public function __construct(){
		parent::__construct();
                $this->mois = sprintf('%04d%02d', date('Y'), date('m'));
	}
        
        /**
         * Vérifie si une fiche de frais existe ou non. 
         * Retourne true si la fiche de frais du mois de $mois (AAAAMM) du visiteur 
         * @param string $mois
         * @return boolean
         */
        public function existeFicheFrais($mois){
                $this->db->select('idVisiteur');
		$this->db->from("fichefrais");
		$this->db->where("idVisiteur", $this->db->escape_str($this->session->userData("utilisateur")['idUtilisateur']));
		$this->db->where("mois", $this->db->escape_str($mois));

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
        }
        
        /**
         * Retourne les elements de table fiche de frais
         * 
         * @param string $mois
         * @return boolean false en cas d'echec et array en cas du success
         */
	public function getForfaitElements($mois = ""){
                if($mois === ""){
                    $mois = $this->mois;
                }
		$this->db->select('idFraisForfait, libelle, quantite, montant as montantUnitaire');
		$this->db->from("lignefraisforfait");
		$this->db->join("fraisforfait","fraisforfait.id = lignefraisforfait.idFraisForfait");
		$this->db->where("idVisiteur", $this->db->escape_str($this->session->userData("utilisateur")['idUtilisateur']));
		$this->db->where("mois", $this->db->escape_str($mois));

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
        
        /**
         * Retourne tous les mois pour un visiteur
         * @return boolean false en cas d'echec et array en cas du success
         */
	public function getTousMoisFicheFrais(){
		$this->db->select('mois');
		$this->db->from("fichefrais");
		$this->db->where("idVisiteur", $this->db->escape_str($this->session->userData("utilisateur")['idUtilisateur']));
		$this->db->order_by("mois", "desc");

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}
        
        /**
         * Fournit les informations d'une fiche de frais. 
         * Retourne les informations de la fiche de frais du mois de $unMois (AAAAMM)
         * 
         * @param string $mois
         * @return boolean false en cas d'echec et array en cas de succes
         */
        public function getDetailFicheFrais($idVisiteur, $mois) {
                if(empty($idVisiteur)){
                    $idVisiteur = $this->db->escape_str($this->session->userData("utilisateur")['idUtilisateur']);
                }
                $this->db->select('idVisiteur, nbJustificatifs, mois, dateModif, montantValide, idEtat, libelle as libelleEtat');
		$this->db->from("fichefrais");
                $this->db->join("etat", "ficheFrais.idEtat = etat.id");
		$this->db->where("idVisiteur", $idVisiteur);
		$this->db->where("mois",$mois);

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
                    return $query->row_array();
		}
		else
		{
			return false;
		}
        }
        
        /**
         * Retourne la date de modification d'une fiche frais
         * 
         * @param string $mois
         * @return boolean false en cas d'echec et array en cas de succes
         */
        public function getDateModifFicheFrais($mois = "") {
            if($mois === ""){
                    $mois = $this->mois;
                }
                $this->db->select('dateModif');
		$this->db->from("fichefrais");
		$this->db->where("idVisiteur", $this->db->escape_str($this->session->userData("utilisateur")['idUtilisateur']));
		$this->db->where("mois",$mois);

		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
                    return $query->row_array();
		}
		else
		{
			return false;
		}
        }
        
        /**
         * Ajoute une nouvelle fiche de frais
         * Ajoute la fiche de frais du mois de $unMois (MMAAAA) du visiteur
         * 
         * @return boolean
         */
        public function ajouterFicheFrais(){
            
            $data = array(
                'idVisiteur'        => $this->session->userData("utilisateur")['idUtilisateur'],
                'mois'              => $this->mois,
                'nbJustificatifs'   => 0,
                'montantValide'     => NULL,
                'idEtat'            => 'CR',
                'dateModif'         => date("Y-m-d")
            );
            $this->db->insert('fichefrais',$data);
            
            // On stocke les nombres de lignes affectes par la requete
            $ligneAffectes = $this->db->affected_rows();
            
            if($ligneAffectes > 0)
            {
                return True;
            }
            else
            {
                return FALSE;
            }
        }
        
        /**
         * Ajoute les éléments forfaitisés associés
         * 
         * @param string $idFraisForfait
         * @param int $quantite
         * @return boolean
         */
        public function ajouterLigneFraisForfait($idFraisForfait, $quantite = 0){
            $data = array(
                'idVisiteur'        => $this->session->userData("utilisateur")['idUtilisateur'],
                'mois'              => $this->mois,
                'idFraisForfait'    => $idFraisForfait,
                'quantite'          => $quantite
            );
            $this->db->insert('lignefraisforfait',$data);
            
             // On stocke les nombres de lignes affectes par la requete
            $ligneAffectes = $this->db->affected_rows();
            
            if($ligneAffectes > 0)
            {
                return True;
            }
            else
            {
                return FALSE;
            }
        }
        
        /**
         * Mettre a jour les éléments forfaitisés associés
         * 
         * @param string $idFraisForfait
         * @param int $quantite
         * @return boolean
         */
        public function miseAJourLigneFraisForfait($idFraisForfait, $quantite = 0, $idVisiteur, $mois){
            $data = array(
                'quantite'          => $quantite
            );
            if(empty($idVisiteur)){
                $idVisiteur = $this->session->userData("utilisateur")['idUtilisateur'];
            }
            if(empty($mois)){
                $mois = $this->mois;
            }
            $this->db->where('mois', $mois);
            $this->db->where('idFraisForfait',$idFraisForfait);
            $this->db->where('idVisiteur', $idVisiteur);
            $this->db->update('lignefraisforfait',$data);
            
             // On stocke les nombres de lignes affectes par la requete
            $ligneAffectes = $this->db->affected_rows();
            
            if($ligneAffectes > 0)
            {
                return True;
            }
            else
            {
                return FALSE;
            }
        }
        
        public function getFraisForfaitPour($idVisiteur, $mois){
            $this->db->select("idFraisForfait, libelle, quantite");
            $this->db->from('lignefraisforfait');
            $this->db->join('fraisforfait', "fraisforfait.id = lignefraisforfait.idFraisForfait");
            $this->db->where('idVisiteur', $idVisiteur);
            $this->db->where('mois', $mois);
            
            $query = $this->db->get();
            
            if ($query->num_rows > 0){
                return $query->result_array();
            }else{
                return false;
            }
        }
        
        
        /**
         * Retourne tous les elements de colonne ID de table fraisForfait
         * 
         * @return boolean en cas d'echec et array en cas de succes
         */
        public function getTousIDFraisForfait(){
            $this->db->select('id');
            $this->db->from("fraisforfait");
            
            $query = $this->db->get();

		if($query->num_rows() > 0)
		{
                    return $query->result_array();
		}
		else
		{
			return false;
		}
        }
        
        public function getTousLesMoisFicheCloturee($idVisiteur){
            $this->db->select('mois');
            $this->db->from('fichefrais');
            $this->db->where('idVisiteur', $idVisiteur);
            $this->db->where('idEtat', 'CL');
            $this->db->order_by('mois', 'desc');
            
            $query = $this->db->get();
            
            if ($query->num_rows > 0){
                return $query->row_array();
            }else{
                return false;
            }
        }
        
        /**
         * Retourne le dernier mois saisi sous forme d'un tableau
         * 
         * @return boolean en cas d'echec et array en cas de succes
         */
        public function getDernierMoisSaisi(){
            $this->db->select_max('mois');
            $this->db->from('fichefrais');
            $this->db->where('idVisiteur', $this->session->userData("utilisateur")['idUtilisateur']);
            
            $query = $this->db->get();
            
            if ($query->num_rows > 0){
                return $query->row_array();
            }else{
                return false;
            }
        }
        
        /**
         * Permet de cloturer une fiche de frais qui  n'est pas encore cloturee
         * 
         * @param string $mois
         * @return boolean
         */
        public function  cloturerFicheFrais($mois){
            
            $modifier  = array(
                        'idEtat' => 'CR',
                        'dateModif' => now()
            );
            $this->db->where('mois', $mois);
            $this->db->where('idVisiteur', $this->session->userData("utilisateur")['idUtilisateur']);
            $this->db->update('fichefrais',$modifier);
            
              // On stocke les nombres de lignes affectes par la requete
            $ligneAffectes = $this->db->affected_rows();
            
            if($ligneAffectes > 0)
            {
                return True;
            }
            else
            {
                return FALSE;
            }
        }
        
}
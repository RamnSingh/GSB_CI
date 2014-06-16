<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class fichesFraisHorsForfait_db extends CI_Model{
    
    private $mois;

    public function __construct(){
		parent::__construct();
                $this->mois = sprintf("%04d%02d", date("Y"), date("m"));
	}
        
         public function getHorsForfaitElements($mois = ""){
                if($mois === ""){
                    $mois = $this->mois;
                }
                    $this->db->select('id, date,libelle, montant');
                    $this->db->from("ligneFraisHorsForfait");
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
        
        public function ajouterLigneFraisHorsForfait($date, $libelle, $montant){
            $data = array(
                'idVisiteur'        => $this->session->userData("utilisateur")['idUtilisateur'],
                'mois'              => $this->mois,
                'date'              => $date,
                'libelle'           => $libelle,
                'montant'           => $montant
            );
            $this->db->insert('lignefraisHorsforfait',$data);
            
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
        
        public function getTousLesElementsFraisHorsForfait(){
            $this->db->select('*');
            $this->db->from('ligneFraisHorsForfait');
            $this->db->where('idVisiteur', $this->session->userData("utilisateur")['idUtilisateur']);
            $this->db->where('mois', $this->mois);
            
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
        
        public function getFraisHorsForfaitPour($idVisiteur, $mois){
            $this->db->select('id, date, libelle, montant');
            $this->db->from('lignefraishorsforfait');
            $this->db->where('idVisiteur', $idVisiteur);
            $this->db->where('mois', $mois);
            
            
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
        
         public function supprimerLigneFraisHorsForfait($id){
           
           $this->db->where('id', $id);
           $this->db->delete('lignefraisHorsforfait');
           
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
        
        public function refuserLigneFraisHorsForfait($idFicheFrais){
            $req = "UPDATE lignefraishorsforfait SET libelle = CONCAT('REFUSE : ', libelle) WHERE id = ".$idFicheFrais;
            
            $query = $this->db->query($req);
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
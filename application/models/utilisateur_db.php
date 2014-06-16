<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class utilisateur_db extends CI_Model{

	public function __construct(){
		parent::__construct();
	}

	public function getDetailUtilisateur($login, $motDePasse){
		$this->db->select("*");
		$this->db->from("utilisateur");
		$this->db->where("login", $this->db->escape_str($login));
		$this->db->where("mdp", $this->db->escape_str($motDePasse));
		$this->db->limit(1);

		$query = $this->db->get();

		if(($query->num_rows() > 0) && ($query->num_rows() == 1))
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
        
        public function getTousLesUtilisateurs(){
            $this->db->select("*");
            $this->db->from("utilisateur");
            $this->db->where('idType', 'V');
            $this->db->order_by('nom','asc');
            
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

}
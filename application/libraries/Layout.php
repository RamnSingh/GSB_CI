<?php

class Layout{

	private $CI;

	private $layout_titre = null;

	private $layout_description = null;

	public function __construct(){
		$this->CI =& get_instance();
	}

	public function set_titre($titre){
		$this->layout_titre = $titre;
	}

	public function set_description($description){
		$this->layout_description = $description;
	}

	public function view($view, $params = NULL,  $default = true){


		if($default){

			// parametres pour la balise head
			$head_params['titre'] = $this->layout_titre;
			$params['sommaire'] = $this->CI->load->view('include/sommaire', '', true);
			$this->CI->load->view('include\head', $head_params);
			$this->CI->load->view('include\entete');
			$this->CI->load->view('include\sommaire');
			$this->CI->load->view($view, $params);
			$this->CI->load->view('include/pied');

		}else{
			$this->CI->load->view($view, $params);
		}

	}
}
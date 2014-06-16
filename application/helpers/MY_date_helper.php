<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('obtenirLibelleMois')){

	function obtenirLibelleMois($nbMois) {

		$nbMois = (int)rtrim($nbMois, "0");
	    $tabLibelles = array(1=>"Janvier", 
	                            "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
	                            "Août", "Septembre", "Octobre", "Novembre", "Décembre");
	    $libelle="";
	    if ( $nbMois >=1 && $nbMois <= 12 ) {
	        $libelle = $tabLibelles[$nbMois];
	    }
	    return $libelle;
	}

}


if ( ! function_exists('estDate')){
    
    /** 
    * Vérifie si une chaîne fournie est bien une date valide, au format AAAA/MM/JJ                     
    * 
    * @param string date à vérifier
    * @return boolean succès ou échec
    */ 
   function estDate($date) {
        $tabDate = explode('-',$date);
        if (count($tabDate) != 3) {
            $dateOK = false;
       }
       elseif (!verifierEntiersPositifs($tabDate)) {
           $dateOK = false;
       }
       elseif (!checkdate($tabDate[1], $tabDate[2], $tabDate[0])) {
           $dateOK = false;
       }
       else {
           $dateOK = true;
       }
           return $dateOK;
   }
}

if ( ! function_exists('verifierEntiersPositifs')){
    /** 
    * Vérifie que chaque valeur est bien renseignée et numérique entière positive.
    *  
    * Renvoie la valeur booléenne true si toutes les valeurs sont bien renseignées et
    * numériques entières positives. False si l'une d'elles ne l'est pas.
    * @param array $lesValeurs tableau des valeurs
    * @return booléen succès ou échec
    */ 
   function verifierEntiersPositifs($lesValeurs){
       $ok = true;     
       foreach ( $lesValeurs as $val ) {
           if ($val=="" || ($val < 1) ) {
               $ok = false;
           }
       }
       return $ok; 
   }
}

if ( ! function_exists('estDansAnneeEcoulee')){
    /**
    * Indique si une date est incluse ou non dans l'année écoulée.
    * 
    * Retourne true si la date $date est comprise entre la date du jour moins un an et la 
    * la date du jour. False sinon.   
    * @param $date date au format jj/mm/aaaa
    * @return boolean succès ou échec
   */
   function estDansAnneeEcoulee($date) {
       $dateDuJourAnglais = date("Y-m-d");
       $dateDuJourMoinsUnAnAnglais = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
       return ($date >= $dateDuJourMoinsUnAnAnglais) && ($date <= $dateDuJourAnglais);
   }
}
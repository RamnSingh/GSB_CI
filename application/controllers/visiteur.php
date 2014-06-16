<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class visiteur extends CI_Controller{
    
        private $mois = null;
    
        public function __construct() {
            
            parent::__construct();
            
            $this->mois = sprintf("%04d%02d", date("Y"), date("m"));
            
            // Inclus une librarie layout
            $this->load->library("Layout", "layout");
            
            //On inclus deux fichiers qui nous permet de communiquer qvec la base de donne en toute securite
            $this->load->model("fichesFrais_db", 'fichesFrais');
            $this->load->model("fichesFraisHorsForfait_db", 'fichesFraisHorsForfait');
        }
        
        //  -------- LES FONCTIONS PUBLIQUES ------
        
        /**
         *  Ajoute les elements forfaitises
         */
        public function ajouterLigneFrais(){
            
            // utilisation de fonction days_in_month pour obtenir le nnombre du jour d'un mois donnee
            $nbJourDuMois = days_in_month(06);
            //on suppose ici qu'un visiteur medical peut manger maximum 3 fois par jour
            $nbRepasDuMois = $nbJourDuMois * 3;
            
            // Utlisation des fonctions natives du codeigniter pour valider les donnees de formulaire.
            $this->form_validation->set_rules("ETP","Forfait Etape","required|trim|xss_clean|numeric|greater_than[0]|less_than[1000]");
	    $this->form_validation->set_rules("KM","Frais Kilométrique","required|trim|xss_clean|numeric|greater_than[0]|less_than[1000]");
            $this->form_validation->set_rules("NUI","Nuitée Hôtel","required|trim|xss_clean||numeric|greater_than[0]|less_than[$nbJourDuMois]");
	    $this->form_validation->set_rules("REP","Repas Restaurant","required|trim|xss_clean|numeric|greater_than[0]|less_than[$nbRepasDuMois]");
            
            // On recupere toutes les donnees enoye par l'utilisateur
            $ajouter = array(
                'ETP'       => $this->input->post('ETP', true),
                'KM'        => $this->input->post('KM', true),
                'NUI'       => $this->input->post('NUI', true),
                'REP'       => $this->input->post('REP', true)
            );
            
            if($this->form_validation->run() === true){
                // On lance une boucle, a chaque tour elle va appeler la fonction miseAJourLigneFraisForfait que l'on passe les elements du tableau $ajouter
                foreach ($ajouter as $id => $quantite) {
                    $this->fichesFrais->miseAJourLigneFraisForfait($id, $quantite);
                }
                $this->session->set_flashdata('succes', '<div class="alert alert-success bg-success h4">Les modifications de la fiche de frais ont bien été enregistrées</div>');
            }
            
            // Recupere tous les elements d'une fiche du frais
            $forfaitElements['forfaitElements'] = $this->fichesFrais->getForfaitElements();
            
            //Recupere tous les d'une fiche de frais hors forfait
            $horsForfaitElements = $this->fichesFraisHorsForfait->getTousLesElementsFraisHorsForfait();
            if($horsForfaitElements != FALSE){
                $forfaitElements['horsForfaitElements'] = $horsForfaitElements;
            }

            $this->layout->set_titre("GSB - Saissez vos fiches");
            $this->layout->view("saisieFicheFrais", $forfaitElements);
            
            
        }
        
        public function ajouterLigneFraisHorsForfait(){
            
            // Utlisation des fonctions natives du codeigniter pour valider les donnees de formulaire.
            $this->form_validation->set_rules("date","Date","required|trim|xss_clean|callback_estDate|callback_estDansAnneeEcoulee");
	    $this->form_validation->set_rules("libelle","Libelle","required|trim|xss_clean");
            $this->form_validation->set_rules("montant","Montant","required|trim|xss_clean|numeric");
            
            // On recupere toutes les donnees envoye par l'utilisateur
            $date = $this->input->post('date', true);
            $libelle = $this->input->post('libelle', true);
            $montant = $this->input->post('montant', true);
            
            if($this->form_validation->run() === true){
                
                $this->fichesFraisHorsForfait->ajouterLigneFraisHorsForfait($date, $libelle, $montant);
               
                $this->session->set_flashdata('succes', '<div class="alert alert-success bg-sucess h4">Les modifications de la fiche de frais Hors Forfait ont bien été enregistrées</div>');
            }
            
              
            // Recupere tous les elements d'une fiche du frais
            $forfaitElements['forfaitElements'] = $this->fichesFrais->getForfaitElements();
            
            //Recupere tous les d'une fiche de frais hors forfait
            $horsForfaitElements = $this->fichesFraisHorsForfait->getTousLesElementsFraisHorsForfait();
            if($horsForfaitElements != FALSE){
                $forfaitElements['horsForfaitElements'] = $horsForfaitElements;
            }

            $this->layout->set_titre("GSB - Saissez vos fiches");
            $this->layout->view("saisieFicheFrais", $forfaitElements);
            
        }
        
        public function supprimerLigneFicheHorsForfait(){
            // On recupere toutes les donnees envoye par l'utilisateur
            $id = $this->input->post('id', true);
            
            $supprimerLigneHorsForfait = $this->fichesFraisHorsForfait->supprimerLigneFraisHorsForfait($id);
            
            if($supprimerLigneHorsForfait){
                $this->session->set_flashdata('succes', '<div class="alert alert-success bg-sucess h4">Les modifications de la fiche de frais Hors Forfait ont bien été enregistrées</div>');
            }
            
              
            // Recupere tous les elements d'une fiche du frais
            $forfaitElements['forfaitElements'] = $this->fichesFrais->getForfaitElements();
            
            //Recupere tous les d'une fiche de frais hors forfait
            $horsForfaitElements = $this->fichesFraisHorsForfait->getTousLesElementsFraisHorsForfait();
            if($horsForfaitElements != FALSE){
                $forfaitElements['horsForfaitElements'] = $horsForfaitElements;
            }

            $this->layout->set_titre("GSB - Saissez vos fiches");
            $this->layout->view("saisieFicheFrais", $forfaitElements);
            
        }
        
        /**
         * Procedure / Appele par une requete AJAX
         * Recupere le detail d'une fiche de frais pour un mois donnee
         * 
         * 
         *  return void
         */
	public function getDetailFicheFrais(){
            
            // On recupere le mois envoye par l'utilisateur
            $mois = $this->input->post('mois', true);
            
            // On verifie si le mois demande est valid et existe-il une fiche pour ce mois
            $existeMois = $this->fichesFrais->existeFicheFrais($mois);
            
            // Si la fiche de frais pour le mois existe
            if($existeMois){
                
                // On recupere tous les detail de fiche de frais demande par l,utilisateur
                $ficheFrais['fiche'] = $this->fichesFrais->getDetailFicheFrais($this->session->userdata('utilisateur')['idUtilisateur'],$mois);
                
                // On recupere tous les elements d'une  fiche de frais par exemple : etat, libelle, montant
                $ficheFrais['forfaitElements'] = $this->fichesFrais->getForfaitElements($mois);
                
                // On recupere tous les elements d'une  fiche de frais hors forfait par exemple : date, libelle, montant
                $ficheFrais['horsForfaitElements'] = $this->fichesFraisHorsForfait->getHorsForfaitElements($mois);
                
                // On passe tous les details et elements recupere d'une fiche de frais sous forme d'un tableau
                // cette fonction nous retourne une page HTML
                $ficheFraisHTML = $this->getViewFicheDetail($ficheFrais);
                
                // On affche le HTML recupere a l'aide de fonction appellee juste au-dessous
                echo $ficheFraisHTML;
            }else{
                echo "<p class='bg-danger'>Le mois demandé est invalide</p>";
            }
            
            
	}
        
        /**
         * Cree un fichier pdf
         */
        public function getPdf(){
            
            // On recupere le mois envoye par l'utilisateur
            $mois = $this->input->post('mois', TRUE);
            
            // On verifie si le mois demande est valid et existe-il une fiche pour ce mois
            $existeMois = $this->fichesFrais->existeFicheFrais($mois);
            
            if($existeMois){
                
                // On inclus la librarie pdf pour generer un pdf et puis on active ou instancie un objet
                $this->load->library('pdf');
                $pdf = $this->pdf->load();

                // On appelle la fonction writeHTML() qui prend comme parametre une page HTML ou HTML tout court pour generer un PDF
                $pdf->writeHTML($this->getPdfPage($mois));

                // On genere le fichier PDF
                $pdf->output();
                
            }else{
                redirect('gsb/consulterFichesFrais');
            }
            
            
        }
        
        public function estDate(){
            $estDateOk = estDate($this->input->post('date',true));
            if($estDateOk){
                return true;
            }else{
                $this->form_validation->set_message('estDate', 'La date d\'engagement doit être valide au format MM/JJ/AAAA');
                return false;
            }
        }
        
        public function estDansAnneeEcoulee(){
            $anneeEcoulee = estDansAnneeEcoulee($this->input->post('date',true));
            
            if ($anneeEcoulee) {
                return TRUE;
            }else{
                $this->form_validation->set_message('estDansAnneeEcoulee', 'La date d\'engagement doit se situer dans l\'année écoulée');
                return false;
            }
        }
        
        // --------- LES FONCTIONS PRIVEEs -------- 
        private function getViewFicheDetail(Array $ficheDetail){
            
            // On envoie le tableau $ficheDetail a ficheDetail.php qui nous retourne une page HTML sous forme d'une chaine de caractere
            // que l'on va retourner a la fonction getDetailFicheFrais pour pouvir integrer cette partie de HTML dans la page principale
            return $this->load->view("ajax/ficheDetail",$ficheDetail, true);
        }
        
        private function getPdfPage($mois) {
            
            // On recupere tous les detail de fiche de frais demande par l,utilisateur
            $ficheFrais['fiche'] = $this->fichesFrais->getDetailFicheFrais($this->session->userdata('utilisateur')['idUtilisateur'],$mois);

            // On recupere tous les elements d'une  fiche de frais par exemple : etat, libelle, montant
            $ficheFrais['forfaitElements'] = $this->fichesFrais->getForfaitElements($mois);
            
            // On recupere la date de modification de cette fiche de frais puis on la formatte
            $date = $this->fichesFrais->getDateModifFicheFrais($mois);
            
            // Decomposition de date recupere pour que ca soit ecplicite et comprhensible sur le PDF
            $jour = substr($date['dateModif'], 8);
            $alphaMois = obtenirLibelleMois(substr($date['dateModif'], 5, 7));
            $annee = substr($date['dateModif'], 0,4);
            $param['date'] = $jour." ".$alphaMois." ".$annee;
            
            //Decomposition du mois qui est un parametre
            $param['mois'] = obtenirLibelleMois(substr($mois, 4, 6))." ".substr($mois, 0, 4);
            
            // Recuperation de toutes les donnees d'un utilisateur connecte et stocker dans un tableau
            $param['visiteur'] = $this->session->userdata('utilisateur');
            
            // On envoie le tableau $param a ficheFraisPDF.php qui nous retourne une page HTML sous forme d'une chaine de caractere
            // que l'on va retourner a la fonction getPDF pour pouvir generer un fichier PDF depuis cette page
            $ficheFraisPDF =  $this->load->view("pdf/ficheFraisPdf", $param, true);
            
            return $ficheFraisPDF;
        }
         
        

}
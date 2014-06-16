    <div class="col-md-10 col-sm-9 col-xs-8">
        
        <?php
            if($this->session->userdata("utilisateur")['idType'] === "C"){
        ?>
        
        <div id="Contenu">
            
            <div class="alert alert-info h3">
                
                <div class="panel panel-primary">
                    
                    <div class="panel-heading">
                        <span class="h3">Validation des frais</span>
                    </div>
                    
                    <div class="panel-body">
                        
                            
                            <ul class="list-inline pull-left" id="choixVisiteur">
                                <li>
                                   
                                    <label for="choixVisiteur">Choisir le visiteur :</label>
                                </li>
                                <li>
                                    <select name="<?php echo site_url('comptable/getTousLesMois'); ?>" class="form-control" id="visiteursSelect" autofocus="">
                                        <?php
                                                foreach ($visiteurs as $visiteur) {
                                        ?>
                                        
                                        <option value="<?php echo $visiteur['id']; ?>" ><?php echo $visiteur['nom']." ".$visiteur['prenom']; ?></option>
                                        
                                        <?php
                                                }
                                        ?>
                                    </select>
                                </li>
                                <li id="moisVisiteur"></li>
                            </ul>
                        
                        <div class="small text-danger" id="pasDeFiche">
                            Pas de fiche de frais à valider pour ce visiteur, veuillez choisir un autre visiteur

                        </div>
                            
                        
                    </div>
                </div>
                
                <div class="panel panel-primary">
                    <div id="fraisCorrespondant"></div>
                </div>
                
            </div>
            
        </div>
        <?php
            }else{
                redirect('gsb/connecter');
            }
        ?>
    </div>

<!-- Fin de balise classe "row "qui se trouve dans la page sommaire -->
</div>
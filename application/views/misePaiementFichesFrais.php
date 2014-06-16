    <div class="col-md-10 col-sm-9 col-xs-8">
        
        <?php
            if($this->session->userdata("utilisateur")['idType'] === "C"){
        ?>
        
        <div id="Contenu">
            
        </div>
        <?php
            }else{
                redirect('gsb/connecter');
            }
        ?>
    </div>

<!-- Fin de balise classe "row "qui se trouve dans la page sommaire -->
</div>
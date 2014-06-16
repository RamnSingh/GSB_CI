	<div class="col-md-10 col-sm-9 col-xs-8">
		
		<div id="contenu">
			
			<?php 
				if($this->session->userdata("utilisateur")){
			?>
				<div class="panel panel-primary">
					<div class="panel-heading"><span class="h3">Bienvenue sur l'intranet GSB</span></div>
					<div class="panel-body h3">
						<span class="color-black">
							<?= $this->session->userdata("utilisateur")['nom'].' '.$this->session->userdata("utilisateur")['prenom'];  ?>
						</span>
					</div>
				</div>
			<?php 
				}else{
					redirect('gsb/connecter','refresh');
				}
			?>
			
		</div>

	</div>

	<!-- Fin de balise classe "row "qui se trouve dans la page sommaire -->
	</div> 
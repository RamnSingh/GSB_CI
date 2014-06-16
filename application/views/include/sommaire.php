<div id="sommaire_et_contenu" class="row">

		<div class="col-md-2 col-sm-3 col-xs-4">

			<div class="bg-primary">
				<span class="h4">
					<?php echo $this->session->userdata("utilisateur")['nom'].' '.$this->session->userdata("utilisateur")['prenom']; ?>
					<br>
					<?php 
						if($this->session->userdata("utilisateur")['idType'] === 'C'){
					?>
					Comptable
					<?php
						}else{
					?>
					Visiteur Médical
					<?php
						}
					?>
				</span>
			</div>
			

			<ul class="nav" id="sommaire">
			<?php 
				if($this->session->userdata("utilisateur")){
			?>
				<li></li>
				<li><a href="<?= base_url(); ?>">Accueil</a></li>
				<?php 
					if($this->session->userdata("utilisateur")['idType'] === 'C'){
				?>
				<li><a href="<?= site_url().'/gsb/validFichesFrais';?>">Valider Fiches de Frais</a></li>
				<li><a href="<?= site_url().'/gsb/misePaiementFichesFrais';?>">Suivre le paiement des fiches de frais</a></li>
				<?php 
					}else{
				?>
				<li><a href="<?= site_url().'/gsb/saisieFicheFrais';?>">Saisir fiches des frais</a></li>
				<li><a href="<?= site_url().'/gsb/consulterFichesFrais';?>">Mes Fiches des frais</a></li>
				<?php 
					}
				?>
				<li><a href="<?= site_url().'/utilisateur/deconnecter';?>">Se Deconnecter</a></li>
			 

			<?php
				}else{
			?>

					<li><a href="<?= site_url().'/gsb/connecter';?>">Se Connecter</a></li>
			<?php
				}

			 ?>
			</ul>
			
		</div>
	<div class="col-md-10 col-sm-9 col-xs-8">
		
		<div id="contenu">
			<?php echo validation_errors('<p class="errors">'); ?>
			<div class="formulaire" id="formulaire_login">
				<p class="h3">
					Identification utilisateur
				</p>
				
				<?php echo form_open('utilisateur/verifierInfosConnexion'); ?>
					<div class="form-group">
				        <label for="login">* Login</label>
				        <input type="text" id="login" class="form-control" name="login" placeholder="Login">
				    </div>
				    <div class="form-group">
				        <label for="motdepasse">* Mot de Passe</label>
				        <input type="password" id="motdepasse" class="form-control" name="motdepasse" placeholder="Mot de Passe">
				    </div>
					<input type="submit" class="btn btn-primary">&nbsp;&nbsp;<input type="reset" class="btn btn-default">
				<?php echo form_close(); ?>
			</div>


			
		</div>

	</div>

	<!-- Fin de balise classe "row "qui se trouve dans la page sommaire -->
	</div> 
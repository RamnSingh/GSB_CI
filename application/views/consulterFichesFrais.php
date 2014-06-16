	<div class="col-md-10 col-sm-9 col-xs-8">
		
		<div id="contenu">
			
			<?php 
				if($this->session->userdata("utilisateur")['idType'] === "V"){
			?>

				<div class="alert alert-info h3">
					
					Mes fiches de frais
				
				<hr>
				
					<div class="table-responsive bg-primary">
						<table class="table">
						
								<tr>
									<td class="col-md-4"><span class="h3 color-white">Sélectionner un mois :</span></td>
									<td class="col-md-6">
										<select name="mois" class="form-control input-lg" id="mois">

											<?php 
												foreach ($moisFicheFrais as $key => $ficheFrais) {
											?>
											<option value="<?php echo $ficheFrais['mois']; ?>"><?php echo obtenirLibelleMois(substr($ficheFrais['mois'], 4))." ".substr($ficheFrais['mois'], 0, 4); ?></option>
											<?php
												}
											?>
										  
										</select>
									</td>
                                                                        <td class="col-md-2"><button class="btn btn-success btn-lg" id="fiche-frais-detail-btn" value="<?php echo site_url("visiteur/getDetailFicheFrais") ?>">Afficher</button></td>
								</tr>
								

						</table>
					</div>

					<!-- Contenu ajoute par ajax -->

					<hr>

					<div id="fiche-frais-detail">
						
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
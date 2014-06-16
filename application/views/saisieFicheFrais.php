	<div class="col-md-10 col-sm-9 col-xs-8">
		
		<div id="contenu">
			
			<?php 
				if($this->session->userdata("utilisateur")['idType'] === "V"){
			?>

				<div class="alert alert-info h3">
					Renseigner ma fiche de frais du mois de Juin 2014
				
				<hr>
				<!-- Fiches de frais forfaits -->
                                
                                <?php
                                                if(validation_errors() != FALSE){
                                            ?>
                                            <div class="alert alert-danger text-danger h4">
                                                <?php echo validation_errors(); ?>
                                            </div>
                                            <?php 
                                                }else{
                                                    echo $this->session->flashdata('succes');

                                                }
                                            ?>

				<div class="panel panel-primary">
					<div class="panel-heading">
						<span class="h4">Eléments forfaitisés</span>
					</div>
					<div class="panel-body">
                                            
                                           

						<div class="table-responsive">
							<table class="table table-hover borderless">
							
								<?php echo form_open('visiteur/ajouterLigneFrais'); ?>
									<?php 
                                                                        
										foreach ($forfaitElements as $forfaitElement) {
									?>
									<tr>
										<td><label for="<?= $forfaitElement['idFraisForfait']; ?>">* <?= $forfaitElement['libelle']; ?></label></td>
										<td><input type="number" min="0" id="<?= $forfaitElement['idFraisForfait']; ?>" class="form-control" name="<?= $forfaitElement['idFraisForfait']; ?>" value="<?= $forfaitElement['quantite']; ?>" placeholder="<?= $forfaitElement['libelle']; ?>"></td>
									</tr>
									<?php
										}
									?>
									<tr>
										<td></td>
										<td>
											<input type="submit" class="btn btn-primary">
											<input type="reset" class="btn btn-danger">
										</td>
									</tr>
									
								</form>

							</table>
						</div>

					</div>
				</div>
				<hr>
                                
                                
                                 <!--Affichage des elements hors forfait-->
                                
                                <?php
                                    if(isset($horsForfaitElements)){
                                ?>
                                 
                                 <p style="text-align: center"><span class="label label-primary">Descriptif des éléments hors forfait</span></p>
                                 <br>
                                
                                <div class="well well-sm">
                                    <div class="table-responsive">
                                    
                                    <table class="table table-bordered">
                                        
                                        <tr class="info">
                                            <th>Date</th>
                                            <td>Libelle</td>
                                            <td>Montant</td>
                                            <td>Action</td>
                                        </tr>
                                        
                                        <?php
                                            foreach ($horsForfaitElements as $nomColonne => $horsForfaitElement) {
                                              ?>
                                        <tr>
                                            <td><?php echo $horsForfaitElement['date']; ?></td>
                                            <td><?php echo $horsForfaitElement['libelle']; ?></td>
                                            <td><?php echo $horsForfaitElement['montant']; ?></td>
                                            <td>
                                                <?php 
                                                    
                                                    echo form_open("visiteur/supprimerLigneFicheHorsForfait");
                                                    echo form_hidden('id',$horsForfaitElement['id']);
                                                    $data = array(
                                                        'class' => 'btn btn-danger',
                                                        'value' => 'Supprimer'
                                                    );
                                                    echo form_submit($data);
                                                    echo form_close();
                                                
                                                ?>
                                                    
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        
                                    </table>
                                    
                                </div>
                                </div>
                                <?php
                                    }
                                ?>
                                 <hr>
                                

				<!-- Nouvel élément hors forfait -->

				<div class="panel panel-primary">
					<div class="panel-heading">
						<span class="h4">Nouvel élément hors forfait</span>
					</div>
					<div class="panel-body">
                                            
                                            

						<div class="table-responsive">
							<table class="table table-hover borderless">
							
								<?php echo form_open('visiteur/ajouterLigneFraisHorsForfait'); ?>
									<tr>
										<td><label for="date">* Date</label></td>
										<td><input type="date" id="date" class="form-control" name="date" ></td>
									</tr>
									<tr>
										<td><label for="libelle">* Libellé</label></td>
										<td><input type="text" id="libelle" class="form-control" name="libelle" placeholder="Libellé"></td>
									</tr>
									<tr>
										<td><label for="montant">* Montant</label></td>
										<td><input type="text" id="montant" class="form-control" name="montant" placeholder="Montant"></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<input type="submit" class="btn btn-primary">
											<input type="reset" class="btn btn-danger">
										</td>
									</tr>
									
								</form>

							</table>
						</div>

					</div>
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
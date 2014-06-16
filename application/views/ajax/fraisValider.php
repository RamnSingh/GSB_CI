<div class="panel panel-primary">
    
    <div class="panel-header h3">
        Frais au forfait
        <hr>
    </div>
    
    <div class="panel-body">
        
        <div class="table-responsive">
            
            <table class="table table-bordered">
                
                <tr>
                    <th>Forfait Etape</th>
                    <th>Frais Kilometrique</th>
                    <th>Nuitee Hotel</th>
                    <th>Repas Restaurant</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <input type="hidden" id="controllerActualiser" value="<?php echo site_url('comptable/actualiserFraisForfait'); ?>" />
                <?php
                    foreach ($fraisForfait as $frais) {
                ?>
                
                
                    <td><input type="number" id="<?php echo $frais['idFraisForfait']; ?>" class="form-control" value="<?php echo $frais['quantite'] ?>"/></td>
                
                <?php
                    }
                ?>
                    <td><button class="btn btn-warning" id="actualiserBtn">Actualiser</button></td>
                </tr>
            </table>
            
        </div>
        
    </div>
    
    <div class="panel-header h3">
        Hors forfait
        <hr>
    </div>
    
    <div class="panel-body">
        
        <ul class="list-inline">
            <li>
                Nombre de justificatifs : 
            </li>
            <li>
                <input type="number" id="<?php echo $ficheDetail['idVisiteur']; ?>" class="form-control" value="<?php echo $ficheDetail['nbJustificatifs'] ?>;" />
            </li>
        </ul>
        <div class="table-responsive">
            
            <table class="table table-bordered">
                
                <tr>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Montant</th>
                    <th>Actions</th>
                </tr>
                <?php
                
                    foreach ($fraisHorsForfait as $fraisHF) {
                ?>
                
                <tr id="<?php echo $fraisHF['id']; ?>">
                    <td><input type="date" name="date" class="form-control" value="<?php echo $fraisHF['date']; ?>"/></td>
                    <td><input type="text" name="libelle" class="form-control" value="<?php echo $fraisHF['libelle']; ?>"/></td>
                    <td><input type="number" name="montant" class="form-control" value="<?php echo $fraisHF['montant']; ?>"/></td>
                    <td>
                        <div class="btn-group">
                            <?php 
                                if(strpos($fraisHF['libelle'], 'REFUSE :') !== false){
                            ?>
                            <input type="button" class="btn btn-success"  name="<?php echo site_url('comptable/reintegrerFicheFraisHorsForfait'); ?>" id="reintegrerBtnHF" value="Reintegrer"/>
                            <?php
                                }else{
                            ?>
                            <input type="button" class="btn btn-warning"  name="<?php echo site_url('comptable/actualiserFicheFraisHorsForfait'); ?>" id="actualiserBtnHF" value="Actualiser"/>
                            <input type="button" class="btn btn-default"  name="<?php echo site_url('comptable/reporterFicheFraisHorsForfait'); ?>" id="reporterBtnHF" value="Reporter"/>
                            <input type="button" class="btn btn-danger"  name="<?php echo site_url('comptable/refuserFicheFraisHorsForfait'); ?>" id="supprimerBtnHF" value="Supprimer"/>
                         <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php
                    }
                ?>
                    
                </tr>
            </table>
            
        </div>
        
        
        
    </div>
    
    
    
</div>
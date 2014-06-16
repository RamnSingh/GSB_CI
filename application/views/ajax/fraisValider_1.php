<div class="panel panel-primary">
    
    <div class="panel-header h3">
        Frais au forfait
        <hr>
    </div>
    
    <div class="panel-body">
        
        <div class="table-responsive">
            
            <table class="table table-bordered">
                
                <tr>
                    <th>Repas</th>
                    <th>Nuitée</th>
                    <th>Etape</th>
                    <th>KM</th>
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
        
        <div class="table-responsive">
            
            <table class="table table-bordered">
                
                <tr>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Montant</th>
                    <th>Actions</th>
                </tr>
                <?php
                
                                var_dump($fraisHorsForfait);
                    foreach ($fraisHorsForfait as $fraisHF) {
                ?>
                
                <tr>
                    <td><input type="date" class="form-control" value="<?php echo $fraisHF['date'] ?>"/></td>
                    <td><input type="text" class="form-control" value="<?php echo $fraisHF['libelle'] ?>"/></td>
                    <td><input type="number" class="form-control" value="<?php echo $fraisHF['montant'] ?>"/></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success" id="reporterBtn">Reporter</button>
                            <button type="button" class="btn btn-danger" id="supprimerrBtn">Supprimer</button>
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
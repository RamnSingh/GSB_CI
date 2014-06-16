<div class="panel panel-primary">
    <?php
        if($fiche){
       ?>
    <div class="panel-heading">
        <span class="h3">
            Fiche de frais de mois de 
            <?php
                echo obtenirLibelleMois(substr($fiche['mois'], 4))." ".substr($fiche['mois'], 0, 4); 
            ?>
        </span>
    </div>
    
    <div class="panel-body" style="text-align: left">
       
         Etat de fiche : 
        <span class="label label-info">
            <?php
                echo $fiche['libelleEtat'];
            ?>
        </span>
        <br>
        <br>
        Montant validé :
        <span class="label label-info">
            <?php
                echo $fiche['montantValide'];
            ?>
        </span>
        
        <br>
        <hr>
        <?php
        }
        
        if($forfaitElements){
        ?>
        <p style="text-align: center"><span class="label label-default">Quantités des éléments forfaitisés</span></p>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr class="active">
                 <?php 
                    foreach ($forfaitElements as $element) {
                ?>
                    <th class="text-center">
                        <?php
                            echo $element['libelle'];
                        ?>
                    </th>
                <?php
                    }
                ?>
                </tr>
                <tr>
                <?php 
                    foreach ($forfaitElements as $element) {
                ?>
                    <td class="text-center">
                        <?php
                            echo $element['quantite'];
                        ?>
                    </td>
                <?php
                    }
                ?>
                </tr>
            </table>
        </div>
        <?php
            } 
        
           if($horsForfaitElements){
            
        ?>
        <br>
        <hr>
        
        <p style="text-align: center"><span class="label label-default">Descriptif des éléments hors forfait</span></p>
        <br>
        
        <?php
            if($fiche){
        ?>
        Justificatifs reçus : 
        <span class="label label-info">
            <?php
                echo $fiche['nbJustificatifs'];
            ?>
        </span>
        <?php
            }
        ?>
        
        <br>
        <br>
        
        
         <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr class="active">
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Montant</th>
                </tr>
                <?php 
                    foreach ($horsForfaitElements as $element) {
                ?>
                <tr>
                    <td class="text-center">
                        <?php
                            echo $element['date'];
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            echo $element['libelle'];
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            echo $element['montant'];
                        ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        
        <?php
           }
         ?>
        
        <div class="panel-footer">
             <?php
            if($fiche){
        ?>
            <form action="<?php echo site_url("visiteur/getPDF"); ?>" method="POST">
                <input type="hidden" name="mois" value="<?php echo $fiche['mois']; ?>" />
                <input type="submit" class="btn btn-success btn-lg" value="Exporter au format PDF" />
            </form>
             <?php
            }
        ?>
        </div>
    </div>
    
</div>
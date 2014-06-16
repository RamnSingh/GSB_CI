<html>
    <head>
        <link rel="stylesheet" href="<?= base_url().'assets/css/bootstrap.min.css' ?>">
	<link rel="stylesheet" href="<?= base_url().'assets/css/style.css' ?>">
    </head>
    <body style="background-color: #fff;">
	

<?php $total = 0; ?>
        
        
        <div class="container PDFpage">
    
    <!-- Entete de PDF -->
    <div id="PDFEntete">
        <img src="<?php echo base_url("assets/images/logo.jpg"); ?>" >
    </div>
    <br>
    <br>
    <div class="PDFContenu">
        <h2 class="titre">REMBOURSEMENT DE FRAIS ENGAGÉ</h2>
        
        <div class="visiteur-info">
            Visiteur : <?php echo $visiteur['idUtilisateur']; ?>
            <br>
            Nom : <?php echo $visiteur['nom']; ?>
            <br>
            Prenom : <?php echo $visiteur['prenom']; ?>
            <br>
            Mois : <?php echo $mois; ?>
        </div>
        
        <div class="visiteur-forfait-table">
            <table class="table table-bordered">
                
                <!-- Entete de table -->
                <tr>
                    <th>Frais forfaitaires</th>
                    <th>Quantité</th>
                    <th>Montant unitaire</th>
                    <th>Total</th>
                </tr>
                
                <?php
                    foreach ($forfaitElements as $forfaitElement) {
                ?>
                        <tr>
                            <td>
                                <?php
                                    echo $forfaitElement['libelle'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $forfaitElement['quantite'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $forfaitElement['montantUnitaire'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    $total += (float)$forfaitElement['quantite'] * (float)$forfaitElement['montantUnitaire'];
                                    echo (float)$forfaitElement['quantite'] * (float)$forfaitElement['montantUnitaire'];
                                ?>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        
        <p class="text-primary h3">Autres Frais</p>
        
        <div class="visiteur-hors-forfait-table">
            <table class="table table-bordered">
                
                <!-- Entete de table -->
                <tr>
                    <th>Date</th>
                    <th>Libellé</th>
                    <th>Montant</th>
                </tr>
                
                <?php
                    foreach ($horsForfaitElements as $horsForfaitElement) {
                ?>
                        <tr>
                            <td>
                                <?php
                                    echo $horsForfaitElement['date'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $horsForfaitElement['libelle'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    $total += (float)$horsForfaitElement['montant'];
                                    echo (float)$horsForfaitElement['montant'];
                                ?>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        
        <div class="table-responsive total-frais">
            
            <table class="table table-bordered">
                <tr>
                    <th>
                        Total
                    </th>
                    <td>
                        <?php echo $total; ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="signature">
            <p>Fait à Paris, le <?php echo $date; ?> </p>
            <p>Vu l'agent comptable</p>
            <img src="<?php echo base_url("assets/images/signatureComptable.png"); ?>" >
        </div>

    </div>
</div>

    </body>
</html>
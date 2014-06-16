function afficheFicheFrais(moisFiche, urlController){
	$.ajax({
		type: 'POST',
		url: urlController,
		data: { mois : moisFiche },
		success: function(resultat){
			$("#fiche-frais-detail").html(resultat);
		}
	});
}

function afficheTousLesMois(visiteur, urlController){
    $.ajax({
		type: 'POST',
		url: urlController,
		data: { idVisiteur : visiteur },
		success: function(resultat){
                        if(resultat === ""){
                            $("#moisVisiteur").hide();
                            $("#pasDeFiche").show();
                        }else{
                            $("#pasDeFiche").hide();
                            $("#moisVisiteur").show().html(resultat);
                        }
                        
                        
		}
	});
}

function afficheFraisCorrespondant(visiteur, moisChoisi, urlController){
    $.ajax({
		type: 'POST',
		url: urlController,
		data: { idVisiteur : visiteur, mois : moisChoisi},
		success: function(resultat){
                        $("#fraisCorrespondant").html(resultat);
		}
	});
}

function  actualiserFraisForfait(visiteur, moisChoisi, etapeChoisi, kilometreChoisi, nuiteeChoisi, repasChoisi, urlController){
    $.ajax({
		type: 'POST',
		url: urlController,
		data: { idVisiteur : visiteur, mois : moisChoisi, etape : etapeChoisi, kilometre : kilometreChoisi, nuitee : nuiteeChoisi, repas : repasChoisi},
		success: function(resultat){
                        $("#fraisCorrespondant").html(resultat);
		}
	});
}

function supprimerFraisHorsForfait(visiteur, moisChoisi, idFraisHF, urlController){
     $.ajax({
		type: 'POST',
		url: urlController,
		data: { idVisiteur : visiteur, mois : moisChoisi, idFraisHorsForfait : idFraisHF},
		success: function(resultat){
                        $("#fraisCorrespondant").html(resultat);
		}
	});
}

$(document).ready(function(){
        $("#pasDeFiche").hide();
        
	$("#fiche-frais-detail-btn").click(function(){
		var moisFiche = $("#mois").val();
                var url = $(this).attr("value");
		afficheFicheFrais(moisFiche, url);
		return false;
	});
        
        $("#visiteursSelect").change(function(){
            var visiteurID = $(this).val();
            var url = $(this).attr("name");
            afficheTousLesMois(visiteurID, url);
        });
        
        $('body').on("change", "#moisSelect", function(){
            var visiteurID = $("#visiteursSelect").val();
            var mois = $(this).val();
            var url = $(this).attr("name");
            afficheFraisCorrespondant(visiteurID, mois, url);
        });
        
        $('body').on("click", "#actualiserBtn", function(){
           var idVisiteur = $("#visiteursSelect").val();
           var mois = $("#moisSelect").val();
           var etape = $("#ETP").val(); 
           var kilometre = $("#KM").val(); 
           var nuitee = $("#NUI").val(); 
           var repas = $("#REP").val();
           var url = $('#controllerActualiser').val();
           
           actualiserFraisForfait(idVisiteur, mois, etape, kilometre, nuitee, repas, url);
        });
        
        $('body').on("click", "#supprimerBtnHF", function(){
           var idVisiteur = $("#visiteursSelect").val();
           var mois = $("#moisSelect").val();
           var idFraisHF = $(this).parent().parent().parent().attr("id");
           var url       = $(this).attr("name");
           
           supprimerFraisHorsForfait(idVisiteur, mois, idFraisHF, url);
        });
        
        
});


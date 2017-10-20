// Remplacer le sous-titre par un texte de notre choix
$('#sous-titre').html($('table tbody tr').length + ' lignes');

// Détection d'un changement sur les boîtes à cocher
$('tbody').on('change', '.checkbox', function(){ // tbody délègue l'événement onchange aux objets .checkbox
    console.log('On a détecté un changement sur la boîte : ' + $(this).attr('id'));

    if($(this).is(':checked')){
        // La boîte est cochée, on active le bouton de suppression
        $('#btn-delete').attr('disabled', false);
    } else {
        let disableButton = true; // On part du principe qu'une boîte au moins est encore cochée
        $('.checkbox').each(function() {
            //console.log('Parcourt ' + $(this).attr('id'));
            if($(this).is(':checked')){
                disableButton = false;
                return false;
            }
        });
        // En fin de parcours, on voit ce qu'on fait
        $('#btn-delete').attr('disabled', disableButton);
        //$('#btn-delete').prop('disabled', disableButton);
    }
});

// Modifier l'animation du chargement de la modale
$('#suppModal').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog  flipInY  animated');
});

// On peut gérer le clic sur la confirmation de suppression du dialogue
$('#btn-confirm-suppr').on('click', function(){
    // Récupérer la liste des identifiants à supprimer
    let datas = [];
    let notifyingMessage = new String('Les lignes suivantes ont été supprimées :<br />\n');
    let fadeoutTime = 0;
    let rowNumbers = $('table tbody tr').length;

    // Boucle sur les boîtes cochées uniquement
    $('.checkbox:checked').each(function(){
        datas.push({id: $(this).attr('id')}); // Ajoute un objet au tableau
    });
    console.log('Données à supprimer : ' + JSON.stringify(datas));
    // On va pouvoir maintenant appeler le script en lui passant les paramètres
    $.ajax(
        {
            url: 'http://initpoo.dev/index.php?com=DossiersDelete',
            dataType: 'json',
            method: 'post',
            data: JSON.stringify(datas),
            contentType: 'application/json; charset=utf-8',
            success: function(result){
                console.log('Okay, le script s\'est exécuté, on récupère : ' + JSON.stringify(result));
                let rowsToDelete = result.length; // Nombre de lignes à supprimer
                $('.checkbox:checked').each(function(){
                    notifyingMessage += $(this).attr('id') + '<br />\n';
                    let _tr = $(this).parents('tr');
                    console.log('Efface la ligne : ' + _tr.attr('id'));
                    _tr.addClass('fadeout');
                    window.setTimeout(function(){doRemove(_tr)}, 2000);
                    fadeoutTime += 2000;
                });
                // Mise à jour du compteur de lignes
                let newRowNumbers = rowNumbers - rowsToDelete;
                $('#sous-titre').html(newRowNumbers + ' lignes');

                // Désactivation du bouton Trash
                $('#btn-delete').attr('disabled', true);

                // Affiche la notification en fin de suppression
                let toast = $('#toast'); // Récupère l'élément toast du DOM
                var toastContent = $('#row-id');
                toast.removeClass('inactive').addClass('active');
                toastContent.html('').html(notifyingMessage); // Chainage de méthodes
                window.setTimeout(function(){toast.removeClass('active').addClass('inactive');}, fadeoutTime);
            },
            error: function(err){
                console.log('Pas bien...');
            }
        }
    );
});

function doRemove(row){
    //console.log('ID à traiter ' + row.attr('id'));
    row.remove();
}

/**
 * Gestion de la mise à jour du tableau des dossiers toutes les n millisecondes
 */
window.setInterval(doRefreshOptimized, 60000);

function doRefreshOptimized(){
    // Avant toute chose... un peu de déco...
    $('body').css('opacity', .5);
    // Montre la modale de chargement
    $('#outer-modal').removeClass('inactive');

    $.ajax({
        url: 'http://initpoo.dev/index.php?com=ReloadDossiers',
        dataType: 'json', // Le format dont les données sont attendues en retour,
        success: function(result){
            // Mise à jour du compteur de lignes
            $('#sous-titre').html(result.length + ' lignes');

            // Etape 1 : Déterminer les modifications par rapport à l'existant
            $.each(result, function(index, dossier){
                // Retrouver la ligne du tableau qui correspond
                let _TRId = '#id_' + dossier.id; // Chaîne qui contient l'identifiant du TR dans le tableau
                if($(_TRId) === null || $(_TRId) == 'undefined'){
                    dossier.newLine = true;
                } else {
                    let _TRUpdate = moment($(_TRId).data('lastupdate')); // On instancie un objet moment() pour la gestion des dates
                    let _DBUpdate = moment(dossier.last_update);
                    if(!_TRUpdate.isSame(_DBUpdate)){
                        dossier.isUpdated = true;
                    }
                }
                // La boîte pour ce dossier est-elle cochée
                if($('#' + dossier.id).prop('checked')){
                    dossier.isChecked = true;
                }
                result[index] = dossier; // Remplace l'objet dans le tableau final
            });
            
            // Etape 2 : Effacement des lignes du tableau courant
            $('table tbody tr').remove();

            // Etape 3 : Reconstruit le tableau à partir des données mises à jour
            let enableTrashButton = false;

            $.each(result, function(index, dossier){
                // Traite une nouvelle ligne
                let newTR = $('<tr>');
                newTR.attr('id', 'id_' + dossier.id);
                newTR.attr('data-lastupdate', dossier.last_update);
                
                if(dossier.hasOwnProperty('isUpdated')){ // La propriété isUpdated est-elle définie
                    newTR.css('background-color', 'rgba(128, 128, 128, .5)');
                }
                
                if(dossier.hasOwnProperty('newLine')){
                    newTR.css('background-color', 'rgba(68,157,68, .7)');
                }

                // Traite les colonnes de la ligne courante
                let checkboxTD = $('<td>');
                let checkbox = $('<input>');
                checkbox
                    .attr('type', 'checkbox')
                    .addClass('checkbox')
                    .attr('name', 'check_' + dossier.id)
                    .attr('id', dossier.id);
                if(dossier.hasOwnProperty('isChecked')){
                    checkbox.attr('checked', true);
                    enableTrashButton = true;
                }
                // Ajoute la boîte à cocher au TD courant
                checkbox.appendTo(checkboxTD);

                // Ajoute le TD à la ligne courante
                checkboxTD.appendTo(newTR);

                // Id, Nom, téléphone et e-mail
                let idTD = $('<td>');
                idTD.html(dossier.id);
                idTD.appendTo(newTR);

                let nomTD = $('<td>');
                nomTD.html(dossier.nom);
                nomTD.appendTo(newTR);

                let portableTD = $('<td>');
                portableTD.html(dossier.portable);
                portableTD.appendTo(newTR);

                let mailTD = $('<td>');
                mailTD.html(dossier.email);
                mailTD.appendTo(newTR);

                // Ajoute la ligne à tbody
                newTR.appendTo('table tbody');
            });
            console.log('enableTrashButton : ' + enableTrashButton ? ' actif' : 'inactif');
            $('#btn-delete').attr('disabled', !enableTrashButton);
        }        
    });
    $('#outer-modal').addClass('inactive');
    $('body').css('opacity', 1);
}

function doRefresh(){
    console.log('Recharger la liste des dossiers');
    $.ajax({
       url: 'http://initpoo.dev/index.php?com=ReloadDossiers',
       dataType: 'json', // Le format dont les données sont attendues en retour,
       success: function(result){ // La méthode appelée en cas de succès, result contient les données retournées
            //console.log('Nombre de lignes retournées : ' + result.length);
            $.each(result, function(index, dossier){
                //console.log('Dossier : ' + JSON.stringify(dossier));
                
                // Retrouver la ligne du tableau qui correspond
                let _TRId = '#id_' + dossier.id; // Chaîne qui contient l'identifiant du TR dans le tableau

                //let _TRLastUpdate = $(_TRId).attr('data-lastupdate');
                // Méthode data permet de récupérer un attribut qui commence par data-
                // L'argument passé en paramètre est le suffixe de l'attribut data correspondant
                let _TRUpdate = moment($(_TRId).data('lastupdate')); // On instancie un objet moment() pour la gestion des dates
                let _DBUpdate = moment(dossier.last_update);

                if(!_DBUpdate.isSame(_TRUpdate)){
                    console.log('Mise à jour détectée sur ' + _TRId);
                    
                    // Dans un premier temps, on met à jour l'attribut data-lastupdate
                    $(_TRId).attr('data-lastupdate', dossier.last_update);

                    // On doit aussi changer la couleur de fond pour indiquer à l'utilisateur une mise à jour
                    $(_TRId).css('background-color', 'rgba(128, 128, 128, .5)');

                    // Et finalement, remplacer les contenus des TD (sauf l'ID et la boîte à cocher) par les nouvelles valeurs
                    let nom = $('tr' + _TRId + " td:nth-child(3)"); // $('#id_16000 td:nth-child(3))
                    let portable = $('tr' + _TRId + " td:nth-child(4)");
                    let email = $('tr' + _TRId + " td:nth-child(5)");

                    $(nom).html('').html(dossier.nom);
                    $(portable).html('').html(dossier.portable);
                    $(email).html('').html(dossier.email);
                } else {
                    console.log('Pas de modification à faire sur ' + _TRId);
                }
                result[index] = dossier;
            })
       },
       error: function(error){ // En cas d'échec, on arrive ici avec une erreur dans error

       }

    })
}
			// Modification du contenu de l'élément dont l'ID est sous-titre
			console.log('Exécution de javascript');
			var id = new String('sous-titre');
			document.getElementById(id).innerHTML = 'Hello Javascript';

			// Alterner les couleurs des lignes du tableau
			var bodyTR = document.getElementsByTagName('tr');
			console.log('Le tableau contient ' + bodyTR.length + ' éléments');
			/*
			for(var i=1; i < bodyTR.length; i++){
				var _TR = bodyTR[i]; // Récupère la ligne concernée
				if(i % 2 !== 0){
					// Il s'agit d'une ligne impaire, on applique la classe odd
					_TR.setAttribute('class', 'odd');
				}
			}
			*/

			/**
			* Fonction supprimerLigne()
			**/
			function supprimerLigne(id){
				var modal = document.getElementById('outer-modal');
				var classList = modal.classList;
				classList.remove('inactive');

				// On définit ce qui doit se passer lors d'un clic sur les boutons
				// de la modale
				var btnOk = document.getElementById('btn-ok');
				var btnCancel = document.getElementById('btn-cancel');

				btnOk.onclick = function(){
					var bodyTR = document.getElementsByTagName('tr');
					var _TRtoDelete = null;
					for(var i=1; i < bodyTR.length; i++){
						var _TR = bodyTR[i];
						var _firstTD = _TR.firstElementChild;
						//console.log('Contenu du premier TD : ' + _firstTD.innerHTML);
						if(_firstTD.innerHTML == id){
							_TRtoDelete = _TR; // Stocke l'élément à supprimer
						}
					}
					if(_TRtoDelete !== null){
						console.log('C\'est cool, on peut supprimer la ligne : ' + _TRtoDelete.firstElementChild.innerHTML);
						
						// Appliquons une classe support pour l'effacement progressif
						_TRtoDelete.setAttribute('class','fadeout');
						// Pour pouvoir passer un paramètre à la fonction exécutée
						// par setTimeout, on passe par une fonction anonyme
						// qui elle peut appeler une autre fonction avec
						// un ou plusieurs paramètres
						window.setTimeout(function(){doRemove(_TRtoDelete)}, 2000);
					}
					dismiss();
				}

				btnCancel.onclick = function(){
					dismiss();
				}

				/**
				* Avec boîte de dialogue standard
				if(window.confirm('Etes-vous sûr de vouloir supprimer la ligne : ' + id)){
					var bodyTR = document.getElementsByTagName('tr');
					var _TRtoDelete = null;
					for(var i=1; i < bodyTR.length; i++){
						var _TR = bodyTR[i];
						var _firstTD = _TR.firstElementChild;
						//console.log('Contenu du premier TD : ' + _firstTD.innerHTML);
						if(_firstTD.innerHTML == id){
							_TRtoDelete = _TR; // Stocke l'élément à supprimer
						}
					}
					if(_TRtoDelete !== null){
						console.log('C\'est cool, on peut supprimer la ligne : ' + _TRtoDelete.firstElementChild.innerHTML);
						
						// Appliquons une classe support pour l'effacement progressif
						_TRtoDelete.setAttribute('class','fadeout');
						// Pour pouvoir passer un paramètre à la fonction exécutée
						// par setTimeout, on passe par une fonction anonyme
						// qui elle peut appeler une autre fonction avec
						// un ou plusieurs paramètres
						window.setTimeout(function(){doRemove(_TRtoDelete)}, 2000);
					}
				}
				**/
			}

			function doRemove(row){
				var table = document.getElementsByTagName('tbody')[0];
				table.removeChild(row);
				var toast = document.querySelector('#toast'); // Récupère l'élément toast du DOM
				var toastContent = document.querySelector('#row-id');
				toastContent.innerHTML = '';
				toastContent.innerHTML = row.firstElementChild.innerHTML;
				var classList = toast.classList;
				if(classList.contains('inactive')){
					classList.remove('inactive');
					classList.add('active');
					window.setTimeout(function(){classList.remove('active');classList.add('inactive');}, 1700);
				}
			}

			/**
			* Fait disparaître la boîte modale
			**/
			function dismiss(){
				var modale = document.getElementById('outer-modal');
				var classList = modale.classList;
				classList.add('dismiss'); // Animation rideau...
				window.setTimeout(
					function(){
						classList.remove('dismiss');
						classList.add('inactive');
					},
					2500
				);
				
            }
            
            /**
             * Détection des actions groupées
             */
            var checkDetection = function(theCheckbox){
                console.log('La boîte qui a changé porte l\'ID : ' + theCheckbox.getAttribute('id'));

                // L'élément est-il coché
                if(theCheckbox.checked){
                    // Au moins une boîte est cochée... on active le bouton de suppression
                    document.getElementById('btn-delete').removeAttribute('disabled');
                } else {
                    // La boîte a été décochée, que doit-on faire ?
                    var checkboxes = document.getElementsByClassName('checkbox');
                    let lonesomeCheckbox = true;
                    for(let i=0; i < checkboxes.length; i++){
                        if(checkboxes[i].checked){
                            lonesomeCheckbox = false;
                        }
                    }
                    if(lonesomeCheckbox){
                        document.getElementById('btn-delete').setAttribute('disabled', true);
                    }
                }
            }
           
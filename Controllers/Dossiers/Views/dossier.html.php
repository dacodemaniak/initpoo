<?php
/**
**/
$dossiers = $composant->getDatas();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		
		<title>Liste des dossiers</title>
		
		<link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="./_assets/css/style.css">
		<link rel="stylesheet" href="./Controllers/Dossiers/Views/dossier.css">
		<link rel="stylesheet" href="/node_modules/animate.css/animate.min.css">
	</head>
	
	<body>
		<div id="page" class="container">
			<h1>Liste des dossiers</h1>
			<h2 id="sous-titre"></h2>
			
			<div id="toolbar">
				<button class="btn btn-danger" id="btn-delete" disabled data-toggle="modal" data-target="#suppModal"><i class="icon-bin"></i></button>
			</div>
			
			<table class="table table-striped table-condensed">
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>N°</th>
						<th>Nom</th>
						<th>Portable</th>
						<th>E-Mail</th>
						<!-- <th>Opération</th> -->
					</tr>
				</thead>
				
				<!--  Corps du tableau HTML -->
				<tbody>
					<?php 
						foreach($dossiers as $dossier){
							echo "<tr id=\"id_" . $dossier->id . "\" data-lastupdate=\"" . $dossier->last_update . "\">";
							//echo "<td><input type=\"checkbox\" class=\"checkbox\" name=\"check_" . $dossier->id . "\" id=\"" . $dossier->id . "\" onchange=\"checkDetection(this)\"></td>";
							echo "<td><input type=\"checkbox\" class=\"checkbox\" name=\"check_" . $dossier->id . "\" id=\"" . $dossier->id . "\"></td>";
							echo "<td>" . $dossier->id . "</td>";
							echo "<td>" . $dossier->nom . "</td>";
							echo "<td>" . $dossier->portable . "</td>";
							echo "<td>" . $dossier->email . "</td>";
							//echo "<td><button class=\"btn suppr\" onclick=\"supprimerLigne(" . $dossier->id . ");\"><span class=\"icon-bin\"></span></button></td>";
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>

		<div id="toast" class="toast alert alert-success inactive" aria-hidden="true">
			La ligne <span id="row-id"></span> a été supprimée.
		</div>
		
		<div id="outer-modal" class="inactive">
			<div id="inner-modal" class="inner">
				<img src="./_assets/images/ajax-loader.gif" class="loader">
			</div>
		</div>

		<!-- Modale Bootstrap 3 -->
		<div class="modal fade" id="suppModal" tabindex="-1" role="dialog" aria-labelledby="suppModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="suppModalLabel">Suppression</h4>
				</div>
				<div class="modal-body">
					Etes-vous sûr de vouloir supprimer ces lignes ?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" id="btn-confirm-suppr">Oui</button>
				</div>
				</div>
			</div>
		</div>

		<!-- Intégration des javascripts -->
		<script src="/node_modules/jquery/dist/jquery.min.js"></script>
		<script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="/node_modules/moment/min/moment.min.js"></script>
		<!--
		<script src="./Controllers/Dossiers/Views/dossier.js"></script>
		//-->
		<script src="./Controllers/Dossiers/Views/jquery.dossier.js"></script>
	</body>
</html>
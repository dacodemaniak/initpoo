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
</head>
<body>
	<h1>Liste des dossiers</h1>
	
	<table>
		<thead>
			<tr>
				<th>N°</th>
				<th>Nom</th>
				<th>Portable</th>
				<th>E-Mail</th>
			</tr>
		</thead>
		
		<!--  Corps du tableau HTML -->
		<tbody>
			<?php 
				foreach($dossiers as $dossier){
					echo "<tr>";
					echo "<td>" . $dossier->id . "</td>";
					echo "<td>" . $dossier->nom . "</td>";
					echo "<td>" . $dossier->portable . "</td>";
					echo "<td>" . $dossier->email . "</td>";
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</body>
</html>
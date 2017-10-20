<?php
/**
**/
header('Content-Type: application/json');
$dossiers = $composant->getDatas();
echo json_encode($dossiers);
?>
<?php
use comideafactory\Files\Import\ArcecImport;
use comideafactory\Files\ExcelFile;
use comideafactory\Database\MySQLConnexion;

/**
* @name index.php Dispatcher principal de l'application
* @author Idea Factory (dev-team@ideafactory.com) - Oct. 2017
* @package
* @version 1.0
**/

ini_set("display_errors", true);
error_reporting(E_ALL);


if(array_key_exists("com", $_GET)){
	// Le dispatcher voit qu'il faut charger un contrôleur particulier
	require_once("Controllers/" . $_GET["com"] . "/" . $_GET["com"] . ".class.php");
	$class = "\\ideafactory\\Controllers\\" . $_GET["com"] . "\\" . $_GET["com"];
	$composant = new $class;
	include($composant->getView());
	
} else {
	require_once("_Classes/Files/Import/ArcecImport.class.php");
	require_once("_Classes/Files/ExcelFile.class.php");
	
	require_once("_Classes/Database/MySQLConnexion.class.php");
	
	$connexion = new MySQLConnexion();
	
	// Instancie un nouvel objet pour le traitement d'un document Excel
	$arcec = new ArcecImport();
	
	if($arcec->isCorrectFile()){
		echo "On peut traiter le document ( " . $arcec->getSize() . " octets)";
		// Traite l'importation
		$arcec->process();
		
		// Fin de traitement, on dumpe la résultat
		//$arcec->dump();
	} else {
		echo "Impossible de traiter le document Excel.";
		echo $arcec->errors();
	}
}
<?php
use comideafactory\Files\Import\ArcecImport;
use comideafactory\Files\ExcelFile;

/**
* @name index.php Dispatcher principal de l'application
* @author Idea Factory (dev-team@ideafactory.com) - Oct. 2017
* @package
* @version 1.0
**/

ini_set("display_errors", true);
error_reporting(E_ALL);

/*
if(file_exists("base.xls")){
	echo "Okay, pas de souci !";
} else {
	echo "KO, impossible de voir ce foutu fichier";
}
*/

require_once("_Classes/Files/Import/ArcecImport.class.php");
require_once("_Classes/Files/ExcelFile.class.php");

/*
$excel = new ExcelFile("test", "Files/", "xslx");
if(!$excel->isCorrectFile()){
	echo "KO, on ne peut pas traiter le document Excel";
	echo $excel->errors();
} else {
	echo "OK, on peut traiter le document Excel";
}

die();
*/

// Instancie un nouvel objet pour le traitement d'un document Excel
$arcec = new ArcecImport();

if($arcec->isCorrectFile()){
	echo "On peut traiter le document ( " . $arcec->getSize() . " octets)";
	// Traite l'importation
	$arcec->process();
	
	// Fin de traitement, on dumpe la résultat
	$arcec->dump();
} else {
	echo "Impossible de traiter le document Excel.";
	echo $arcec->errors();
}
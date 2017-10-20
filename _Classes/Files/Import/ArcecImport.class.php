<?php
/**
* @name ArcecImport.class.php Traite l'importation d'un document spécifique Excel
* @author IdeaFactory - Oct. 2017
* @package comideafactory/Files/Import
* @version 1.0
**/

namespace comideafactory\Files\Import;

require_once(dirname(__FILE__) . "/../ExcelFile.class.php");
require_once(dirname(__FILE__) . "/../Import.class.php");

use comideafactory\Files\ExcelFile;
use comideafactory\Files\Import;
use RKD\PHPExcelFormatter\PHPExcelFormatter;
use comideafactory\Models\Scheme;

class ArcecImport extends ExcelFile implements Import {
	
	/**
	 * Type de sortie après importation
	 * - a => array,
	 * - m => mysql
	 * @var string
	 */
	protected $outputType = "a";
	
	/**
	 * Résultat de l'extraction du document Excel
	 * @var mixed
	 */
	protected $output;
	
	public function __construct(){
		parent::__construct("base", "Files/", "xlsx");
		
		if($this->isCorrectFile){
			// Définit les colonnes à importer
			$this->addColumn("N°");
			$this->addColumn("NOM");
			$this->addColumn("Portable");
			$this->addColumn("E-mail");
		}
	}
	
	/**
	 * Ajoute une colonne à traiter du document Excel
	 * @param string $columnName
	 */
	public function addColumn($columnName){
		if($this->hasHeaderLine)
			$this->columns[$columnName] = $columnName;
		else 
			$this->columns[] = $columnName;
	}
	
	/**
	 * Détermine le type de sortie souhaité après importation
	 * @param string $outputType
	 */
	public function setOutputType($outputType){
		$this->outputType = $outputType;
	}
	
	/**
	 * Traite l'importation proprement dite
	 */
	public function process(){
		if($this->isCorrectFile){
			require_once(dirname(__FILE__) . "/../../Vendor/PHPExcel/PHPExcel.php");
			require_once(dirname(__FILE__) . "/../../Vendor/PHPExcelFormatter/PHPExcelFormatter.class.php");
			require_once(dirname(__FILE__) . "/../../Vendor/PHPExcelFormatter/Exception/PHPExcelFormatterException.class.php");
			
			$formatter = new PHPExcelFormatter($this->path . $this->name . "." . $this->extension);
			$formatter->setFormatterColumns($this->columns);
			
			$this->output = $formatter->output($this->outputType);
			
			// On peut procéder à la mise à jour de la base de données
			$this->toSQL();
			
		}
	}
	
	/**
	 * Affiche la données brute traitée
	 */
	public function dump(){
		var_dump($this->output);
	}
	
	/**
	 * Mappe le contenu original vers la base de données pour insertion
	 */
	private function toSQL(){
		require_once(dirname(__FILE__) . "/../../Models/Dossier/Scheme.class.php");
		$scheme = new Scheme();
		
		$insertRows = array();
		$insertRow = array();
		
		// Définit le mappage entre le document Excel et les colonnes SQL
		$scheme->addMap("N°", "id")
			->addMap("NOM", "nom")
			->addMap("Portable", "portable")
			->addMap("E-mail", "email");
		
		foreach($this->output as $row){
			foreach($row as $excelCol => $value){
				$object = $scheme->find($excelCol);
				$object->value($value);
				
				$insertRow[] = $object;
			}
			
			$insertRows[] = $insertRow; // Range la ligne dans un autre tableau
			$insertRow = array(); // Réinitialise le tableau pour une ligne
		}
		
		// En sortie de traitement, toutes les lignes sont mappées
		$scheme->save($insertRows);
	}
}
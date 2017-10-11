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
		parent::__construct("Base_Arcec", "Files/", "xslx");
		
		if($this->isCorrectFile){
			// Définit les colonnes à importer
			$this->addColumn("N°");
			$this->addColumn("Nom");
			$this->addColumn("Date");
			$this->addColumn("Conseiller");
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
			require_once(dirname(__FILE__) . "/../../Vendor/PhpExcelFormatter/PHPExcelFormatter.class.php");
			require_once(dirname(__FILE__) . "/../../Vendor/PhpExcelFormatter/Exception/PHPExcelFormatterException.class.php");
			
			$formatter = new PHPExcelFormatter($this->path . $this->name . "." . $this->extension);
			$formatter->setFormatterColumns($this->columns);
			
			$this->output = $formatter->output($this->outputType);
			
		}
	}
	
	/**
	 * Affiche la données brute traitée
	 */
	public function dump(){
		var_dump($this->output);
	}
}
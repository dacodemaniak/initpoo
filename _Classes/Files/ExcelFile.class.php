<?php
/**
* @name ExcelFile.class.php Service de gestion d'un document Excel
* @author IdeaFactory
* @package comideafactory\Files
* @version 1.0
**/

namespace comideafactory\Files;

/**
 * Requiert la classe parente abstraite
 */
require_once(dirname(__FILE__) ."/File.class.php");

class ExcelFile extends Files{
	
	/**
	 * Tableau des colonnes à traiter
	 * @var array
	 */
	protected $columns;
	
	/**
	 * Détermine si le document Excel dispose d'une ligne d'en-tête ou non.
	 * Vrai par défaut
	 * @var boolean
	 */
	protected $hasHeaderLine = true;
	
	/**
	 * Constructeur de la classe
	 * @param string $name Nom du fichier sans l'extension
	 * @param string $path Chemin relatif vers le fichier
	 * @param string $extension Extension associée
	 */
	public function __construct($name, $path, $extension){
		$this->extensionsAllowed = array(
			"xls", "xlsx", "ods", "csv"		
		);

		$this->extension = $extension;
		$this->name = $name;
		$this->path = $path;
		
		$this->isCorrectFile();
		
		/**
		 * Attention, utiliser la classe PHP finfo pour déterminer
		 * le type MIME du document, afin de s'assurer de sa conformité
		**/
	}
}
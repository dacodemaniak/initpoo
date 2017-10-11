<?php
/**
* @name File.class.php Abstraction de classe pour les opérations standard sur les fichiers
* @author ideaFactory (dev-team@ideafactory.com) - Oct. 2017
* @package comideafactory\Files
* @version 1.0
**/

namespace comideafactory\Files;

abstract class Files {
	
	/**
	 * Nom du fichier concerné
	 * @var string
	 */
	protected $name;
	
	/**
	 * Extension du fichier
	 * @var string
	 */
	protected $extension;
	
	/**
	 * Chemin vers le fichier à traiter
	 * @var string
	 */
	protected $path;
	
	/**
	 * Taille du fichier
	 * @var int
	 */
	protected $size;
	
	/**
	 * Extensions autorisées
	 * @var array
	 */
	protected $extensionsAllowed;
	
	/**
	 * Détermine si le fichier peut être traité
	 * @var boolean
	 */
	protected $isCorrectFile;
	
	/**
	 * Gestion des erreurs I/O sur les fichiers
	 * @var array
	 */
	protected $errors;
	
	/**
	 * Retourne le statut du fichier
	 * @return boolean
	 */
	public function isCorrectFile(){
		$this->isCorrectFile = true;
		$this->errors = array();
		
		if(!$this->exists()){
			$this->errors["-10001"] = "Le document " . $this->path . $this->name . "." . $this->extension . " n'existe pas ou n'est pas situé dans le dossier spécifié";
			$this->isCorrectFile = false;
		} else {
			if(!in_array($this->extension, $this->extensionsAllowed)){
				$this->isCorrectFile = false;
				$this->errors["-10002"] = "Un document avec une extension " . $this->extension . " n'est pas autorisé.";
			} else {
				if($this->size() == 0){
					$this->isCorrectFile = false;
					$this->errors["-10003"] = "Le document " . $this->path . $this->name . "." . $this->extension . " est vide.";
				}
			}
		}
		
		return $this->isCorrectFile;
	}
	
	/**
	 * Parcourt le tableau des erreurs et retourne la chaîne concernée
	 * @param void
	 * @return string
	 */
	public function errors(){
		$output = "<ul>";
		
		foreach($this->errors as $code => $value){
			$output .= "<li> [" . $code . "] : " . $value . "</li>";
		}
		$output .= "</ul>";
		
		return $output;
	}
	
	/**
	 * Détermine si le fichier existe dans le chemin défini
	 * @param void
	 * @return boolean
	 */
	private function exists(){
		clearstatcache();
		
		$fullFileName = $this->toRoot("") . $this->path . $this->name . "." . $this->extension;
		//$fullFileName = $_SERVER["DOCUMENT_ROOT"] . "/" .$this->path . $this->name . "." . $this->extension;
		//$fullFileName = "c:\\webroot\\initpoo.dev\\_repository\\Base_Arcec.xslx";
		//$fullFileName = "http://initpoo.dev/Files/base.xslx";
		//echo "Chemin : " . $fullFileName . "(" . $_SERVER["PHP_SELF"] . ")<br />\n";
		//return true;
		return file_exists($fullFileName);
	}
	
	/**
	 * Détermine la taille du fichier
	 * @param void
	 * @return void
	 */
	private function size(){
		if($this->exists()){
			$this->size = filesize($this->path . $this->name . "." . $this->extension);
		} else {
			$this->isCorrectFile = false;
			$this->size = 0;
		}
		
		return $this->size;
	}
	
	/**
	 * Retourne la taille du fichier
	 * @param void
	 * @return int
	 */
	public function getSize(){
		return $this->size();
	}
	
	/**
	 * Retourne le chemin relatif vers la racine de l'application
	 * @param string $path
	 */
	private function toRoot(){
		/****************************************************************************/
		/* Définition des variables locales                                         */
		/****************************************************************************/
		$currentScriptPath          = ""; // Chemin complet du script courant
		$scriptHashes                = array(); // Découpage du script courant
		$pathToRoot                 = "";
		
		/****************************************************************************/
		/* Implémentation                                                           */
		/****************************************************************************/
		$currentScriptPath = $_SERVER["SCRIPT_NAME"];
		
		$currentScriptPath = substr($currentScriptPath,1,strlen($currentScriptPath));
		
		$scriptHashes= explode("/",$currentScriptPath); // Récupère les membres du tableau
		
		if(sizeof($scriptHashes) == 1){
			return "./"; // Le script s'exécute à la racine
		} else {
			for($i=0;$i<sizeof($scriptHashes)-1;$i++){
				$pathToRoot.= "../";
			}
		}
		return $pathToRoot;
	}
}
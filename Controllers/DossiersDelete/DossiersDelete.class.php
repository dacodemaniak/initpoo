<?php
/**
* @name DossiersDelete.class.php Contrôleur pour la suppression d'un ou plusieurs dossiers
* @author
* @package comideafactory\Controllers\Dossiers
* @version 1.0
**/
namespace ideafactory\Controllers\DossiersDelete;

class DossiersDelete {
	/**
	 * Liste des dossiers à supprimer
	 * @var array
	 */
	private $dossiers;
	
	/**
	 * Vue à charger à partir du dispatcher
	 * @var string
	 */
	private $view;
	
	public function __construct(){
		$this->_load();

		$this->setView();
	}
	
	/**
	 * Retourne la vue correspondante
	 * @return string
	 */
	public function getView(){
		return $this->view;
	}
	
	/**
	 * Retourne la liste des dossiers
	 * @return array
	 */
	public function getDatas(){
		return $this->dossiers;
	}
	
	protected function setView(){
		$this->view =  "Controllers/DossiersDelete/Views/dossier.json.php";
	}
	
	/**
	 * Datermine la liste des dossiers à supprimer
	 */
	private function _load(){
		$postedData = file_get_contents("php://input");
		if($postedData != ""){
			$this->dossiers = json_decode($postedData);

			// Requiert le modèle correspondant
			require_once(dirname(__FILE__) . "/../../_Classes/Models/Dossier/Scheme.class.php");
			
			$scheme = new \comideafactory\Models\Scheme();

			$scheme->delete($this->dossiers); // On supprime vraiment cette fois...
		}
		//var_dump($this->dossiers);
	}
	
	
}
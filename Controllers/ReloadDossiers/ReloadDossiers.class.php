<?php
/**
* @name ReloadDossiers.class.php Contrôleur pour le listage des dossiers au format JSON
* @author
* @package comideafactory\Controllers\Dossiers
* @version 1.0
**/
namespace ideafactory\Controllers\ReloadDossiers;

class ReloadDossiers {
	/**
	 * Liste des dossiers de la base de données
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
		$this->view =  "Controllers/ReloadDossiers/Views/dossier.json.php";
	}
	
	private function _load(){
		// Requiert le modèle correspondant
		require_once(dirname(__FILE__) . "/../../_Classes/Models/Dossier/Scheme.class.php");
		
		$scheme = new \comideafactory\Models\Scheme();
		
		$this->dossiers = $scheme->findAll();
	}
	
	
}
<?php
/**
* @name Dossiers.class.php Contrôleur pour l'affichage des dossiers
* @author
* @package comideafactory\Controllers\Dossiers
* @version 1.0
**/
namespace ideafactory\Controllers\Dossiers;

class Dossiers {
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
		$this->view =  "Controllers/Dossiers/Views/dossier.html.php";
	}
	
	private function _load(){
		// Requiert le modèle correspondant
		require_once(dirname(__FILE__) . "/../../_Classes/Models/Dossier/Scheme.class.php");
		
		$scheme = new \comideafactory\Models\Scheme();
		
		$this->dossiers = $scheme->findAll();
	}
	
	
}
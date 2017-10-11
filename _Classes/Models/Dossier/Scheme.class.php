<?php
/**
* @name Scheme.class.php Service de mapping vers la table SQL "dossiers"
**/

namespace comideafactory\Models;

class Scheme {
	/**
	 * Collection des colonnes constituant la table "dossiers"
	 * @var array
	 */
	protected $columns;
	
	/**
	 * Nom de la table concernée
	 * @var string
	 */
	protected $name;
	
	/**
	 * Mapper entre les colonnes lues d'un document et les colonnes de la table
	 * @var array
	**/
	protected $map;
	
	public function __construct(){
		$this->name = "dossiers";
		
		$this->defineScheme();
	}
	
	/**
	 * Définit le mapping entre les colonnes Excel et les colonnes de la table
	 * @param string $excelCol
	 * @param string $SQLCol
	 */
	public function addMap($excelCol, $SQLCol){
		$this->map[$excelCol] = $SQLCol;
		return $this;
	}
	
	/**
	 * Cherche et retourne un clone de l'objet SQL du schéma
	 * @param string $name Nom de la colonne Excel
	 * @return SQLColumn
	 */
	public function find($name){
		$clone = null;
		
		foreach($this->columns as $SQLCol){
			if($SQLCol->name() == $this->map[$name]){
				$clone = clone $SQLCol;
			}
		}
		
		return $clone;
	}
	
	private function defineScheme(){
		require_once(dirname(__FILE__) . "/../SQLColumn.class.php");
		
		$column = new SQLColumn();
		$column->name("id")
			->isPK(true)
			->length(11)
			->setType("integer");
		
		$this->columns[] = $column;
		
		$column = new SQLColumn();
		$column->name("nom")
		->isPK(false)
		->length(75)
		->setType("varchar");
		
		$this->columns[] = $column;
		
		$column = new SQLColumn();
		$column->name("portable")
		->isPK(false)
		->length(25)
		->setType("varchar");
		
		$this->columns[] = $column;
		
		$column = new SQLColumn();
		$column->name("email")
		->isPK(false)
		->length(75)
		->setType("varchar");
		
		$this->columns[] = $column;
	}
}
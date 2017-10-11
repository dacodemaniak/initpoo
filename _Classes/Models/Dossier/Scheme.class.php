<?php
/**
* @name Scheme.class.php Service de mapping vers la table SQL "dossiers"
**/

namespace comideafactory\Models;

use comideafactory\Database\MySQLConnexion;

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
	
	
	public function findAll(){
		$datas = array();
		
		$sqlStatement = "SELECT ";
		
		// Qu'est-ce-que je dois sélectionner
		foreach($this->columns as $column){
			$sqlStatement .= $column->name() . ",";
		}
		$sqlStatement = substr($sqlStatement, 0, strlen($sqlStatement) - 1);
		
		// A partir de quelle table ?
		$sqlStatement .= " FROM  " . $this->name . ";";

		// Exécution de la requête
		require_once(dirname(__FILE__) . "/../../Database/MySQLConnexion.class.php");
		$connexion = new MySQLConnexion();
		$connexion->connect();
		$instance = $connexion->getInstance();
		
		// Exécute la requête SELECT
		$resultSet = $instance->query($sqlStatement);
		
		// Indique qu'on veut récupérer les lignes sous forme d'objets
		$resultSet->setFetchMode(\PDO::FETCH_OBJ);
		
		// Parcourir le jeu de résultat
		while($row = $resultSet->fetch()){
			$datas[] = $row;
		}
		
		return $datas;
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
	
	public function save($rows){
		$sqlStatement = "INSERT INTO " . $this->name . "(";
		
		// Dans quoi je vais insérer mes données
		foreach($this->columns as $column){
			$sqlStatement .= $column->name() . ",";
		}
		// Supprime la dernière virgule inutile
		$sqlStatement = substr($sqlStatement, 0, strlen($sqlStatement) - 1);
		
		$sqlStatement .= ") VALUES (";
		
		// Quelles sont les valeurs à insérer
		foreach($this->columns as $column){
			$sqlStatement .= ":" . $column->name() . ",";
		}
		// Supprime la dernière virgule inutile
		$sqlStatement = substr($sqlStatement, 0, strlen($sqlStatement) - 1);
		
		// Termine la requête d'insertion
		$sqlStatement .= ");";
		
		// Préparation de la requête
		require_once(dirname(__FILE__) . "/../../Database/MySQLConnexion.class.php");
		$connexion = new MySQLConnexion();
		$connexion->connect();
		$instance = $connexion->getInstance();
		
		$statement = $instance->prepare($sqlStatement);
		
		// Maintenant, on peut parcourir les données pour les insérer
		foreach($rows as $row){
			$values = array();
			foreach($row as $sqlCol){
				$values[$sqlCol->name()] = $sqlCol->value();
			}
			#begin_output
			#echo "Exécute " . $sqlStatement . " avec les données : <br />\n";
			#var_dump($values);
			#echo "<br />\n";
			#end_output
			
			// Il n'y a plus qu'à exécuter l'insertion...
			// en m'assurant que l'id n'est pas égal à 0
			if($this->pkNotNull($values))
				$statement->execute($values);
		}
		
	}
	
	private function pkNotNull($values){
		$primaryKeyName = "";
		// Quel colonne est la clé primaire ?
		foreach($this->columns as $column){
			if($column->isPK()){
				$primaryKeyName = $column->name();
			}
		}
		if($values[$primaryKeyName] == 0 || is_null($values[$primaryKeyName])){
			return false;
		}
		
		return true;
	}
	/**
	 * Définit le schéma de la table courante (colonne, type)
	 */
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
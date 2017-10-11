<?php
/**
* @name MySQLConnexion.class.php Service de connexion à une base de données MySQL
* @author
* @namespace comideafactory\Database
* @version 1.0
**/

namespace comideafactory\Database;

require_once(dirname(__FILE__) . "/Connexion.class.php");

class MySQLConnexion extends Connexion {
	
	/**
	 * Tableau des options de connexion MySQL
	 * @var array
	 */
	private $options;
	
	public function __construct(){
		$this->readConfiguration();
		
		// Définition des options de connexion MySQL
		$this->options = array(
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		);
	}
	
	public function __destruct(){
		$this->connInstance = null;
	}
		
	/**
	 * 
	 * {@inheritDoc}
	 * @see \comideafactory\Database\Connexion::connect()
	 */
	public function connect(){
		$dsn = $this->createDSN();
		
		try{
			$this->connInstance = new \PDO($dsn, $this->config->user, $this->config->password, $this->options);
		} catch(\PDOException $error){
			echo "Erreur de connexion [" . $error->getCode() . "] : " . $error->getMessage() . "<br />";
			echo "<pre><code>" . $dsn . "</code></pre>";
			die();
		}
	}
	
	/**
	 * Crée la chaîne de connexion à partir de l'objet $this->config
	 * DSN : Data Service Name
	 * @param void
	 * @return string
	 */
	private function createDSN(){
		$dsn = "mysql:";
		
		// Ajoute l'hôte
		$dsn .= "host=" . $this->config->host . ";";
		
		// Ajoute le port
		$port = property_exists($this->config, "port") ? $this->config->port : "3306";
		$dsn .= "port=" . $port . ";";
		
		// Ajoute le nom de la base de données
		$dsn .= "dbname=" . $this->config->name . ";";
		
		return $dsn;
	}
	
	
	
	
	
	
	
	
	
	
}
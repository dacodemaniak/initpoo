<?php
/**
* @name Connexion.class.php Abstraction de classe de connexion à une base de données
* @author
* @package comideafactory\Database
* @version 1.0
**/

namespace comideafactory\Database;

abstract class Connexion {
	/**
	 * Hôte / Adresse du serveur hôte
	 * @var string
	 */
	protected $host;
	
	/**
	 * Port utilisé par le SGBD
	 * @var int
	 */
	protected $port;
	
	/**
	 * Nom de la base de données ciblée
	 * @var string
	 */
	protected $dbName;
	
	/**
	 * Nom de l'utilisateur autorisé pour l'accès à la base de données
	 * @var string
	 */
	protected $userName;
	
	/**
	 * Mot de passe de l'utilisateur autorisé
	 * @var string
	 */
	protected $password;
	
	/**
	 * Objet de configuration de connexion
	 * @var JSONObject
	 */
	protected $config;
	
	/**
	 * Instance de connexion PDO à une base de données
	 * @var \PDO
	 */
	protected $connInstance;
	
	/**
	 * Lecture du document JSON pour la récupération des informations de configuration
	 */
	public final function readConfiguration(){
		$content = file_get_contents("./_configs/dbconfig.json");
		
		$this->config = json_decode($content);
	}
	
	/**
	 * Retourne l'instance de connexion à la base de données
	 * @return PDO
	 */
	public function getInstance(){
		return $this->connInstance;
	}
	
	/**
	 * Abstraction de méthode de connexion à implémenter dans les classes filles
	 */
	abstract function connect();
	
	
	
	
	
	
	
	
	
	
}
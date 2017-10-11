<?php
/**
* @name Http.class.php Analyse des requêtes HTTP
* @author IdeaFactory (dev-team@ideafactory.com) - Oct. 2017
* @package \comideafactory\Http
* @version 1.0
**/
namespace comideafactory\Http;

require_once("./HttpItemData.class.php");

use \comidafactory\Http\HttpItemData as Data;

class Http {
	private $datas;
	
	/**
	 * Constructeur de la classe, récupère les données de requête et les données postées
	 */
	public function __construct(){
		if(count($_GET)){
			foreach($_GET as $key => $value){
				$data = new Data();
				$data->type("GET")
					->name($key)
					->value($value);
				$this->datas["GET"][$key] = $data;
			}
		}
		if(count($_POST)){
			foreach($_POST as $key => $value){
				$data = new Data();
				$data->type("POST")
				->name($key)
				->value($value);
				$this->datas["POST"][$key] = $data;
			}
		}
	}
	
	/**
	 * Retourne une données Http Query
	 * @param string $key
	 * @return mixed|boolean
	 */
	public function getQueryData($key){
		if(array_key_exists($key, $this->datas["GET"])){
			return $this->datas["GET"][$key];
		}
		return false;
	}

	/**
	 * Retourne une données Http Query
	 * @param string $key
	 * @return mixed|boolean
	 */
	public function getPostData($key){
		if(array_key_exists($key, $this->datas["POST"])){
			return $this->datas["POST"][$key];
		}
		return false;
	}
	
	public function add($type, $key, $value){
		if(!array_key_exists($key, $this->datas[$type])){

		
	}
}
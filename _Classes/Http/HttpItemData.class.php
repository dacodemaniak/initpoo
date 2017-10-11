<?php
/**
* @name HttpItemData.class.php Service de définition des données HTTP
* @author IdeaFactory (dev-team@ideafactory.com) - Oct. 2017
* @package comideafactory\Http
* @version 1.0
**/

namespace comideafactory\Http;

class HttpItemData {
	/**
	 * Type de données GET | POST | AJAX
	 * @var string
	 */
	private $type;
	
	/**
	 * Etiquette associée
	 * @var string
	 */
	private $name;
	
	/**
	 * Valeur associée
	 * @var mixed
	 */
	private $value;
	
	/**
	 * Constructeur de la classe
	 * @param void
	 * @return void
	 */
	public function __construct(){}
	
	/**
	 * Définit ou retourne le type de la données HTTP
	 * @param string $type
	 * @return string|\comideafactory\Http\HttpItemData
	 */
	public function type($type = null){
		if(is_null($type)){
			return $this->type;
		}
		
		$this->type = $type;
		
		return $this;
	}
	
	/**
	 * Définit ou retourne le nom de la donnée
	 * @param string $name
	 * @return string|\comideafactory\Http\HttpItemData
	 */
	public function name($name = null){
		if(is_null($name)){
			return $this->name;
		}
		
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * Définit ou retourne la valeur associée
	 * @param string $value
	 * @return string|\comideafactory\Http\HttpItemData
	 */
	public function value($value = null){
		if(is_null($value)){
			return $this->value;
		}
		
		$this->value = $value;
		
		return $this;
	}
}
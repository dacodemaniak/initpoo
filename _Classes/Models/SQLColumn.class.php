<?php
/**
* @name SQLColumn.class.php Service de définition d'une colonne de table SQL
* @author
* @package comideafactory\Models
* @version 1.0
**/
namespace comideafactory\Models;

class SQLColumn {
	/**
	 * Nom de la colonne dans la table mySQL
	 * @var string
	 */
	protected $name;
	
	/**
	 * Type de données SQL
	 * @var string
	 */
	protected $type;
	
	/**
	 * Longueur maximale définie
	 * @var int
	 */
	protected $length;
	
	/**
	 * Définit si la colonne est la clé primaire
	 * @var unknown
	 */
	protected $isPK;
	
	/**
	 * Valeur associée à la colonne courante
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * Définit ou retourne la valeur de l'attribut $this->name
	 * @param string $name
	 * @return string|\comideafactory\Models\SQLColumn
	 */
	public function name($name = null){
		if(is_null($name)){
			return $this->name;
		}
		
		$this->name = $name;
		return $this;
	}
	
	/**
	 * Définit ou retourne la valeur de l'attribut $this->type
	 * @param string $type
	 * @return string|\comideafactory\Models\SQLColumn
	 * @usage :
	 * 	$objet->type("integer") => Définit la valeur de l'attribut $this->type à "integer"
	 * 	$objet->type() => Retourne la valeur de l'attribut $this->type ("integer")
	 */
	public function type($type = null){
		if(is_null($type)){
			return $this->type;
		}
		
		$this->type = $type;
		return $this;
	}
	
	/**
	 * String public type(){ return this.type}
	 * SQLColumn public type(String type) { this.type = type; return this}
	**/
	
	/**
	 * Définit la valeur de l'attribut $this->type
	 * @param string $type
	 * @return \comideafactory\Models\SQLColumn
	 */
	public function setType($type){
		$this->type = $type;
		return $this;
	}
	
	/**
	 * Retourne la valeur de l'attribut $this->type
	 * @return string
	 */
	public function getType(){
		return $this->type;
	}
	
	/**
	 * Définit ou retourne la valeur de l'attribut "length"
	 * @param int $length
	 * @return number|\comideafactory\Models\SQLColumn
	 */
	public function length($length = null){
		if(is_null($length)){
			return $this->length;
		}
		
		$this->length = $length;
		
		return $this;
	}
	
	/**
	 * Définit ou retourne la valeur de l'attribut isPK
	 * @param mixed $isPK
	 * @return boolean|\comideafactory\Models\unknown|\comideafactory\Models\SQLColumn
	 */
	public function isPK($isPK = null){
		if(is_null($isPK)){
			return !is_null($this->isPK) ? $this->isPK : false;
		}
		
		$this->isPK = is_bool($isPK) ? $isPK : false;
		
		return $this;
	}
	
	/**
	 * Définit ou retourne la valeur de l'attribut "value"
	 * @param mixed $value
	 * @return mixed|string|\comideafactory\Models\SQLColumn
	 */
	public function value($value = null){
		if(is_null($value)){
			return $this->value;
		}
		
		$this->value = $value;
		return $this;
	}
	
}
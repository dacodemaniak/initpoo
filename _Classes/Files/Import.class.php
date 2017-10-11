<?php
/**
* @name Import.class.php Interface définissant les méthodes qui doivent être implémentées dans les importations de documents
* @author
* @package comideafactory\Files
* @version 1.0
**/

namespace comideafactory\Files;

interface Import {
	
	public function addColumn($columnName);
	
	public function setOutputType($outputType);
	
	public function process();
}
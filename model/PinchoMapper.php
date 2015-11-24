<?php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Pincho.php");

class PinchoMapper{

	private $db;
	  
	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}








}
?>
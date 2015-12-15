<?php
require_once(__DIR__."/../core/PDOConnection.php");

	class Ingrediente {

		private $ingrediente;
		private $id_pincho;

		public function __construct($id_pincho = NULL,$ingrediente = NULL){
			$this->ingrediente = $ingrediente;
			$this->id_pincho = $id_pincho;
		}

		public function getIngrediente(){
			return $this->ingrediente;
		}

		public function getId(){
			return $this->id_pincho;
		}

		public function setIngrediente($ingrediente){
			$this->ingrediente = $ingrediente;
		}

		public function setId($id_pincho){
			$this->id_pincho = $id_pincho;
		}

}
?>
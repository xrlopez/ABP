<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/Organizador.php");

/**
 * Class UserMapper
 *
 * Database interface for User entities
 * 
 * @author lipido <lipido@gmail.com>
 */
class UserMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }

  /**
   * Saves a User into the database
   * 
   * @param User $user The user to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */      
  public function save($user) {
    $stmt = $this->db->prepare("INSERT INTO usuario values (?,?,?,?,?)");
    $stmt->execute(array($user->getid(), $user->getNombre(), $user->getPassword(), $user->getEmail(), $user->getTipo()));
  
    switch ($this->userType($user->getId())) {
        case "juradoPopular":
          $stmt = $this->db->prepare("INSERT INTO juradoPopular values (?,?)");
          $stmt->execute(array($user->getid(), $user->getResidencia()));
          break;
        case "juradoProfesional":
          $this->view->moveToFragment($currentuser);
          $this->view->redirect("juradoProfesional", "index");
          break;
        case "establecimiento":
    		  $stmt = $this->db->prepare("INSERT INTO establecimiento values (?,?,?)");
    		  $stmt->execute(array($user->getid(), $user->getLocalizacion(), $user->getDescripcion()));
          break;
        }

  }
  
  /**
   * Checks if a given username is already in the database
   * 
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  public function usernameExists($username) {
    $stmt = $this->db->prepare("SELECT count(id_usuario) FROM usuario where id_usuario=?");
    $stmt->execute(array($username));
    
    if ($stmt->fetchColumn() > 0) {   
      return true;
    } 
  }
  
  public function userType($username){
    $stmt = $this->db->prepare("SELECT * FROM usuario where usuario.id_usuario=?");
	$stmt->execute(array($username));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
	if($user != null) {
		return ($user["tipo"]);
	}else {
	  return NULL;
	}  
  }
  /**
   * Checks if a given pair of username/password exists in the database
   * 
   * @param string $username the username
   * @param string $passwd the password
   * @return boolean true the username/passwrod exists, false otherwise.
   */
  public function isValidUser($username, $passwd) {
    $stmt = $this->db->prepare("SELECT count(id_usuario) FROM usuario where id_usuario=? and password=?");
    $stmt->execute(array($username, $passwd));
    
    if ($stmt->fetchColumn() > 0) {
      return true;        
    }
  }
   
}
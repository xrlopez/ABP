<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");
require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");
require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class UsersController
 * 
 * Controller to login, logout and user registration
 * 
 * @author lipido <lipido@gmail.com>
 */
class UsersController extends BaseController {
  
  /**
   * Reference to the UserMapper to interact
   * with the database
   * 
   * @var UserMapper
   */  
  private $userMapper;    
  
  public function __construct() {    
    parent::__construct();
    
    $this->userMapper = new UserMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    $this->view->setLayout("welcome");     
  }

  public function login() {
    if (isset($_POST["username"])){ // reaching via HTTP Post...
      //process login form    
      if ($this->userMapper->isValidUser($_POST["username"],$_POST["passwd"])) {
	
	$_SESSION["currentuser"]=$_POST["username"];
  $_SESSION["tipoUsuario"] = $this->userMapper->userType($_POST["username"]);
	
	// send user to the restricted area (HTTP 302 code)
	
	switch ($this->userMapper->userType($_POST["username"])) {
		    case "organizador":
				$this->view->moveToFragment($_POST["username"]);
				$this->view->redirect("organizador", "index");
				break;
			case "juradoPopular":
				$this->view->moveToFragment($_POST["username"]);
				$this->view->redirect("juradoPopular", "index");
				break;
			case "juradoProfesional":
				$this->view->moveToFragment($_POST["username"]);
				$this->view->redirect("juradoProfesional", "index");
				break;
			case "establecimiento":
				$this->view->moveToFragment($_POST["username"]);
				$this->view->redirect("establecimiento", "index");
				break;
	}
	
      }else{
	$errors = array();
	$errors["general"] = "<span id=\"error\">El usuario o la contraseña no es correcta</span>";
	$this->view->setVariable("errors", $errors);
      }
    }       
    
    // render the view (/view/users/login.php)
    $this->view->render("users", "login");    
  }

  public function info(){
      $currentuser = $this->view->getVariable("currentusername");
    
      switch ($this->userMapper->userType($currentuser)) {
            case "organizador":
            $this->view->moveToFragment($currentuser);
            $this->view->redirect("organizador", "perfil");
            break;
          case "juradoPopular":
            $this->view->moveToFragment($currentuser);
            $this->view->redirect("juradoPopular", "perfil");
            break;
          case "juradoProfesional":
            $this->view->moveToFragment($currentuser);
            $this->view->redirect("juradoProfesional", "perfil");
            break;
          case "establecimiento":
            $this->view->moveToFragment($currentuser);
            //comprabar se ten pincho validado llamar a funcion pinchoValido en pIncho.php

            $this->view->setVariable("pincho",$pincho);
            $this->view->redirect("establecimiento", "perfil");
            break;
          }

  }

   
   public function register() { 
    $this->view->render("users", "register");
    
  }
   
   
   
public function registerEstablecimiento() {
    
    $esta = new Establecimiento();
    
    if (isset($_POST["usuario"])){ 
      $esta->setId($_POST["usuario"]);
      $esta->setNombre($_POST["nombre"]);
      $esta->setEmail($_POST["correo"]);
	  $esta->setDescripcion($_POST["descripcion"]);
      $esta->setLocalizacion($_POST["localizacion"]);
      $esta->setTipo("Establecimiento");

      if ($_POST["pass"]==$_POST["repass"]) {
        $esta->setPassword($_POST["pass"]);
      }
      else{
        $errors["pass"] = "Las contraseñas tienen que ser iguales";
        $this->view->setVariable("errors", $errors);
        $this->view->render("users", "registerEstablecimiento"); 
        return false;
      }
    
      
      try{
	      $esta->checkIsValidForCreate(); 
    
      	if (!$this->userMapper->usernameExists($_POST["usuario"])){

        	  $this->userMapper->save($esta);
	          $this->view->setFlash("Usuario ".$esta->getId()." registrado.");
	          $this->view->redirect("users", "login");
  } else {
	  $errors = array();
	  $errors["usuario"] = "El usuario ya existe";
	  $this->view->setVariable("errors", $errors);
	}
      }catch(ValidationException $ex) {
      	$errors = $ex->getErrors();
      	$this->view->setVariable("errors", $errors);
      }
    }
    
    $this->view->setVariable("Establecimiento", $esta);
    $this->view->render("users", "registerEstablecimiento");
    
  }
  

  public function registerPopular() {
    
    $jpop = new JuradoPopular();
    
    if (isset($_POST["usuario"])){ 
      $jpop->setId($_POST["usuario"]);
      $jpop->setNombre($_POST["nombre"]);
      $jpop->setEmail($_POST["correo"]);
      $jpop->setResidencia($_POST["residencia"]);
      $jpop->setTipo("juradoPopular");

      if ($_POST["pass"]==$_POST["repass"]) {
        $jpop->setPassword($_POST["pass"]);
      }
      else{
       $errors["pass"] = "Las contraseñas tienen que ser iguales";
       $this->view->setVariable("errors", $errors);
       $this->view->render("users", "registerPopular"); 
       return false;
      }
    
      try{
	      $jpop->checkIsValidForCreate(); 
    
      	if (!$this->userMapper->usernameExists($_POST["usuario"])){

        	  $this->userMapper->save($jpop);
	          $this->view->setFlash("Usuario ".$jpop->getId()." registrado.");
            $this->view->redirect("users", "login");
      	} else {
      	  $errors = array();
      	  $errors["usuario"] = "El usuario ya existe";
      	  $this->view->setVariable("errors", $errors);
      	}
      }catch(ValidationException $ex) {
      	$errors = $ex->getErrors();
      	$this->view->setVariable("errors", $errors);
      }
    }
    
    // Put the User object visible to the view
    $this->view->setVariable("juradoPopular", $jpop);
    $this->view->render("users", "registerPopular"); 
    
  }

public function registerProfesional() {
    
    $jpop = new JuradoProfesional();
    $currentuser = $this->view->getVariable("currentusername");
    if (isset($_POST["usuario"])){ 
      $jpop->setId($_POST["usuario"]);
      $jpop->setNombre($_POST["nombre"]);
      $jpop->setEmail($_POST["correo"]);
      $jpop->setProfesion($_POST["profesion"]);
      $jpop->setOrganizador($currentuser);
      $jpop->setTipo("juradoProfesional");

      if ($_POST["pass"]==$_POST["repass"]) {
        $jpop->setPassword($_POST["pass"]);
      }else{
        $errors["pass"] = "Las contraseñas tienen que ser iguales";
        $this->view->setVariable("errors", $errors);
        $this->view->render("users", "registerProfesional"); 
        return false;
      }
    
    try{
        $jpop->checkIsValidForCreate(); 
    
        if (!$this->userMapper->usernameExists($_POST["usuario"])){

            $this->userMapper->save($jpop);
            $this->view->setFlash("Usuario ".$jpop->getId()." registrado.");
            $this->view->redirect("users", "login");
        } else {
          $errors = array();
          $errors["usuario"] = "El usuario ya existe";
          $this->view->setVariable("errors", $errors);
        }
      }catch(ValidationException $ex) {
        $errors = $ex->getErrors();
        $this->view->setVariable("errors", $errors);
      }
    }

    $this->view->setVariable("juradoProfesional", $jpop);
    $this->view->render("users", "registerProfesional");
    
  }


  public function logout() {
    session_destroy();
    
    // perform a redirection. More or less: 
    // header("Location: index.php?controller=users&action=login")
    // die();
    $this->view->redirect("concurso", "index");
   
  }
  
}

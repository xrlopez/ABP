<?php

require_once(__DIR__."/../core/ViewManager.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");
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
            $this->view->redirect("establecimiento", "index");
            break;
          }

  }

   
   public function register() { 
    $this->view->render("users", "register");
    
  }
   
   
   
public function registerEstablecimiento() {
    
    $jpop = new Establecimiento();
    
    if (isset($_POST["usuario"])){ 
      $jpop->setId($_POST["usuario"]);
      $jpop->setNombre($_POST["nombre"]);
      $jpop->setEmail($_POST["correo"]);
	  $jpop->setDescripcion($_POST["descripcion"]);
      $jpop->setLocalizacion($_POST["localizacion"]);
      $jpop->setTipo("Establecimiento");

      if ($_POST["pass"]==$_POST["repass"]) {
        $jpop->setPassword($_POST["pass"]);
      }
      else{
        $errors["pass"] = "<span>La contraseña es obligatoria</span>";
        $this->view->setVariable("errors", $errors);
        $this->view->redirect("Establecimiento", "registerEstablecimiento"); 
      }
    
      
      try{
	      $jpop->checkIsValidForCreate(); 
    
      	if (!$this->userMapper->usernameExists($_POST["usuario"])){

        	  $this->userMapper->save($jpop);
	          $this->view->setFlash("Usuario ".$jpop->getId()." registrado.");
	} else {
	  $errors = array();
	  $errors["usuario"] = "El usuario ya existe";
	  $this->view->setVariable("errors", $errors);
	}
    $this->view->redirect("users", "login");
      }catch(ValidationException $ex) {
      	$errors = $ex->getErrors();
      	$this->view->setVariable("errors", $errors);
      }
    }
    
    // Put the User object visible to the view
    $this->view->setVariable("Establecimiento", $jpop);
    
    // render the view (/view/users/register.php)
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
        $errors["pass"] = "<span>La contraseña es obligatoria</span>";
        $this->view->setVariable("errors", $errors);
        $this->view->redirect("juradoPopular", "registerPopular"); 
      }
    
      
      try{
	      $jpop->checkIsValidForCreate(); 
    
      	if (!$this->userMapper->usernameExists($_POST["usuario"])){

        	  $this->userMapper->save($jpop);
	          $this->view->setFlash("Usuario ".$jpop->getId()." registrado.");
	} else {
	  $errors = array();
	  $errors["usuario"] = "El usuario ya existe";
	  $this->view->setVariable("errors", $errors);
	}
    $this->view->redirect("users", "login");
      }catch(ValidationException $ex) {
      	$errors = $ex->getErrors();
      	$this->view->setVariable("errors", $errors);
      }
    }
    
    // Put the User object visible to the view
    $this->view->setVariable("juradoPopular", $jpop);
    
    // render the view (/view/users/register.php)
    $this->view->render("users", "registerPopular");
    
  }

 /**
   * Action to logout
   * 
   * This action should be called via GET
   * 
   * No HTTP parameters are needed.
   *
   * The views are:
   * <ul>
   * <li>users/login (via redirect)</li>
   * </ul>
   *
   * @return void
   */
  public function logout() {
    session_destroy();
    
    // perform a redirection. More or less: 
    // header("Location: index.php?controller=users&action=login")
    // die();
    $this->view->redirect("concurso", "index");
   
  }
  
}

<?php


require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/UsersController.php");

class JuradoProfesionalController extends BaseController {
  
  private $juradoProfesionalMapper;  
  private $userMapper;
  private $concursoMapper;
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();
    $this->concursoMapper = new ConcursoMapper();   
    $this->userMapper = new UserMapper(); 
  }
  
  
  /*redirecciona a la página principal del sitio web*/
  public function index() {
  
    $juradoProfesional = $this->juradoProfesionalMapper->findAll();
	   $concursos = $this->concursoMapper->findConcurso("pinchosOurense");     
    
    $this->view->setVariable("juradoProfesional", $juradoProfesional);    
    $this->view->setVariable("concursos", $concursos); 
	
    $this->view->render("concursos", "index");
  }
  
  /*redirecciona a la vista del perfil del jurado profesional*/
  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);
    $this->view->setVariable("juradoPro", $juradoProfesional);
    $this->view->render("juradoProfesional", "perfil");
  }

  /*redirecciona al formulario de modificacion de los datos de un jurado profesional*/
  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);
    $this->view->setVariable("juradoPro", $juradoProfesional);
    $this->view->render("juradoProfesional", "modificar");
  }
	
  /*Recupera los datos del formulario de modificacion de un jurado profesional,
  comprueba que son correctos y llama a update() de JuradoProfesionalMapper.php
  donde se realiza la actualizacion de los datos.*/
  public function update(){
    $jproid = $_REQUEST["usuario"];
    $jpro = $this->juradoProfesionalMapper->findById($jproid);

    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){
        if (isset($_POST["submit"])) {  
        
          $jpro->setNombre($_POST["nombre"]);
          $jpro->setEmail($_POST["correo"]);
          $jpro->setProfesion($_POST["profesion"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $jpro->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["pass"] = "Las contraseñas tienen que ser iguales";
              $this->view->setVariable("errors", $errors);
              $this->view->setVariable("juradoPro", $jpro);
              $this->view->render("juradoProfesional", "modificar"); 
              return false;
            }
          }
          
            try{
              $this->juradoProfesionalMapper->update($jpro);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$jpro ->getNombre()));
              $this->view->redirect("juradoProfesional", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "<span>La contraseña es obligatoria</span>";
        $this->view->setVariable("errors", $errors);
        $this->view->setVariable("juradoPro", $jpro);
        $this->view->render("juradoProfesional", "modificar"); 
      }
  }

  /*Llama a delete() de JuradoProfesionalMapper.php que elimina un jurado profesional y las votaciones
  que este realizó.*/
   public function eliminar(){
    $jproid = $_REQUEST["usuario"];
    $juradoProfesional = $this->juradoProfesionalMapper->findById($jproid);
    
        
    // Does the post exist?
    if ($juradoProfesional == NULL) {
      throw new Exception("No existe el usuario ".$jproid);
    }
    
    // Delete the Jurado Popular object from the database
    $this->juradoProfesionalMapper->delete($juradoProfesional);
    
    $this->view->setFlash(sprintf("Usuario \"%s\" eliminado.",$juradoProfesional ->getId()));
    $this->view->redirect("organizador", "index");
  }

  /*lista los jurado profesionales para eliminarlos*/
  public function listarEliminar(){
    $juradoProfesional = $this->juradoProfesionalMapper->findAll();
    $this->view->setVariable("juradoProfesional", $juradoProfesional);
    $this->view->render("juradoProfesional", "listaEliminar");  
  }

  /*lista los jurados profesionales*/
    public function listar(){
    $juradoProfesional = $this->juradoProfesionalMapper->findAll();
    $this->view->setVariable("juradoProfesional", $juradoProfesional);
    $this->view->render("juradoProfesional", "listar");  
  }
  
  /*redirecciona a la vista de votar de un jurado profesional*/
  public function votar(){
		$currentuser = $this->view->getVariable("currentusername");
		$juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);

    //devuelve los pinchos con sus votos de un jurado profesional
		$votos = $this->juradoProfesionalMapper->votos($currentuser);

    //devuelve la ronda en la que esta el jurado profesional
		$ronda = $this->juradoProfesionalMapper->getRonda($currentuser);
		$this->view->setVariable("juradoPro", $juradoProfesional);
		$this->view->setVariable("votos", $votos);
		$this->view->setVariable("ronda", $ronda);
		$this->view->render("juradoProfesional", "votar");
  }
  
  /*modifica el pincho y su voto correspondiente de un jurado profesional*/
  public function votarPincho(){
	  $currentuser = $this->view->getVariable("currentusername");
	  $juradoProfesional = $this->juradoProfesionalMapper->findById($currentuser);
	  $votos = $this->juradoProfesionalMapper->votar($_POST['currentusername'], $_POST['idPincho'], $_POST['voto']);
	  $this->view->redirect("juradoProfesional", "votar");
  }
}

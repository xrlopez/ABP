<?php


require_once(__DIR__."/../model/Organizador.php");
require_once(__DIR__."/../model/OrganizadorMapper.php");

require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

require_once(__DIR__."/../model/JuradoProfesional.php");
require_once(__DIR__."/../model/JuradoProfesionalMapper.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../model/Pincho.php");

class OrganizadorController extends BaseController {
  
  private $organizadorMapper;
  private $juradoProfesionalMapper;
  private $concursoMapper;
  private $userMapper;
  private $pincho;
  
  public function __construct() { 
    parent::__construct();
    
    $this->organizadorMapper = new OrganizadorMapper();

    $this->juradoProfesionalMapper = new JuradoProfesionalMapper();

    $this->concursoMapper = new ConcursoMapper();
    
    $this->userMapper = new UserMapper(); 
    $this->pincho = new Pincho();
  }
  
  
  public function index() {
  
    $organizador = $this->organizadorMapper->findAll(); 
    $concursos = $this->concursoMapper->findConcurso(); 
    $this->view->setVariable("organizador", $organizador);
    $this->view->setVariable("concursos", $concursos);  
    $this->view->render("concursos", "index");
  }
  
  public function asignar(){
    $juradosPro = $this->juradoProfesionalMapper->findAll();
    $this->view->setVariable("juradosProfesionales", $juradosPro);
    $this->view->render("organizador","asignar");
  }

  public function asignarJurado(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $this->view->setVariable("jurado",$jpop);
    $pinchos = $this->pincho->pinchosNoAsignados($jpopid);
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("organizador","asignarPinchos");

  }

  public function asignarPinchos(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->juradoProfesionalMapper->findById($jpopid);
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("jurado",$jpop);
    $pinchos = $_REQUEST["selectedPinchos"];
    $pincha = array();
    for ($i=0; $i < count($pinchos) ; $i++) { 
        $pincha[$i] = Pincho::find($pinchos[$i]);
    }
    $this->organizadorMapper->asignar($jpop,$pincha,$organizador);
    $this->view->setVariable("pinchos", $pincha);
    $this->view->render("organizador","asignados");
  }


public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("organizador", $organizador);
    $this->view->render("organizador", "perfil");
  }
  
  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    $this->view->setVariable("organizador", $organizador);
    $this->view->render("organizador", "modificar");
  }

  public function eliminar(){
    $currentuser = $this->view->getVariable("currentusername");
    $organizador = $this->organizadorMapper->findById($currentuser);
    
        
    // Does the post exist?
    if ($organizador == NULL) {
      throw new Exception("No existe el usuario ".$currentuser);
    }
    
    // Delete the Jurado Popular object from the database
    $this->organizadorMapper->delete($organizador);
    
    $this->view->setFlash(sprintf("Usuario \"%s\" eliminado.",$organizador ->getId()));
    session_unset();
    session_destroy();
    $this->view->redirect("concurso", "index");
  }

  public function update(){
    $jpopid = $_REQUEST["usuario"];
    $jpop = $this->organizadorMapper->findById($jpopid);
    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){

        if (isset($_POST["submit"])) {  
        
          $jpop->setNombre($_POST["nombre"]);
          $jpop->setEmail($_POST["correo"]);
          $jpop->setDescripcionOrga($_POST["descripcion"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $jpop->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["pass"] = "Las contraseñas tienen que ser iguales";
              $this->view->setVariable("errors", $errors);
              $this->view->setVariable("organizador", $jpop);
              $this->view->render("organizador", "modificar"); 
              return false;
            }
          }
          
            try{
              $this->organizadorMapper->update($jpop);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$jpop ->getNombre()));
              $this->view->redirect("organizador", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "Contraseña incorrecta";
        $this->view->setVariable("errors", $errors);
      }
        $this->view->setVariable("organizador", $jpop);
        $this->view->render("organizador", "modificar"); 
  }

   public function validar(){
    $pinchos = Pincho::noValidados();
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->render("organizador", "validarPincho");
  }

   public function premios(){

    $this->view->render("organizador", "gestionarPremios");
  }

  public function votacionPro(){
    $ronda = $_GET['ronda'];
    $pinchos = $this->organizadorMapper->votacionPro($ronda);
    $this->view->setVariable("pinchos", $pinchos);
    $this->view->setVariable("ronda", $ronda);
    $this->view->render("organizador", "votosPro");
  }
  
}

<?php


require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/EstablecimientoMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Codigo.php");
require_once(__DIR__."/../model/CodigoMapper.php");
require_once(__DIR__."/../model/Concurso.php");
require_once(__DIR__."/../model/ConcursoMapper.php");
require_once(__DIR__."/../model/Pincho.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");

class EstablecimientoController extends BaseController {
  
  private $juradoPopularMapper;  
  private $codigoMapper;
  private $concursoMapper;  
  private $pincho;  
  private $userMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->establecimientoMapper = new EstablecimientoMapper();      
    $this ->codigoMapper = new CodigoMapper();     
    $this ->pincho = new Pincho();   
    $this->concursoMapper = new ConcursoMapper();
    $this->userMapper = new UserMapper();
  }
  
  
  public function index() {
  
    $establecimiento = $this->establecimientoMapper->findAll();  
    $concursos = $this->concursoMapper->findConcurso();   
    $this->view->setVariable("establecimiento", $establecimiento); 
    $this->view->setVariable("concursos", $concursos);    
    
    $this->view->render("concursos", "index");
    
  }

  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "perfil");
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "modificar");
  
  }
  
  public function update(){
    $estid = $_REQUEST["usuario"];
    $est = $this->establecimientoMapper->findById($estid);
    $errors = array();
    if($this->userMapper->isValidUser($_POST["usuario"],$_POST["passActual"])){

        if (isset($_POST["submit"])) {  
        
          $est->setNombre($_POST["nombre"]);
          $est->setEmail($_POST["correo"]);
          $est->setLocalizacion($_POST["localizacion"]);

          if(!(strlen(trim($_POST["passNew"])) == 0)){
            if ($_POST["passNew"]==$_POST["passNueva"]) {
              $est->setPassword($_POST["passNueva"]);
            }
            else{
              $errors["pass"] = "Las contraseñas tienen que ser iguales";
              $this->view->setVariable("errors", $errors);
              $this->view->setVariable("establecimiento", $est);
              $this->view->render("establecimiento", "modificar"); 
              return false;
            }
          }
          
            try{
              $this->establecimientoMapper->update($est);
              $this->view->setFlash(sprintf("Usuario \"%s\" modificado correctamente.",$est ->getNombre()));
              $this->view->redirect("establecimiento", "index"); 
            }catch(ValidationException $ex) {
            $errors = $ex->getErrors();
            $this->view->setVariable("errors", $errors);
          } 
        }

    }
    else{
        $errors["passActual"] = "La contraseña es obligatoria";
        $this->view->setVariable("errors", $errors);
        $this->view->setVariable("establecimiento", $est);
        $this->view->render("establecimiento", "modificar"); 
      }
  }

  public function generarCodigos(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $concursos = $this->concursoMapper->findConcurso();   
    
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho!=NULL){
      $cods = $this->establecimientoMapper->generarCodigos($establecimiento);
      $this->codigoMapper->generarPDF($cods,$establecimiento->getNombre());  
    }else{
      $this->view->setFlash(sprintf("No tienes un pincho valido."));
      $this->view->setVariable("concursos", $concursos);    
      $this->view->render("concursos", "index");
    }
  }

  public function listar(){
    $establecimientos = $this->establecimientoMapper->findAll();  
    $this->view->setVariable("establecimientos", $establecimientos); 
    $this->view->render("establecimiento", "listar");

  }

  public function findPincho(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho == NULL){
      throw new Exception("No existe el pincho");
    }
    $this->view->setVariable("pincho", $pincho); 
    $this->view->render("pinchos", "pincho");
      
  }

  public function getInfo(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $this->view->setVariable("esta", $establecimiento); 
    $this->view->render("establecimiento", "index");

  }

  public function registerPincho(){
    $currentuser = $this->view->getVariable("currentusername");
    $this->view->render("pinchos","registerPincho");
  }
  
}

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
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");   
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
  
  public function info(){
    $establecimiento = $this->establecimientoMapper->findById($_GET["id"]);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "info");	
  }

  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "modificar");
  
  }

  public function eliminar(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    
        
    // Does the post exist?
    if ($establecimiento == NULL) {
      throw new Exception("No existe el usuario ".$currentuser);
    }
    
    // Delete the Jurado Popular object from the database
    $this->establecimientoMapper->delete($establecimiento);
    
    $this->view->setFlash(sprintf("Usuario \"%s\" eliminado.",$establecimiento ->getId()));
    session_unset();
    session_destroy();
    $this->view->redirect("concurso", "index");    
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
    $num=$_POST["numero"];
    if($num==null){
      $num=100;
    }
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");   
    
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho!=NULL && ($pincho->getValidado()==1)){
      $cods = $this->establecimientoMapper->generarCodigos($establecimiento,$num);
      $this->codigoMapper->generarPDF($cods,$establecimiento->getNombre());  
    }else{
      $this->view->setFlash(sprintf("No tienes un pincho valido."));
      $this->view->setVariable("concursos", $concursos);    
      $this->view->render("concursos", "index");
    }
  }

  public function listar(){
    $establecimientos = $this->establecimientoMapper->findAllValidados();  
    $this->view->setVariable("establecimientos", $establecimientos); 
    $this->view->render("establecimiento", "listar");

  }

  public function findPincho(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");   
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho == NULL){
    $this->view->setFlash(sprintf("No tiene pincho."));
    $establecimientos = $this->establecimientoMapper->findAll();  
    $this->view->setVariable("establecimientos", $establecimientos); 
    $this->view->render("establecimiento", "listar");
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
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
     if($pincho!=NULL){
        if($pincho->getValidado()==0){
           $this->view->setFlash(sprintf("Ya hay un pincho registrado."));
           $this->view->redirect("establecimiento", "modPincho");     

        }else{
         $this->view->setFlash(sprintf("Ya hay un pincho registrado."));
         $this->view->setVariable("concursos", $concursos);    
         $this->view->render("concursos", "index");  
        }
    }else{
      $this->view->setVariable("establecimiento",$establecimiento);
      $this->view->render("establecimiento","registerPincho"); 
    }
  }

  public function modPincho(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    $this->view->setVariable("pincho",$pincho);
    $this->view->render("establecimiento", "modPincho");
  }
  public function modificarPincho(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");
    $pinc = $this->pincho->findByEstablecimiento($establecimiento);
      if (isset($_POST["nombre"])){
        $pinc->setNombre($_POST["nombre"]);
        if(isset($_POST["celiaco"])){
          $pinc->setCeliaco(1);
        }else{
          $pinc->setCeliaco(0);
        }
        $pinc->setDescripcion($_POST["descripcion"]);
      
        try{
            $this->establecimientoMapper->modPincho($pinc);
            $this->view->setFlash("Pincho ".$pinc->getNombre()." modificado.");
            }catch(ValidationException $ex) {
              $errors = $ex->getErrors();
              $this->view->setVariable("errors", $errors);
            }
        }
    
            $this->view->setVariable("pincho", $pinc);
        $this->view->setVariable("concursos", $concursos);    
    
         $this->view->render("concursos", "index");

  }

  public function eliminarPincho(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $pinc = $this->pincho->findByEstablecimiento($establecimiento);
    
    if($pinc->getValidado()==0){
      $this->establecimientoMapper->deletePincho($pinc);
      $this->view->setFlash(sprintf("Pincho \"%s\" eliminado.",$establecimiento ->getNombre()));

    }else{
      $this->view->setFlash(sprintf("Pincho \"%s\" validado, no se puede eliminar.",$establecimiento ->getNombre()));
    }
    $this->view->redirect("concurso", "index");

  }

  public function register(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");
    $this->view->setVariable("concursos", $concursos);    
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    if($pincho!=NULL){
         $this->view->setFlash(sprintf("Ya hay un pincho registrado."));
         $this->view->render("concursos", "index");
    }else{
      if (isset($_POST["nombre"])){ 
        $pinc = new Pincho();
        $pinc->setNombre($_POST["nombre"]);
        if(isset($_POST["celiaco"])){
          $pinc->setCeliaco(1);
        }else{
          $pinc->setCeliaco(0);
        }
        $pinc->setDescripcion($_POST["descripcion"]);
        $pinc->setValidado(0);
        $pinc->setEstablecimiento($currentuser);
        $pinc->setConcurso("pinchosOurense");   
      
        try{
            $this->establecimientoMapper->savePincho($pinc);
            $this->view->setFlash("Pincho ".$pinc->getId()." registrado.");
            }catch(ValidationException $ex) {
              $errors = $ex->getErrors();
              $this->view->setVariable("errors", $errors);
            }
        }
    
        $this->view->setVariable("pincho", $pinc);
    
         $this->view->render("concursos", "index");
    }

  }
  
}

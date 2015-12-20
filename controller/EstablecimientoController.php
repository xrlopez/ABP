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
require_once(__DIR__."/../model/IngredienteMapper.php");
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
    $this->ingredienteMapper = new IngredienteMapper();
  }
  
  
  /*redirecciona a la página principal del sitio web*/
  public function index() {
  
    $establecimiento = $this->establecimientoMapper->findAll();  
    $concursos = $this->concursoMapper->findConcurso("pinchosOurense");   
    $this->view->setVariable("establecimiento", $establecimiento); 
    $this->view->setVariable("concursos", $concursos);    
    
    $this->view->render("concursos", "index");
    
  }

  /*redirecciona a la vista del perfil del establecimiento*/
  public function perfil(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "perfil");
  }
  
  /*recupera la informacion de un establecimiento y la muestra en la vista de la informacion*/
  public function info(){
    $establecimiento = $this->establecimientoMapper->findById($_GET["id"]);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "info");	
  }

  /*redirecciona al formulario de modificacion de los datos de un establecimiento*/
  public function modificar(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $this->view->setVariable("establecimiento", $establecimiento);
    $this->view->render("establecimiento", "modificar");
  
  }

  /*Llama a delete() de EstablecimientoMapper.php, donde se elimina un establecimiento indicado,
  se destruye la sesion de dicho establecimiento y se redirecciona a la página principal del sitio web.*/
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
  
  /*Recupera los datos del formulario de modificacion de un establecimiento,
  comprueba que son correctos y llama a update() de EstablecimientoMapper.php
  donde se realiza la actualizacion de los datos.*/
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

  /*Genera un número de codigos, indicado por el establecimiento, para el pincho de dicho establecimiento.*/
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
      header("Location: noPin.php");
    }
  }

  /*Recupera los datos de todos los establecimiento con pinchos validados y
  redireccionan a la vista donde los lista.*/
  public function listar(){
    $establecimientos = $this->establecimientoMapper->findAllValidados();  
    $this->view->setVariable("establecimientos", $establecimientos); 
    $this->view->render("establecimiento", "listar");

  }

  /*Recupera los datos del pincho de un determinado establecimiento*/
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

  /*Recupera la información de un establecimiento*/
  public function getInfo(){
    $estab = $_GET["id"];
    $establecimiento = $this->establecimientoMapper->findById($estab);
    $this->view->setVariable("esta", $establecimiento); 
    $this->view->render("establecimiento", "index");

  }

  /*-En caso de que no haya un pincho registrado, redirecciona al formulario de registro.
    -En caso de que haya un pincho registrado y no validado, deja modificar los datos.
    -En caso de que haya un pincho valido, muestra un mensaje.*/
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

  /*Redirecciona al formulario de modificacion*/
  public function modPincho(){
    $currentuser = $this->view->getVariable("currentusername");
    $establecimiento = $this->establecimientoMapper->findById($currentuser);
    $pincho = $this->pincho->findByEstablecimiento($establecimiento);
    $this->view->setVariable("pincho",$pincho);
    $this->view->render("establecimiento", "modPincho");
  }

  /*Recupera los datos del formulario de modificacion de un pincho, comprueba que los
  datos sean correctos y llama a modPincho() de EstablecimientoMapper.php, que los modifica.*/
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
            $pincho = $this->pincho->findByEstablecimiento($establecimiento);
            if(isset($_POST["ingredientesSelected"])){
              $ingredientesOld = $this->ingredienteMapper->getIngredientes($pincho->getId());
              $ingredientesPOST = $_POST["ingredientesSelected"];
              $ingredientesNew = array_unique($ingredientesPOST, SORT_STRING);

              foreach ($ingredientesOld as $ingrediente) { 
                if(!in_array($ingrediente,$ingredientesNew,TRUE)){
                  $this->ingredienteMapper->delete($pincho,$ingrediente->getIngrediente());
                }
              }
              foreach ($ingredientesNew as $ingrediente) { 
                  if(!in_array($ingrediente,$ingredientesOld,TRUE) AND !empty($ingrediente)){
                    $this->ingredienteMapper->insert($pincho,$ingrediente);
                }
              }
            }


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

  /*En caso de que haya un pincho sin validar lo elimina*/
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

  /*Recupera los datos del formulario de registro de un pincho, comprueba que los
  datos sean correctos y llama a savePincho() de EstablecimientoMapper.php, que lo registra.*/
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
            $pincho = $this->pincho->findByEstablecimiento($establecimiento);
            if(isset($_POST["ingredientesSelected"])){
              $ingredientesPOST = $_POST["ingredientesSelected"];
              $ingredientesNew = array_unique($ingredientesPOST, SORT_STRING);
              foreach ($ingredientesNew as $ingrediente) { 
                  if(!empty($ingrediente)){
                    $this->ingredienteMapper->insert($pincho,$ingrediente);
                  }
              }
            }
            $this->view->setFlash("Pincho ".$pinc->getNombre()." registrado.");
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

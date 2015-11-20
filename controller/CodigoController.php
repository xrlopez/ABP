<?php


require_once(__DIR__."/../model/Establecimiento.php");
require_once(__DIR__."/../model/JuradoPopular.php");
require_once(__DIR__."/../model/Codigo.php");
require_once(__DIR__."/../model/CodigoMapper.php");
require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/JuradoPopularMapper.php");

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../controller/BaseController.php");
require_once(__DIR__."/../controller/UsersController.php");

class JuradoPopularController extends BaseController {
  
 
  private $juradoPopularMapper;
  private $concursoMapper; 
  private $userMapper;  
  
  public function __construct() { 
    parent::__construct();
    
    $this->juradoPopularMapper = new JuradoPopularMapper();  
    $this->concursoMapper = new ConcursoMapper();   
    $this->userMapper = new UserMapper(); 
  }
  
  
  
}

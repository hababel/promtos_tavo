<?php
    session_start();
    $ajaxresponse = false; // Esta variable es para detectar si es peticion ajax o no 
    
    require_once("core/config/config.php");
    require_once("core/config/router.php");
    require_once("core/config/conn.php");
    require_once("core/config/recursos.php");

    ini_set('display_errors', 2);
    ini_set('display_startup_errors', 2);
    error_reporting(E_ALL); 

    $router=new router();
    
    $controller=$router->getController();
     //$controller="login";
    $method=$router->getMethod();
      //$method="index";
    $param=$router->getParam();
     //$param="";

    $path_controller = "app/controller/" . $controller . "Controller.php";

    if (file_exists($path_controller)) {
        
      require_once $path_controller;
      
      $controller = ucwords($controller) . 'Controller';
      $controller = new $controller; //Instancia del controlador
      
      if (method_exists($controller, $method)) {
          
        $controller->$method($param);// Llamada a la accion
        
      } else {
          
        header("Location:" . URL_PATH . "error/outsession",true,301);
        die();

        // echo "No se encuentra el metodo que se esta escribiendo".$method;
      }
      
    } else {
      //echo  "Ruta no existe".$path_controller;
      header("Location:" . URL_PATH . "error/outsession",true,301);
      die();
    }


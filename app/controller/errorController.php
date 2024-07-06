<?php

class ErrorController{
  
  function index(){
    echo "Ingreso al Controller error del metodo Index";
  }

  function sintenant()
  {
    $content_view = "error/sintenant.php";
    require_once("app/view/template/template.php");
  }

function errorinicio(){
		$content_view = "error/errorinicio.php";
    require_once("app/view/template/template.php");
}

	function outsession(){
		require_once ("app/view/error/outsession.php");
	}
}

<?php

require_once("app/model/clientesModel.php");
require_once("app/model/serviciosModel.php");


class ClientesController
{

  private $instmodelcliente;
  private $instmodelservicios;
	private $hoy;
	private $fechacreacion;

  private $permisosCliente;

  function __construct()
  {
    $this->instmodelcliente = new ClientesModel();
    $this->instmodelservicios = new ServiciosModel();
		$this->hoy = new Datetime();
		$this->fechacreacion = $this->hoy->format('Y-m-d H:i:s');
   
  }


  function index()
  {

    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }
   
    $this->permisosCliente = calcularpermisos(3, $_SESSION['user']['MatrizPermisos']);
		$lista_clientes=$this->lista_clientes_permitidos();
    $method = get_class($this);
    $name_method = explode("Controller", $method);
    $use_method = (isset($name_method[0]) ? $name_method[0] : null);
    $carga_function = "function_cliente.js";
    $content_view = "clientes/index.php";
    $title_section = "Clientes";
    require_once("app/view/template/template.php");
  }

	function formnuevocliente(){
		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		$this->permisosCliente = calcularpermisos(3, $_SESSION['user']['MatrizPermisos']);
		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$carga_function = "function_cliente.js";
		$content_view = "clientes/nuevocliente.php";
		$title_section = "Clientes";
		require_once ("app/view/template/template.php");
	}

  function findemailcliente()
  {
    $email_user = $_POST["email"];
    $list_email_cliente = $this->instmodelcliente->findemailcliente($email_user);
    echo $list_email_cliente->findemailcliente;
  }

  function nuevoCliente()
  {
    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }

    if ($_POST) {

      $email_cliente = filter_var(strip_tags(htmlentities(trim($_POST["email_cliente"]))), FILTER_SANITIZE_EMAIL);
      $nombre_cliente = strip_tags(htmlentities(trim($_POST["nombre_cliente"])));
      $apellidos_cliente = strip_tags(htmlentities(trim($_POST["apellidos_cliente"])));
      $telefono1_cliente = strip_tags(htmlentities(trim($_POST["telefono1_cliente"])));
      $telefono2_cliente = (!isset($_POST["telefono2_cliente"])) ? null : strip_tags(htmlentities(trim($_POST["telefono2_cliente"])));
      $notas_cliente = (!isset($_POST["notas_cliente"])) ? null : strip_tags(htmlentities($_POST["notas_cliente"]));
      $clasificacion = ($_POST["clasificacion"]);
      $nombre_recomendado = ($_POST["nombre_recomendado"]) ? strip_tags(htmlentities($_POST["nombre_recomendado"])) : null;
      $fuente = ($_POST["fuente"]) ? strip_tags(htmlentities($_POST["fuente"])) : null;
      $direcciones = ($_POST["direccionesselect"]) ? (($_POST["direccionesselect"])) : null;
      $token_cliente = setToken($email_cliente);
      $usuarioCreacion = openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY);
      $documento_cliente = strip_tags(htmlentities(trim($_POST["documento_cliente"])));

			var_dump($direcciones);

      $CrearCliente = $this->instmodelcliente->crear_cliente(
        $nombre_cliente,
        $apellidos_cliente,
        $email_cliente,
        $telefono1_cliente,
        $telefono2_cliente,
        $clasificacion,
        $notas_cliente,
        1,
        $token_cliente,
        $usuarioCreacion,
        $this->fechacreacion,
        $nombre_recomendado,
        $fuente,
        $direcciones,
        $documento_cliente
      );


			$array_response=($CrearCliente)?array("status" => true, "type" => "success", "title" => "Exito!", "msg" => "Cliente creado con exito!","data" => $CrearCliente): array("status" => false, "type" => "danger", "title" => "Error", "msg" => "Hubo un error al crear el cliente, comuniquese con soporte.","data" => $CrearCliente);
			$_SESSION['msg'] = $array_response;

			header("Location:" . URL_PATH . "clientes", true, 301);
    } else {
      header("Location:" . URL_PATH, true, 301);
    }
  }

  function lista_clientes_permitidos()
  {

    $array_clientes = array();
   
    $lista_clientes_DB = $this->instmodelcliente->listar_clientes(1);

		$fecha_hoy = new DateTime();
    if (count($lista_clientes_DB) > 0) {
			$html_servicios_content=null;

      $array_row = array();
      foreach ($lista_clientes_DB as $key => $value) {
				$html_servicios=null;
				$antiguedad = "";
				$servicios_cliente=($value->CantidadServiciosAbiertos > 0)?$this->instmodelservicios->lista_servicios([0,1,2,3],1, $value->IDCliente):null;

				if($servicios_cliente){
					$html_servicios='<ol class="list-group list-group-numbered">';
					foreach ($servicios_cliente as $key2 => $value2) {

						$FechaHoraPlaneadaTerminacion = $value2->FechaServicio . " " . $value2->HoraPlaneadaTerminacion;
						$FechaHoraPlaneacionInicio = $value2->FechaServicio . " " . $value2->HoraPlaneacionInicio;
						$fechavencimientofinal_segun_prioridad = new DateTime($FechaHoraPlaneadaTerminacion);
						$fecha_vencimiento_final = $fechavencimientofinal_segun_prioridad->modify('+' . $value2->HorasFinalRespuesta . ' hours');
						$diff_fechavencimientoFinal = $fecha_vencimiento_final->diff($fecha_hoy);
						$text_tooltip = "<strong>Vencido</strong> x " . $diff_fechavencimientoFinal->d . "d:" . $diff_fechavencimientoFinal->h . "h.<br>Debio cerrarse el: " . $fecha_vencimiento_final->format("Y-m-d h:m:s");

						$IDServicio_encrypt = urlencode(openssl_encrypt($value2->IDServicio, METHODENCRIPT, KEY));
						$html_servicios.='<li class="list-group-item d-flex justify-content-between align-items-start">
							<div class="ms-2 me-auto">
								<div class="fw-bold"><a href="'.URL_PATH.'servicio/fichaservicio?TKS='. $IDServicio_encrypt.'">OS-' . $value2->IDDoc . '</a></div>
								'. $text_tooltip.'
							</div>
						</li>';
					}
					$html_servicios.='</ol>';
					$html_servicios_content=htmlspecialchars($html_servicios, ENT_QUOTES, 'UTF-8');
				}

				// Calcular fecha antiguedad
				
				$fechacreacioncliente = new DateTime($value->FechaCreacionCliente);
				$diffantiguedad = $fecha_hoy->diff($fechacreacioncliente);

				$antiguedad=($diffantiguedad->y > 0)?
											(($diffantiguedad->y >= 1 && $diffantiguedad->y <= 3)?"de 1 - 3 años":(($diffantiguedad->y > 3 && $diffantiguedad->y <= 6)?"de 4 - 6 años": "+ de 6 años"))
											:
												(($diffantiguedad->m <= 6)?"1 - 6 meses":"+ de 6 meses");
											;

        $backgound_categoria = ($value->ClasificacionCliente)?config_categorias_cliente[$value->ClasificacionCliente]["backgound_categoria"]:null;
        $color_font = ($value->ClasificacionCliente)?config_categorias_cliente[$value->ClasificacionCliente]["color_font"]:null;
        $style_font = ($value->ClasificacionCliente)?config_categorias_cliente[$value->ClasificacionCliente]["style_font"]:null;

        $badgeClasificacionCliente = ($backgound_categoria)?'<span class="badge" style="font-size:0.7rem;font-style:' . $style_font . '; font-weight: bold;color:' . $color_font . ';background-color: ' . $backgound_categoria . '"><span class="mx-2">' . (($value->ClasificacionCliente === "VIP") ? '<i class="bi bi-gem" style="color:green;margin-right: 10px;"></i>' : "") . $value->ClasificacionCliente . '</span></span>':'<span class="badge text-bg-light">- Sin categoria -</span>'; 
        $IDCLiente_encrypt = urlencode(openssl_encrypt($value->IDCliente, METHODENCRIPT, KEY));
        $array_row = array(
          "IDCliente" => $IDCLiente_encrypt,
          "NombreCompletoCliente" => '<a href="' . URL_PATH . 'clientes/ficha_cliente/?TICK=' . $IDCLiente_encrypt . '" style="text-decoration: none;" onclick="ver_ficha_cliente("' . openssl_encrypt($value->IDCliente, METHODENCRIPT, KEY) . '")">' . $value->NombreCompletoCliente . '</a>',
					"EstadoCliente" => $value->EstadoCliente,
          "ClasificacionCliente" => $badgeClasificacionCliente,
          "FuenteCreacion" => $value->FuenteCreacion,
          "NombreRecomendado" => $value->NombreRecomendado,
          "Telefono1Cliente" => $value->Telefono1Cliente,
          "Telefono2Cliente" => '<a href="https://api.whatsapp.com/send?phone=' .  $value->Telefono2Cliente . '" class="me-3" style="text-decoration: none;color:green" target="_blank"> <i class="bi bi-whatsapp"></i></a>' . $value->Telefono2Cliente,
					"ServiciosAbiertos" => $html_servicios,
					"CantServicios"=>($servicios_cliente)?count($servicios_cliente):0,
					"Antiguedad"=>$antiguedad
        );
        array_push($array_clientes, $array_row);
				$antiguedad = "";
      }
      $array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $array_clientes);
    } else {
      $array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Hubo un error, por favor comuniquese con soporte", "data" => $lista_clientes_DB);
    }

    return($array_clientes);
  }

  function find_documento_cliente()
  {
    $documento_cliente = $_POST["documento_cliente"];
    $list_cliente = $this->instmodelcliente->find_documento_cliente($documento_cliente);
    echo $list_cliente->find_documento_cliente;
  }

  function ficha_cliente()
  {

    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }

    if ($_GET) {
      $IDCliente = urldecode(openssl_decrypt($_GET["TICK"], METHODENCRIPT, KEY));
      $this->permisosCliente = calcularpermisos(3, $_SESSION['user']['MatrizPermisos']);
      
      $data_ficha_cliente = $this->instmodelcliente->ficha_cliente($IDCliente);
      $method = get_class($this);
      $name_method = explode("Controller", $method);
      $use_method = (isset($name_method[0]) ? $name_method[0] : null);
      $carga_function = "function_cliente.js";
      $content_view = "clientes/ficha_cliente.php";
      $title_section = "Clientes";
      require_once("app/view/template/template.php");
    } else {
      header("Location:" . URL_PATH, true, 301);
    }
  }

  function lista_direccionxcliente()
  {
    if ($_POST) {
      $IDCliente_POST= urldecode($_POST["IDCliente"]);
      $IDCliente = (openssl_decrypt($IDCliente_POST, METHODENCRIPT, KEY));
     
      $lista_direccionxcliente = $this->instmodelcliente->lista_direccionxcliente($IDCliente);
      $array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $lista_direccionxcliente);
      echo json_encode($array_response);
    }else{
      header("Location:" . URL_PATH, true, 301);
      exit();
    }
  }

  function ficha_cliente_ajax(){
    if ($_POST) {
      $IDCliente = urldecode($_POST["IDCliente"]);
      $data_ficha_cliente = $this->instmodelcliente->ficha_cliente(openssl_decrypt($IDCliente, METHODENCRIPT, KEY));
      $array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $data_ficha_cliente);
      echo json_encode($array_response);
    } else {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }
  }


	function cambioestadoajax(){

		$historialArray=array();

		$IDCliente = openssl_decrypt($_POST['TICK'], METHODENCRIPT, KEY) ;
		$nuevoEstado = $_POST['nuevoEstado'];
		$inputjustificacioncambioestado=($_POST['inputjustificacioncambioestado']);

		$datacliente=$this->instmodelcliente->listar_clientes(null, $IDCliente);

		$historialActual = $datacliente->LogEstados;

		// Guardar en el log de transacciones (esto es un ejemplo, ajusta según tu lógica y base de datos)
		$arraylogchangestadocliente=array(
				"usuariocreacion"=> $_SESSION['user']['NombreUsuario']." ".$_SESSION['user']['ApellidosUsuario'],
				"fechaasignacion"=> $this->fechacreacion,
				"estadonuevo"=>$nuevoEstado,
				"inputjustificacioncambioestado"=> $inputjustificacioncambioestado
		);

		if (!empty($historialActual)) {
			// Decodificar el historial actual y agregar el nuevo registro al inicio

			$historialArray = json_decode($historialActual, true);
			array_unshift($historialArray, $arraylogchangestadocliente);
		}else{
			$historialArray[]=$arraylogchangestadocliente;
		}
		
		$nuevo_historialjson = json_encode($historialArray);
		$respuesta=$this->instmodelcliente->updatecliente_estado($IDCliente,$nuevoEstado, $nuevo_historialjson,null,null);
		$array_response = array("status" => $respuesta, "type" => (($respuesta)?"success":"warnign"), "title" => (($respuesta) ? "Cambiado" : "Error!"), "msg" => (($respuesta) ?
"Cambio de estado hecho correctamente." : "Hubo un error, por favor comuniquese con soporte."),"data"=> $nuevo_historialjson);
		 echo json_encode($array_response);
		// echo $nuevo_historialjson ;
	}
}

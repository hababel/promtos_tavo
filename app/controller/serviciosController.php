<?php

require_once("app/model/serviciosModel.php");
require_once("app/model/clientesModel.php");

class ServiciosController
{

	private $instmodelservicios;
	private $instmodelclientes;

	function __construct()
	{
		$this->instmodelservicios = new serviciosModel();
		$this->instmodelclientes = new clientesModel();
	}
	function index()
	{

		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}
		$lista_servicios_abiertos = $this->listar_servicios();

		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$content_view = "servicios/index.php";
		$carga_function = "function_servicios.js";
		$title_section = "Servicios";
		require_once("app/view/template/template.php");
	}

	function nuevoservicio()
	{
		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}
		$lista_clientes = $this->instmodelclientes->listar_clientes(1);
		$lista_prioridades = $this->instmodelservicios->listar_prioridades(1);
		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$content_view = "servicios/nuevoservicio.php";
		$carga_function = "function_servicios.js";
		$title_section = "Servicios";
		require_once("app/view/template/template.php");
	}

	function listar_servicios($IDCliente=null, $IDServicio=null)	{

		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		if ($IDCliente && $IDServicio==null) {
			$lista_servicios = $this->instmodelservicios->lista_servicios(null, null,	$IDCliente);
		} else if ($IDCliente==null && $IDServicio==null){
			$serviciosabiertos = $this->instmodelservicios->lista_servicios([0,1,2,3],1,null);
			$servicioscerrados = $this->instmodelservicios->lista_servicios([4],1,null);
			$serviciosanulados = $this->instmodelservicios->lista_servicios([5],1,null);

			$lista_servicios = array(
				"serviciosabiertos" => $serviciosabiertos,
				"servicioscerrados" => $servicioscerrados,
				"serviciosanulados" => $serviciosanulados
			);
		}else if($IDServicio && $IDCliente == null){
			$lista_servicios=$this->instmodelservicios->lista_servicios([0,1,2,3,4,5], null,null,$IDServicio);
		}

		return $lista_servicios;
	}

	function listareventosparacalendario()
	{
		$json_servicios_eventos = array();
		$listar_eventos_paracalendario = $this->instmodelservicios->listar_eventos_paracalendario([0, 1, 2, 3], 1);
		foreach ($listar_eventos_paracalendario as $key => $value) {
			$row_servicio_eventos = array(
				"id" => openssl_encrypt($value->IDServicio ?? '00', METHODENCRIPT, KEY),
				"title" => "OS-" . $value->IDDoc,
				"FechaServicioCreacion" => $value->FechaServicioCreacion,
				"start" => $value->FechaServicio . "T" . $value->HoraPlaneacionInicio,
				"end" => $value->FechaServicio . "T" . $value->HoraPlaneadaTerminacion,
				"IDTecnicoAsignado" => ($value->IDTecnicoAsignado)? openssl_encrypt($value->IDTecnicoAsignado, METHODENCRIPT, KEY):'00'   ,
				"NombreTecnicoAsignado" => $value->NombreTecnicoAsignado,
				"tecnico" => $value->NombreCortoTecnico ?? 'Sin tecnico asignado',
				"IDUsuarioCreacion" => openssl_encrypt($value->IDUsuarioCreacion, METHODENCRIPT, KEY),
				"NombreUsuarioCreador" => $value->NombreUsuarioCreador,
				"IDPrioridad" => $value->IDPrioridad,
				"DescripcionPrioridad" => $value->DescripcionPrioridad,
				"ColorPrioridad" => $value->ColorPrioridad,
				"HorasInicialRespuesta" => $value->HorasInicialRespuesta,
				"HorasFinalRespuesta" => $value->HorasFinalRespuesta,
				"Serial" => $value->Serial,
				"DescripcionEquipo" => $value->DescripcionEquipo,
				"ModeloEquipo" => $value->ModeloEquipo,
				"EquipoMarca" => $value->EquipoMarca,
				"NombreDireccion" => $value->NombreDireccion,
				"BarrioCiudad" => $value->BarrioCiudad,
				"PrincipalDir" => $value->PrincipalDir,
				"NombreCliente" => $value->NombreCliente,
				"backgroundColor" => ($value->ColorTecnico) ? $value->ColorTecnico : "#E4E7E4",
				"textColor" => ($value->ColorTecnico) ? "" : "#000000",
				"Notas" => $value->Notas,
				"FechaHoraTomado" => $value->FechaHoraTomado,
				"EstadoTomado" => $value->EstadoTomado,
				"EstadoServicio" => definicion_estado_servicio($value->EstadoServicio)
			);

			array_push(
				$json_servicios_eventos,
				$row_servicio_eventos
			);
		}

		echo json_encode($json_servicios_eventos);
	}

	function listartecnicosdisponibles()
	{
		$horainicial = (isset($_POST['horainicial'])?$_POST['horainicial']:null);
		$horafinal = (isset($_POST['horafinal'])?$_POST['horafinal']:null);
		$fecha = (isset($_POST['horafinal'])?$_POST['fecha']:null);

		$lista_tecnicos_json = array();

		$lista_tecnicos_disponibles = $this->instmodelservicios->listadotecnicosdisponibles($fecha, $horainicial, $horafinal);

		$sintecnicoasignado = array(
			"IDTecnico" => "00",
			"NombreCompletoTecnico" => "Sin tecnico asignado",
			"NombreCortoTecnico" => "Sin tecnico asignado",
			"CalificacionTecnica" => null,
			"ColorTecnico" => "#E4E7E4"
		);
		array_push($lista_tecnicos_json, $sintecnicoasignado);

		foreach ($lista_tecnicos_disponibles as $key => $value) {
			$row_servicio_eventos = array(
				"IDTecnico" => openssl_encrypt($value->IDUser, METHODENCRIPT, KEY),
				"NombreCompletoTecnico" => $value->NombreCompletoTecnico,
				"NombreCortoTecnico" => $value->NombreCortoTecnico,
				"CalificacionTecnica" => $value->CalificacionTecnica,
				"ColorTecnico"=> $value->ColorTecnico
			);
			array_push($lista_tecnicos_json, $row_servicio_eventos);
		}

		header('Content-Type: application/json');
		 echo json_encode($lista_tecnicos_json);
	}

	function insertarservicionuevo()
	{
		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}
		if (!$_POST) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		$Estado = $_POST["Estado"];
		$FechaServicio = $_POST["FechaServicio"];
		$HoraPlaneacionInicio = $_POST["HoraPlaneacionInicio"];
		$HoraPlaneadaTerminacion = $_POST["HoraPlaneadaTerminacion"];
		$IDTipoServicio = $_POST["IDTipoServicio"];
		$IDEquipoCliente = $_POST["IDEquipoCliente"];
		$DescripcionCausa = $_POST["DescripcionCausa"];
		$IDPrioridad = $_POST["IDPrioridad"];
		$Notas = $_POST["Notas"];
		$IDTecnicoAsignado = (((strlen(openssl_decrypt($_POST["IDTecnicoAsignado"], METHODENCRIPT, KEY)))>0) ? (openssl_decrypt($_POST["IDTecnicoAsignado"], METHODENCRIPT, KEY)):null);
		$Evento_seleccionado = json_decode($_POST["Evento_seleccionado"]);
		

		// Validar variables obligatorioas vacias
		if (strlen($IDEquipoCliente) > 0 
				|| strlen($Estado) > 0 
				|| strlen($DescripcionCausa) > 0 
				|| strlen($IDPrioridad) > 0
				|| strlen($IDTipoServicio) > 0) {

			$hoy = new Datetime();
			$FechaServicioCreacion = $hoy->format('Y-m-d H:i:s');
			//var_dump($Evento_seleccionado->extendedProps->IDTecnicoAsignado);

			 $Insertar_servicio=$this->instmodelservicios->InsertarNuevoServicio(
				$FechaServicioCreacion,
				openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY),
				$Estado,
				$FechaServicio,
				$HoraPlaneacionInicio,
				$HoraPlaneadaTerminacion,
				$IDTipoServicio,
				$IDEquipoCliente,
				$DescripcionCausa,
				$IDPrioridad,
				0,
				(($Evento_seleccionado != null)? openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY):null),
				(($Evento_seleccionado != null) ? $FechaServicioCreacion : null),
				(($Evento_seleccionado != null) ? $IDTecnicoAsignado : null),
				(($Evento_seleccionado != null) ? openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY) : null),
				(($Evento_seleccionado != null) ? $FechaServicioCreacion : null),
				$Notas
			);
			if($Insertar_servicio){
				$array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $Insertar_servicio);
			}else{
				$array_response = array("status" => false, "type" => "Danger", "title" => "Error", "data" => "No fue posible insertar el nuevo Servicio.  Por favor comuniquese con soporte.  -> ".$Insertar_servicio);
			}
			
		}else{
			$array_response = array("status" => false, "type" => "Warning", "title" => "Atencion", "data" => "Por favor complete los datos faltantes");
		}
		echo json_encode($array_response);
	}

	function detalleservicio(){

		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		$IDServicio=isset($_GET['IDServicio'])?	
		urldecode(openssl_decrypt($_GET['IDServicio'], METHODENCRIPT, KEY))
 		:
		header("Location:" . URL_PATH, true, 301);

		$listaprioridades = $this->instmodelservicios->listaprioridades();
		$detalle_servicio = $this->listar_servicios(null, $IDServicio);
		
		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$content_view = "servicios/detalleservicio.php";
		$carga_function = "function_detalleservicio.js";
		$title_section = "Detalle Servicio";
		require_once ("app/view/template/template.php");

	}

	function addnewactivity() {

		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		if ($_SERVER['REQUEST_METHOD']!== 'POST') {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}

		$urldecodeIDServicio= rawurldecode($_POST["IDServicio"]);
		$hoy = new Datetime();
		$FechaServicioCreacion = $hoy->format('Y-m-d H:i:s');
		$IDUser=openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY);
		$IDServicio=openssl_decrypt($urldecodeIDServicio, METHODENCRIPT, KEY);
		$estadonuevaactividad=$_POST["estadonuevaactividad"];
		$EstadoActualServicio=$_POST["EstadoActualServicio"];
		$insertarnuevaactividad= $this->instmodelservicios->InsertarNuevaActividad($IDServicio, $IDUser, $FechaServicioCreacion, $_POST["DescripcionActividad"], $estadonuevaactividad, $EstadoActualServicio);
		echo $insertarnuevaactividad;
	}

	function listaractividadesajax(){

			if (!isset($_SESSION['session_id'])) {
				header("Location:" . URL_PATH, true, 301);
				exit();
			}

			if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
				header("Location:" . URL_PATH, true, 301);
				exit();
			}

			$IDServicio = openssl_decrypt(urldecode($_GET["IDServicio"]), METHODENCRIPT, KEY);
			$listasactividadesajax = $this->instmodelservicios->ListarActividadesxServicio($IDServicio);

			if($listasactividadesajax){
				$array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $listasactividadesajax);
			}else{
				$array_response = array("status" => true, "type" => "danger", "title" => "Error","msg"=>"No fue posible realizar la consulta de las actividades, popr facvor comuniquese con soporte", "data" => $listasactividadesajax);
			}

			echo json_encode($array_response);

	}



}

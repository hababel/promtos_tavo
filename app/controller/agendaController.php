<?php

// require_once("app/model/agendaModel.php");
require_once("app/model/clientesModel.php");
require_once("app/model/serviciosModel.php");


class AgendaController
{

	private $instmodelclientes;
	private $instmodelservicios;

	public function __construct()
	{
		$this->instmodelclientes = new clientesModel();
		$this->instmodelservicios = new serviciosModel();
	}

	function index()
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
		$content_view = "agenda/index.php";
		$carga_function = "function_agenda.js";
		$title_section = "Agenda Servicios";
		require_once("app/view/template/template.php");
	}

	function crearNuevoServicio()
	{
		// Obtener los valores de los parámetros enviados a través de AJAX
		$fecha = $_POST["fecha"];
		$HoraPlaneacionInicio = DateTime::createFromFormat('H:i', $_POST["hora1"])->format('H:i:s');
		$HoraPlaneadaTerminacion =	DateTime::createFromFormat('H:i', $_POST["hora2"])->format('H:i:s');
		$cliente = $_POST["cliente"];
		$direccion = $_POST["direccion"];
		$IDEquipoCliente = $_POST["equipo"];
		$IDTipoServicio = $_POST["tipoServicio"];
		$IDPrioridad = $_POST["prioridad"];
		$DescripcionCausa = $_POST["descripcion"];
		$estado = $_POST["estado"];
		$IDTecnicoAsignado = rawurldecode($_POST['tecnico']);
echo $IDTecnicoAsignado;
		$today = date("Y-m-d H:i:s");


		$Insertar_servicio = $this->instmodelservicios->InsertarNuevoServicio(
			$today,
			openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY),
			$estado,
			$fecha,
			$HoraPlaneacionInicio,
			$HoraPlaneadaTerminacion,
			$IDTipoServicio,
			$IDEquipoCliente,
			$DescripcionCausa,
			$IDPrioridad,
			0,
			(($IDTecnicoAsignado != null) ? openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY) : null),
			(($IDTecnicoAsignado != null) ? $today : null),
			(($IDTecnicoAsignado != null) ? openssl_decrypt($IDTecnicoAsignado, METHODENCRIPT, KEY) : null),
			null,
			null,
			null
		);

		var_dump($Insertar_servicio);
	}
}

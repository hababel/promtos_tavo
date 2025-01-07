<?php
class DashboardController
{

	protected $permisos;
	protected $idrecurso = 9;

	function __construct()
	{

		if (isset($_SESSION['user'])) {
			$this->permisos = ($_SESSION['user']['MatrizPermisos']) ? calcularpermisos($this->idrecurso, $_SESSION['user']['MatrizPermisos']) : NULL;
		}
	}

	public function index()
	{

		if (!isset($_SESSION['user'])) {
			if (!$_SESSION['user']) {
				header("Location:" . URL_PATH . "/error/sintenant", true, 301);
				exit();
			}
		}

		if(!$_SESSION['user']['perfiles_Asignados']){
			$sessData['status']['type'] = 'danger';
			$sessData['status']['title'] = 'Error';
			$sessData['status']['msg'] = 'Hola <strong>' . $_SESSION['user']['NombreUsuario'] . "</strong>.<br><br> No tienes acceso a la plataforma, comunicate con tu administrador. (Sin perfil asignado)";
			$_SESSION['sessData'] = $sessData;
			header("Location:" . URL_PATH . "error/sintenant", true, 301);
			die();
		}

		$permisosProducto = calcularpermisos(4, $_SESSION['user']['MatrizPermisos']);
		$permisosCliente = calcularpermisos(3, $_SESSION['user']['MatrizPermisos']) ;
		$permisosServicios = calcularpermisos(5, $_SESSION['user']['MatrizPermisos']);
		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$content_view = "dashboard/index.php";
		$title_section = "Dashboard";
		require_once("app/view/template/template.php");
	}
}

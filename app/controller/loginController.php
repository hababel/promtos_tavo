<?php

require_once("app/model/loginModel.php");


class LoginController
{

	public $instmodel;
	public $intperfilcontroller;

	public function __construct()
	{
		$this->instmodel = new LoginModel();
	}

	function index()
	{
		if (!isset($_SESSION['user'])) {
			require_once(RUTA_VISTAS . "login/index.php");
		} else {
			header("Location:" . URL_PATH . "dashboard", true, 301);
			die();
		}
	}

	function reports()
	{
		$method = __METHOD__;
		$name_method = explode("::", $method);
		$use_method = (isset($name_method[1]) ? $name_method[1] : null);
		require_once(URL_PATH . "template/template.php");
	}

	function overview()
	{
		$method = __METHOD__;
		$name_method = explode("::", $method);
		$use_method = (isset($name_method[1]) ? $name_method[1] : null);
		require_once("app/view/template/header.php");
		require_once("app/view/template/footer.php");
	}

	public function authlogin()
	{

		if (!isset($_SESSION['user'])) {
			if ($_POST) {
				if (isset($_POST['login_email']) || strlen(trim($_POST['login_email'])) > 3) {
					$login_email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);
					$login_pass = trim($_POST['login_pass']);
					$foundemailuser = $this->instmodel->get_auth($login_email);

					if ($foundemailuser) { // Si el correo existe

						if ($foundemailuser->EstadoUsuario == 0) {
							$sessData['status']['type'] = 'warning';
							$sessData['status']['title'] = 'Atencion';
							$sessData['status']['msg'] = 'Este usuario <b class="text-decoration-underline">no esta habilitado para el ingreso.</b> comuniquese con el Administrador de la organización.';
							$_SESSION['sessData'] = $sessData;
							header("Location:" . URL_PATH, true, 301);
							die();
						} else {
							if (strlen($login_pass) > 5) {
								if (password_verify($login_pass, $foundemailuser->PassUser)) {
									$array_listaperfilesasignados = explode(",", $foundemailuser->perfiles_asignados);

									if (!in_array(1, $array_listaperfilesasignados)) {
										$matrizpermisosxusuario = $this->instmodel->permission_profile_user_resource($foundemailuser->TokenUser);
									}

									$_SESSION['session_id'] = session_id();

									$_SESSION['user'] = array(
										'IDUser' => openssl_encrypt($foundemailuser->IDUser, METHODENCRIPT, KEY),
										'NombreUsuario' => $foundemailuser->NombreUsuario,
										'ApellidosUsuario' => $foundemailuser->ApellidosUsuario,
										'EmailUsuario' => $foundemailuser->EmailUsuario,
										'FechaCreacion' => $foundemailuser->FechaCreacion,
										'TKU' => $foundemailuser->TokenUser,
										'EstadoUsuario' => $foundemailuser->EstadoUsuario,
										'MatrizPermisos' => $matrizpermisosxusuario,
										'D10S' => in_array(1, $array_listaperfilesasignados) ? 1 : 0,
										"perfiles_Asignados"=> (($foundemailuser->perfiles_asignados) ? openssl_encrypt($foundemailuser->perfiles_asignados, METHODENCRIPT, KEY) : null)
									);

									header("Location:" . URL_PATH . "dashboard", true, 301);
									die();
								
								} else {
									$sessData['status']['type'] = 'danger';
									$sessData['status']['title'] = 'Error';
									$sessData['status']['msg'] = 'Usuario o clave incorrectos.';
									$_SESSION['sessData'] = $sessData;
									header("Location:" . URL_PATH, true, 301);
									die();
								}
							} else {
								$sessData['status']['type'] = 'danger';
								$sessData['status']['title'] = 'Error';
								$sessData['status']['msg'] = 'Usuario o clave incorrectos.';
								$_SESSION['sessData'] = $sessData;
								header("Location:" . URL_PATH, true, 301);
								die();
							}
						}
					} else { // Si el correo no existe
						$sessData['status']['type'] = 'danger';
						$sessData['status']['title'] = 'Error';
						$sessData['status']['msg'] = 'Usuario o clave incorrectos.';
						$_SESSION['sessData'] = $sessData;
						header("Location:" . URL_PATH, true, 301);
						die();
					}
				} else { // Si no hay POST del correo desde login o esta vacio
					$sessData['status']['type'] = 'danger';
					$sessData['status']['title'] = 'Error';
					$sessData['status']['msg'] = 'Datos enviados <b>no</b> pueden estar vacios.  Validar e intentar nuevamente.';
					$_SESSION['sessData'] = $sessData;
					header("Location:" . URL_PATH, true, 301);
					die();
				}
			} else {
				header("Location:" . URL_PATH, true, 301);
				die();
			}
		} else {
			header("Location:" . URL_PATH . "dashboard", true, 301);
			die();
		}
	}

	public function requestrememberpass()
	{
		$content_view = "login/recoverypass.php";
		$title_section = "Recuperar clave";
		require_once(RUTA_VISTAS . "/login/recoverypass.php");
	}

	public function recoverypass()
	{
		$string_vencimiento_recoverypass = HORAS_VENCIMIENTO_RECOVERYPASS;
		if (isset($_POST['forgotemail_form'])) {

			if (!empty($_POST['recover_email_input'])) {
				$recover_email_input = filter_var($_POST['recover_email_input'], FILTER_SANITIZE_EMAIL);
				$foundemailuser = $this->instmodel->validatelogin($recover_email_input);
				$fecha_actual = new DateTime();
				$fecha_vencimiento_recoverypass = $fecha_actual->add(new DateInterval('PT' . HORAS_VENCIMIENTO_RECOVERYPASS . 'H')); //Se define fecha de vencimiento de la fecha actual + 1 hora

				if (is_object($foundemailuser)) {

					$token_genered = password_hash(uniqid(mt_rand()) . $recover_email_input, PASSWORD_DEFAULT);
					$update_login_token = $this->instmodel->updatetoken($token_genered, $foundemailuser->TokenUser, $fecha_vencimiento_recoverypass->format('Y-m-d H:i:s'));
					if ($update_login_token) {
						$resetPassLink = URL_PATH . "login/resetpass/?token_code=" . $token_genered;
						$to = $foundemailuser->EmailUsuario;
						$subject = "App-Promtos recuperacion contraseña";

						/* Inicio  y construccion de plantilla para recuperacion de contraseña y envio de email  */
						$Dir = "app/view/template_email/recovery_pass.php";
						if (!file_exists($Dir)) {
							$File = false;
						} else {
							ob_start();
							$nombre = $foundemailuser->NameUser;
							include $Dir;
							$File = ob_get_contents();
							ob_end_clean();
						}
						/******************* */
						//echo $resetPassLink;
						$enviarmail = enviarEmail($nombre, $to, $File, $subject);
						if ($enviarmail) {
							$sessData['status']['type'] = 'success';
							$sessData['status']['title'] = 'Hecho!';
							$sessData['status']['msg'] = 'Verifica tu correo electrónico. (Si no lo encuentras busca en SPAM o correo no deseado) <br> Hemos enviado un enlace para recuperar tu acceso a la aplicación.  Sigue las instrucciones. <br><br> Por tu seguridad (y la nuestra), <b>tienes ' . HORAS_VENCIMIENTO_RECOVERYPASS .
							' hora(s) para cambiar la contraseña</b>, de lo contrario debes iniciar de nuevo el proceso.<br> Hora vencimiento: '. $fecha_vencimiento_recoverypass->format('h:i A');
							$_SESSION['sessData'] = $sessData;
							header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
							die();
						} else {
							$sessData['status']['type'] = 'danger';
							$sessData['status']['title'] = 'Error';
							$sessData['status']['msg'] = 'No pudimos enviar el correo electronico.  Comunicate con soporte.';
							$_SESSION['sessData'] = $sessData;
							header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
							die();
						}
					} else {
						$sessData['status']['type'] = 'danger';
						$sessData['status']['title'] = 'Error';
						$sessData['status']['msg'] = 'Un problema ha ocurrido, por favor intenta de nuevo.';
						$_SESSION['sessData'] = $sessData;
						header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
						die();
					}
				} else {
					$sessData['status']['type'] = 'danger';
					$sessData['status']['title'] = 'Error';
					$sessData['status']['msg'] = 'El correo que envías no está registrado en nuestra base de datos.  Por favor comunícate con el administrador de su organización.';
					$_SESSION['sessData'] = $sessData;
					header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
					die();
				}
			} else {
				$sessData['status']['type'] = 'warning';
				$sessData['status']['title'] = 'Atención';
				$sessData['status']['msg'] = 'Los datos son obligatorios, por favor escribe un correo electrónico.';
				$_SESSION['sessData'] = $sessData;
				header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
				die();
			}
		} elseif (isset($_POST['resetSubmit'])) {
			$fp_code = '';

			if (!empty($_POST['resetpassword']) && !empty($_POST['resetconfirmpassword']) && !empty($_POST['fp_code'])) {
				$fp_code = $_POST['fp_code'];
				if ($_POST['resetpassword'] !== $_POST['resetconfirmpassword']) {
					$sessData['status']['type'] = 'warning';
					$sessData['status']['title'] = 'Atención';
					$sessData['status']['msg'] = 'Las dos claves que escribes deben ser iguales. Intenta nuevamente.';
					$_SESSION['sessData'] = $sessData;
					header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
					die();
				} else {

					$prevUser = $this->instmodel->validatetoken($fp_code);
					if (!empty($prevUser)) {
						//Valida si el token esta vencido.
						$fechahoy = new DateTime();
						$fechatoken = new DateTime($prevUser->FechaVencimientoRecovery);

						if ($fechahoy <= $fechatoken) {
							$pass_form = $_POST['resetpassword'];
							$newpass = password_hash($pass_form, PASSWORD_DEFAULT);
							$update_pass = $this->instmodel->resetpass($newpass, $fp_code);

							if ($update_pass) {
								$sessData['status']['type'] = 'success';
								$sessData['status']['title'] = 'Hecho!';
								$sessData['status']['msg'] = 'Su cuenta de contraseña se ha restablecido con éxito. Inicie sesión con su nueva contraseña.<br>
                                <a href="' . URL_PATH . 'login">Ingresar</a></p>';
								$_SESSION['sessData'] = $sessData;
								header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
								die();
							} else {
								$sessData['status']['type'] = 'danger';
								$sessData['status']['title'] = 'Error';
								$sessData['status']['msg'] = 'Un problema ha ocurrido.  Por favor, intente de nuevo. Comuniquese con soporte.';
								$_SESSION['sessData'] = $sessData;
								header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
								die();
							}
						} else {
							$sessData['status']['type'] = 'warning';
							$sessData['status']['title'] = 'Lapson de tiempo vencido';
							$sessData['status']['msg'] = 'Lo sentimos, el lapso de tiempo valido para recuperar la contraseña, expiro.  Intente de realizar el proceso de recuperacion de contraseña de nuevo. <br>Recuerde que tiene un lapso de ' . HORAS_VENCIMIENTO_RECOVERYPASS . ' hora(s) para utilizar el enlace que le es enviado al correo electrónico.';
							$_SESSION['sessData'] = $sessData;
							header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
							die();
						}
					} else {
						$sessData['status']['type'] = 'danger';
						$sessData['status']['title'] = 'Error';
						$sessData['status']['msg'] = 'Usted no está autorizado para restablecer la contraseña de esta cuenta.';
						$_SESSION['sessData'] = $sessData;
						header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
						die();
					}
				}
			} else {
				$sessData['status']['type'] = 'warning';
				$sessData['status']['title'] = 'Warning';
				$sessData['status']['msg'] = 'Los datos son obligatorios, por favor escribe una nueva clave.';
				header("Location:" . URL_PATH . "login/requestrememberpass", true, 301);
				die();
			}
		}
	}

	public function resetpass()
	{
		if (isset($_REQUEST['token_code'])) {
			$token_code = $_REQUEST['token_code'];
			$title_section = "Crear nueva clave";
			require_once(RUTA_VISTAS . "login/resetpass.php");
		} else {
			header("Location: " . URL_PATH, true, 301);
		}
	}

	public function logout()
	{
		session_start();
		session_destroy();
		header("Location:" . URL_PATH, true, 301);
		exit();
	}
}

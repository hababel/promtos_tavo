<?php

require_once("app/model/userModel.php");
require_once("app/model/loginModel.php");
require_once("app/model/perfilModel.php");


class UsuariosController
{

  protected $instmodeluser;
  protected $instmodellogin;
  protected $instmodelperfiles;
  protected $permisos;

  function __construct()
  {
   
    $this->instmodeluser = new UserModel();
    $this->instmodellogin = new LoginModel();
    $this->instmodelperfiles = new PerfilModel();
    if (isset($_SESSION['user'])) {
      $this->permisos = calcularpermisos(2, $_SESSION['user']['MatrizPermisos']);
    }
  }

  function index()
  {

    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }

		$tecnico=(isset($_GET['tecnico']))? $_GET['tecnico']:null;
		$D10S = $_SESSION['user']["D10S"];
		$estado_user = isset($_SESSION['user']["D10S"]) ? null : 1;
		$id_user = isset($_POST["id_user"]) ? openssl_decrypt($_POST["id_user"], METHODENCRIPT, KEY) : null;
		$list_user = $this->list_user($id_user, $estado_user, null, $D10S, $tecnico);

    $method = get_class($this);
    $name_method = explode("Controller", $method);
    $use_method = (isset($name_method[0]) ? $name_method[0] : null);
    //$carga_function = "function_user.js";
    $content_view = "user/index.php";
    require_once("app/view/template/template.php");
  }

  function list_user($id_user, $estado_user, $TokenUser, $D10S, $tecnico)
  {

    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      exit();
    }

    $maestro_lista_usuarios = array();
    $list_User =  $this->instmodeluser->list_user($id_user, $estado_user, $TokenUser, $D10S, $tecnico);

    if (($list_User)) {

      foreach ($list_User as $key => $value) {
        $array_xuser = array();
        $badge_perfiles = "";

        $nameUser="\"".($value->NombreCompletoUsuario)."\"";
        $idUser_encrypt=urlencode(openssl_encrypt($value->IDUser, METHODENCRIPT, KEY));

          if ($value->CantPerfiles > 0) {
            $buscar_perfiles_asignadosxusuario = $this->instmodelperfiles->buscar_perfiles_asignadosxusuario($value->IDUser, $D10S);

            foreach ($buscar_perfiles_asignadosxusuario as $key2 => $value2) {
              $style_color = ($value2->ColorPerfil === null) ? " " : " style='background-color:" . $value2->ColorPerfil . "'";
              $badge_perfiles .= "<span class='badge text-bg-primary me-3 py-1'><b>" . $value2->NombrePerfil . "</b></span>";
            }

          } else {
            $badge_perfiles = "<span class='text-muted fst-italic' style='font-size:smaller'>- Sin Perfil -</span>";

          }
				if ($value->IDUser == openssl_decrypt($_SESSION["user"]["IDUser"], METHODENCRIPT, KEY)) {
					$boton_editar = '<i class="bi bi-hand-index-fill"></i> (Yo)';
				}else{
						$boton_editar = "<div class='d-grid gap-2 d-md-block btn-group'>
                  <button type='button' class='btn btn-warning btn-sm me-2 btn_change_pass' id='changepassuser' name='changepassuser'  data-bs-toggle='modal' data-bs-target='#modal_changepassuser' onclick='prepare_changepassuser(" . $nameUser . "," . $idUser_encrypt . ")'><i class='bi bi-key'></i></button>
                  <a class='btn btn-outline-dark btn-sm' href='".URL_PATH. "usuarios/nuevousuario/?TKU=". $idUser_encrypt."'> <i class='bi bi-pencil'></i> Editar</a>
              </div>";
				}

          $array_xuser = array(
            "IDUser" => openssl_encrypt($value->IDUser,METHODENCRIPT, KEY),
            "TokenUser"=>$value->TokenUser,
            "NombreCompletoUsuario" =>$value->NombreCompletoUsuario,
            "NombreUsuario" =>$value->NombreUsuario,
            "ApellidosUsuario" =>$value->ApellidosUsuario,
            "EmailUsuario" =>$value->EmailUsuario,
            "EstadoUsuario" =>$value->EstadoUsuario,
            "Perfiles" =>$badge_perfiles,
            "boton_editar" =>$boton_editar,
						"UsuarioTecnico"=>(isset($value->UsuarioTecnico)?$value->UsuarioTecnico:null),
						"DisponibilidadTecnica"=>(isset($value->DisponibilidadTecnica)?$value->DisponibilidadTecnica:null),
						"ColorTecnico"=>(isset($value->ColorTecnico)?$value->ColorTecnico:null),
						"NombreCortoTecnico"=>(isset($value->NombreCortoTecnico)?$value->NombreCortoTecnico:null),
						"CalificacionTecnica"=>(isset($value->CalificacionTecnica)?$value->CalificacionTecnica:null)
          );

          array_push($maestro_lista_usuarios, $array_xuser);
        
      }

      $array_response = array("status" => true, "type" => "success", "title" => "Exito", "data" => $maestro_lista_usuarios);
    } else {
      $array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Hubo un error, por favor comuniquese con soporte", "data" => $list_User);
    }

    return $array_response;

  }

  function add_newuser()
  {
		if($_POST){

			$D10S = $_SESSION['user']['D10S'];

			$array_response = array();
			$newuser_nombre = isset($_POST["newuser_nombre"]) ? strip_tags(trim($_POST["newuser_nombre"])) : null;
			$newuser_apellido = isset($_POST["newuser_apellido"]) ? strip_tags(trim($_POST["newuser_apellido"])) : null;
			$newuser_email = isset($_POST["newuser_email"]) ? strip_tags(trim($_POST["newuser_email"])) : null;
			$newuser_pass = isset($_POST["newuser_pass"]) ? strip_tags(trim($_POST["newuser_pass"])) : null;
			
			$newuser_status = isset($_POST["newuser_status"]) ? 1 : 0;
			$newuser_profile = isset($_POST["newuser_profile"]) ? (($_POST["newuser_profile"])) : null;
			$newuser_token = isset($_POST["newuser_token"]) ? (strip_tags(trim($_POST["newuser_token"]))) : null;
			$input_tecnico = isset($_POST["input_tecnico"]) ? (strip_tags(trim($_POST["input_tecnico"]))) : null;
			$newuser_color = isset($_POST["newuser_color"]) ? (strip_tags(trim($_POST["newuser_color"]))) : null;
			$newuser_nombrecorto = isset($_POST["newuser_nombrecorto"]) ? (strip_tags(trim($_POST["newuser_nombrecorto"]))) : null;

			$validacion_newuser = isset($_POST["validacion_newuser"]) ? (strip_tags(trim($_POST["validacion_newuser"]))) : null;
			$campos_llenos = false;

			if (!$newuser_token) {
				$campos_llenos = ($newuser_nombre == null || $newuser_apellido == null || $newuser_email == null || $newuser_pass == null) ? false : true;
			} elseif ($newuser_token) {
				$campos_llenos = ($newuser_nombre == null || $newuser_apellido == null || $newuser_email == null) ? false : true;
			}

			if (!$campos_llenos) {
				$array_response = array("status" => false, "type" => "warning", "title" => "Error", "msg" => 'Se debe llenar toda la informacion solicitada en el formulario.  <p>Por favor intentelo de nuevo!</p>');
			} else {
				$search_token_user = $this->instmodeluser->findemailuser($newuser_email);
				if ($search_token_user->findemailuser && !$newuser_token) { // Si existe el correo, pero no trae el flag de edicion
					$array_response = array("status" => false, "type" => "warning", "title" => "Error!", "msg" => "Ya se encuentra registrado un usuario con ese correo electrónico. <br> Intente de nuevo por favor");
				} elseif (!$search_token_user->findemailuser && !$newuser_token) { // No existe el correo enviado y el flag de edicion tampoco lo trae - Usuario nuevo.

					$pass_encrypt = password_hash($newuser_pass, PASSWORD_DEFAULT);
					$IDUsuarioCreacion = openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY);

					$Insert_newuser = $this->instmodeluser->addUser(
						setToken($newuser_email),
						$pass_encrypt,
						$IDUsuarioCreacion,
						$newuser_nombre,
						$newuser_apellido,
						$newuser_email,
						$newuser_status,
						$newuser_profile,
						$newuser_nombrecorto,
						$newuser_color,
						$input_tecnico,
						1
					);

					if ($Insert_newuser) {
						$array_response = array("status" => true, "type" => "success", "title" => "Exito!", "msg" => "Usuario creado correctamente.");
					} else {
						$array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Hubo un error, no fue posible agregar el usuario nuevo.<br> Comuniquese con soporte.");
					}
				} elseif ($search_token_user->findemailuser && $newuser_token) { //Existe el correo enviado y trae el flag de edicion - Edicion de usuario
					$edit_usuario = $this->instmodeluser->edit_user($newuser_token, $newuser_nombre, $newuser_apellido, $newuser_status, $newuser_email);
					if ($edit_usuario) {
						$buscar_perfiles_db = $this->instmodelperfiles->buscar_perfiles_asignadosxusuario($search_token_user[0]->IDUser);

						$IDtenantActual = ($search_token_user[0]->IDTenant) ? $search_token_user[0]->IDTenant : 0;
						$buscar_perfiles_db_IDPerfil = array_column($buscar_perfiles_db, "IDPerfil");

						$aAgregar = ($newuser_profile) ? array_diff($newuser_profile, $buscar_perfiles_db_IDPerfil) : false;
						$aEliminar = ($newuser_profile) ? array_diff($buscar_perfiles_db_IDPerfil, $newuser_profile) : $buscar_perfiles_db_IDPerfil;
						//Agrega los nuevos perfiles asignados al usuario
						if ($aAgregar) {
							foreach ($aAgregar as $key => $value) {
								$insertar_perfil = $this->instmodelperfiles->asignar_profile_user($search_token_user[0]->IDUser, $value);
							}
						}
						//Retira los perfiles que se le quitaron al usuario
						if ($aEliminar) {
							foreach ($aEliminar as $key2 => $value2) {
								$retirar_perfil = $this->instmodelperfiles->retirar_perfiles_ausuario($search_token_user[0]->IDUser, $value2);
							}
						}
						$array_response = array("status" => true, "type" => "success", "title" => "Correcto!", "msg" => "El usuario fue editado correctamente.");
					} else {
						$array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Hubo un error, no fue posible editar el usuario.<br> Comuniquese con soporte.");
					}
				} else {
					$array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "No es posible editar el usuario.<br> Comuniquese con soporte.");
				}
			}

		}else{
			$array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "No es posible ingresar en esta sección.<br> Comuniquese con soporte.");
		}
		$_SESSION['msg']=$array_response;
		header("Location:".URL_PATH. "usuarios".(($input_tecnico)? "\/?tecnico=true":""),true,301);
  }

  function asignarusuarioaperfil($IDUsuario, $IDPerfil)
  {
  }

  function changepass_user()
  {
    $newpass = $_POST["newpass"];
    $IDUser = $_POST["IDUser"];

    if ($newpass == "" || $IDUser == "") {
      $array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Los datos no pueden estar vacios.  Por favor validar.<br> Comuniquese con soporte.");
    } else {
      $pass_encrypt = password_hash($newpass, PASSWORD_DEFAULT);
      $change_passuser = $this->instmodeluser->change_passuser($pass_encrypt, openssl_decrypt($IDUser, METHODENCRIPT, KEY));
      if ($change_passuser) {
        $array_response = array("status" => true, "type" => "success", "title" => "Correcto!", "msg" => "Se realizo cambio de contraseña del usuario.");
      } else {
        $array_response = array("status" => false, "type" => "danger", "title" => "Error!", "msg" => "Hubo un error, no fue posible cambiar la contraseña del usuario.<br> Comuniquese con soporte.");
      }
    }
    echo json_encode($array_response);
  }

  function findemail()
  {
    $email_user = $_POST["email"];
    $list_email_User = $this->instmodeluser->findemailuser($email_user);
    echo ($list_email_User->findemailuser);
  }

  /*public function verperfil()
  {
    if (!isset($_SESSION['session_id'])) {
      header("Location:" . URL_PATH, true, 301);
      die();
    } else {

      $tokenuser = $_GET["TKU"];
      $D10S = $_SESSION['user']['D10S'];
      $data_user = $this->instmodeluser->list_user(openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY), null, null, $tokenuser, $D10S);
			$lista_perfiles_disponibles = $this->instmodelperfiles->listar_perfiles_permitidos($D10S,(($_SESSION['user']['IDTenant'])? openssl_decrypt($_SESSION['user']['IDTenant'], METHODENCRIPT, KEY):null) , openssl_decrypt($_SESSION['user']['MaxJerarquia'], METHODENCRIPT, KEY));
			$perfilesxusuario = $this->instmodelperfiles->buscar_perfiles_asignadosxusuario(openssl_decrypt($_SESSION['user']['IDUser'], METHODENCRIPT, KEY));
			$data_usuario = array();
			$IDperfilxuser_arreglo = array_column($perfilesxusuario, "IDPerfil");
			$data_perfiles_disponibles = array();

			if($lista_perfiles_disponibles){
				foreach ($lista_perfiles_disponibles as $key => $value) {
					$lista_perfiles_disponibles_row = array(
						"IDPerfil" => openssl_encrypt($value->IDPerfil, METHODENCRIPT, KEY),
						"NombrePerfil" => $value->NombrePerfil,
						"selected" => (in_array($value->IDPerfil, $IDperfilxuser_arreglo)) ? true : false,
					);
					array_push($data_perfiles_disponibles, $lista_perfiles_disponibles_row);
				}
			}

			$carga_function = "functions_profileuser.js";
			$content_view = "user/userprofile.php";
			require_once("app/view/template/template.php");

    }
  }*/

  public function edit_profile_user()
  {
    $array_response = array();
    $nombre_edit_user = isset($_POST["firstName"]) ? strip_tags(trim($_POST["firstName"])) : null;
    $apellido_edit_user = isset($_POST["lastName"]) ? strip_tags(trim($_POST["lastName"])) : null;
    $token_edit_user = isset($_POST["newuser_token"]) ? $_POST["newuser_token"] : null;

    if (strlen($nombre_edit_user) > 0 || strlen($apellido_edit_user) > 0) {
      $editar_perfil_usuario = $this->instmodeluser->edit_user($token_edit_user, $nombre_edit_user, $apellido_edit_user, 0, 0, 1);

      if ($editar_perfil_usuario) {
        $array_response = array("status" => true, "type" => "success", "title" => "Correcto.", "msg" => "Perfil editado correctamente");
      } else {
        $array_response = array("status" => false, "type" => "danger", "title" => "Error", "msg" => "No fue posible editar el perfil.  Por favor comuniquese con el administrador.");
      }
    } else {
      $array_response = array("status" => false, "type" => "danger", "title" => "Error.", "msg" => "Los campos no pueden estar vacios.");
    }

    echo json_encode($array_response);
  }

	public function nuevousuario(){
		if (!isset($_SESSION['session_id'])) {
			header("Location:" . URL_PATH, true, 301);
			exit();
		}
	
		$tecnico = (isset($_GET["tecnico"])) ? (($_GET["tecnico"]==true)?1:0) : 0;
		$newuser_token= isset($_GET['TKU']) ? openssl_decrypt(($_GET['TKU']), METHODENCRIPT, KEY):0;
		$lista_perfiles_disponibles = $this->instmodelperfiles->listar_perfiles_permitidos($_SESSION['user']['D10S'],0);
		$D10S=($_SESSION['user']['D10S']) ? openssl_decrypt($_SESSION['user']['D10S'], METHODENCRIPT, KEY) : 0;

		if($newuser_token){
			$result_user=$this->instmodeluser->list_user($newuser_token, null, null, $D10S, $tecnico);
			$array_perfiles= ($result_user[0]->perfiles_asignados)?explode(",",$result_user[0]->perfiles_asignados):null;
				$data_user=array(
					"IDUser"=>openssl_encrypt($result_user[0]->IDUser, METHODENCRIPT, KEY),
					"TokenUser"=>$result_user[0]->TokenUser,
					"NombreUsuario"=>$result_user[0]->NombreUsuario,
					"ApellidosUsuario"=>$result_user[0]->ApellidosUsuario,
					"FechaCreacion"=>$result_user[0]->FechaCreacion,
					"EmailUsuario"=>$result_user[0]->EmailUsuario,
					"EstadoUsuario"=>$result_user[0]->EstadoUsuario,
					"perfiles_asignados"=> $array_perfiles
				);
		}

		$method = get_class($this);
		$name_method = explode("Controller", $method);
		$use_method = (isset($name_method[0]) ? $name_method[0] : null);
		$carga_function = "function_new_user.js";
		$content_view = "user/nuevousuario.php";
		require_once("app/view/template/template.php");

	}
}

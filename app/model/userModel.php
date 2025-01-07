<?php


class UserModel
{

	private $pdo;

	function __construct()
	{
		try {
			$this->pdo = Database::Conectar();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	public function addUser($TokenUser, $PassUser, $IDUsuarioCreacion, $NombreUsuario, $ApellidoUsuario, $EmailUsuario, $EstadoUsuario, $JSON_PERFILES, $NombreCortoTecnico, $ColorTecnico, $UsuarioTecnico, $DisponibilidadTecnica)
	{
		try {
			$json_parametro = json_encode($JSON_PERFILES);
			$json_parametro_correcto = (str_replace('"', '', $json_parametro));
			//Procedimiento almacenado donde guarda el usuario y
			//ese nuevo usuario lo asigna al Tenant (si lo hay) y lo asigna a los perfiles seleccionados (si los hay)
			$sql = "CALL crearUsuario(?,?,?,?,?,?,?,?,?,?,?,?)";
			$stm = $this->pdo->prepare($sql);
			$result = $stm->execute(array($TokenUser, $PassUser, $IDUsuarioCreacion, $NombreUsuario, $ApellidoUsuario, $EmailUsuario, $EstadoUsuario, $json_parametro_correcto, $NombreCortoTecnico, $ColorTecnico, $UsuarioTecnico, $DisponibilidadTecnica));
			$stm = null;
			return $result;
		} catch (\Throwable $th) {
			die("addUser" . $th->getMessage());
		}
	}

	public function list_user($id_user = null, $estado_user = null, $TokenUser = null, $D10S = null, $tecnico = null)
	{

		try {

			$arreglo_variables = array();

			$sql = "SELECT
            tu.IDUser,
            tu.TokenUser,
            tu.NombreUsuario,
            tu.ApellidosUsuario,
            tu.FechaCreacion,
            CONCAT(tu.NombreUsuario, ' ', tu.ApellidosUsuario) as NombreCompletoUsuario,
            tu.EmailUsuario,
            tu.EstadoUsuario,
						tu.UsuarioTecnico,
						tu.DisponibilidadTecnica,
						tu.ColorTecnico,
						tu.NombreCortoTecnico,
						tu.CalificacionTecnica,
						(select count(*) from tbl_UsuariosPerfiles tup where tup.IDUser=tu.IDUser) as CantPerfiles" .
				(($id_user != null) ? ",GROUP_CONCAT(DISTINCT tup.IDPerfil) AS perfiles_asignados" : ",(select GROUP_CONCAT(DISTINCT tup.IDPerfil) from tbl_UsuariosPerfiles tup where tup.IDUser=tu.IDUser) AS perfiles_asignados") . "
          FROM tbl_User tu
          LEFT JOIN tbl_UsuariosPerfiles tup ON tup.IDUser=tu.IDUser
          LEFT JOIN tbl_Perfiles tp ON tp.IDPerfil=tup.IDPerfil
				";
			if (!$D10S) {
				$sql .= "WHERE tu.IDUser NOT IN (1)";
			} else {
				$sql .= "WHERE tu.IDUser IN (select IDUser FROM tbl_User tu)";
			}

			if ($id_user > 0 && $id_user != null) {
				$sql .= " AND tu.IDUser=?";
				array_push($arreglo_variables, $id_user);
			}

			if ($estado_user != null) { // En un estado especifico
				$sql .= " AND tu.EstadoUsuario=?";
				array_push($arreglo_variables, $estado_user);
			}

			if ($TokenUser != null) {
				$sql .= " AND tu.TokenUser=?";
				array_push($arreglo_variables, $TokenUser);
			}

			if ($tecnico) {
				$sql .= " AND tu.UsuarioTecnico=?";
				array_push($arreglo_variables, 1);
			} else {
				$sql .= " AND tu.UsuarioTecnico NOT IN (1)";
			}

			$sql .= "
            GROUP BY tu.IDUser
            ORDER BY tu.IDUser;";

			$stm = $this->pdo->prepare($sql);
			$stm->execute(isset($arreglo_variables) ? $arreglo_variables : null);

			return ($stm->fetchAll(PDO::FETCH_OBJ));
		} catch (\Throwable $th) {
			return $th->getMessage();
		}
	}

	public function edit_user($IDUser, $NombreUsuario, $ApellidoUsuario, $EstadoUsuario, $newuser_email, $edit_profile = 0)
	{

		try {
			if ($edit_profile == 1) { // Esta editando usuario desde el perfil del mismo usuario
				$sql = "UPDATE tbl_User 
                SET 
                  NombreUsuario = ?,
                  ApellidosUsuario =?
                WHERE
                  IDUser=?";
				$param = array($NombreUsuario, $ApellidoUsuario, $IDUser);
			} else {
				$sql = "UPDATE tbl_User 
                SET 
                  NombreUsuario = ?,
                  ApellidosUsuario =?,
                  EstadoUsuario=$EstadoUsuario,
                  EmailUsuario=?
                WHERE
                  IDUser=?";
				$param = array($NombreUsuario, $ApellidoUsuario, $newuser_email, $IDUser);
			}

			$stm = $this->pdo->prepare($sql);
			return $stm->execute($param);
		} catch (\Throwable $th) {
			die("Edit User" . $th->getMessage());
		}
	}

	public function finduserxID($IDUser)
	{
		$sql = "SELECT IDUser FROM tbl_User WHERE IDUser=?";
		$stm = $this->pdo->prepare($sql);
		$stm->execute(array($IDUser));

		return $stm->fetch(PDO::FETCH_OBJ);
	}

	public function change_passuser($NewPass, $IDUser)
	{
		try {
			$sql = "UPDATE tbl_User 
              SET 
                PassUser = ?,
                TokenRecoveryPass=null,
                FechaVencimientoRecovery=null
              WHERE IDUser=?";
			$smt = $this->pdo->prepare($sql);
			return $smt->execute(array($NewPass, $IDUser));

			// ob_start();
			// $smt->debugDumpParams();
			// $output = ob_get_contents();
			// ob_end_clean();
			// echo $output."<br>";
			// echo $NewPass."<br>";
			// echo $TokeUser."<br>";

		} catch (\Throwable $th) {
			die("Change Pass user profile" . $th->getMessage());
		}
	}

	public function findemailuser($emailuser)
	{
		$sql = "SELECT
            COUNT(*) as findemailuser
          FROM tbl_User tu
          WHERE tu.EmailUsuario=?";
		$smt = $this->pdo->prepare($sql);
		$smt->execute(array($emailuser));
		return $smt->fetch(PDO::FETCH_OBJ);
	}
}

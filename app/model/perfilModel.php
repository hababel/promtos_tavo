<?php

class PerfilModel
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

	function listar_perfiles_permitidos($D1OS = 0, $IDPerfil = 0)
	{

		try {
			$sql =
				"SELECT
            tp.IDPerfil,
            tp.NombrePerfil,
            tp.DescripcionPerfil,
						tp.PerfilGenerico,
            tp.Estado,
            tp.TokenPerfil,
						(SELECT GROUP_CONCAT(DISTINCT uss.IDUser ORDER BY uss.IDUser ASC SEPARATOR ', ')
								FROM tbl_User uss
								JOIN tbl_UsuariosPerfiles upss ON uss.IDUser = upss.IDUser
								AND upss.IDPerfil = tp.IDPerfil) AS 	usuarios_asignados
						FROM tbl_Perfiles tp
							LEFT JOIN tbl_UsuariosPerfiles pu  ON tp.IDPerfil = pu.IDPerfil
							LEFT JOIN tbl_User u ON pu.IDUser = u.IDUser
						WHERE " . (($D1OS === 1) ? " tp.Estado in (0,1)" : " tp.PerfilGenerico=1 AND tp.Estado=1") .
						(($IDPerfil > 0) ? " AND tp.IDPerfil=" . $IDPerfil . "\n" : "") . "
							\nGROUP BY
									tp.IDPerfil,
									tp.NombrePerfil
							ORDER BY tp.IDPerfil;";
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function asignar_profile_user($IDUser, $IDPerfil)
	{
		try {
			$sql = "INSERT INTO tbl_UsuariosPerfiles (
                 IDUser,
                 IDPerfil )
          VALUES (?,?)";
			$stm = $this->pdo->prepare($sql);
			return $stm->execute(array($IDUser, $IDPerfil));
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function retirar_perfiles_ausuario($IDUser, $IDPerfil)
	{
		try {
			$sql = "DELETE FROM tbl_UsuariosPerfiles  where IDUser=? AND IDPerfil=?";
			$stm = $this->pdo->prepare($sql);
			return $stm->execute(array($IDUser, $IDPerfil));
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function buscar_perfiles_asignadosxusuario($IDUser, $D10S = 0)
	{

		try {
			$sql = "SELECT
                  tup.IDUsuarioPerfil,
                  tup.IDUser,
                  tup.IDPerfil,
                  tp.NombrePerfil,
                  tp.ColorPerfil
                FROM tbl_UsuariosPerfiles tup 
                LEFT JOIN tbl_Perfiles tp ON tp.IDPerfil=tup.IDPerfil WHERE IDUser=? " .
							(($D10S) ? "" : " AND tup.IDPerfil NOT IN (1,2)") . ";";

			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDUser));
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}


	function buscar_usuariosxperfil($IDPerfil)
	{
		try {
			$sql = "SELECT 
								tup.IDUser,
								tup.IDPerfil,
								tu.NombreUsuario
							FROM tbl_UsuariosPerfiles tup 
							INNER JOIN tbl_Perfiles tp ON tp.IDPerfil=tup.IDPerfil
							INNER JOIN tbl_User tu ON tu.IDUser=tup.IDUser
							WHERE tp.IDPerfil=? ";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDPerfil));

			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function addperfil_new($JerarquiaPerfil, $PerfilGenerico, $FechaCreacion, $IDUsuarioCreacion, $NombrePerfil, $Estado, $DescripcionPerfil, $TokenPerfil, $recursosperfiles, $IDTenant, $arreglo_asignarusuarios)
	{

		$recursosperfiles_json = json_encode($recursosperfiles);
		$arreglo_asignarusuarios_json = json_encode($arreglo_asignarusuarios);

		try {
			$sql = "CALL crearPerfil(?,?,?,?,?,?,?,?,?,?,?)";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDUsuarioCreacion, $NombrePerfil, $Estado, $DescripcionPerfil, $TokenPerfil, $IDTenant, $arreglo_asignarusuarios_json, $JerarquiaPerfil, $PerfilGenerico, $FechaCreacion, $recursosperfiles_json));
			$result = $stm->fetch(PDO::FETCH_OBJ);
			$stm->closeCursor();
			return $result->NuevoPerfil;
		} catch (\Throwable $th) {
			die("addperfil_new " . $th->getMessage());
		}
	}

	function editar_perfil($JerarquiaPerfil, $PerfilGenerico, $NombrePerfil, $DescripcionPerfil, $EstadoPerfil, $recursosperfiles, $idperfil_edit_decrypt)
	{

		try {
			$sql = "UPDATE tbl_perfiles
							SET
								JerarquiaPerfil=?,
								PerfilGenerico=?,
								NombrePerfil=?,
								Estado=?,
								DescripcionPerfil=?
							WHERE IDPerfil=?;	";
			$stm = $this->pdo->prepare($sql);
			$editar_perfil = $stm->execute(array($JerarquiaPerfil, $PerfilGenerico, $NombrePerfil, $EstadoPerfil, $DescripcionPerfil, $idperfil_edit_decrypt));
			if ($editar_perfil && $PerfilGenerico == 0) {
				$this->addrecursos_perfiles($idperfil_edit_decrypt, $recursosperfiles);
			} else {
				return 0;
			}
		} catch (\Throwable $th) {
			die("add_perfiles" . $idperfil_edit_decrypt . "<br>" . $th->getMessage());
		}
	}

	function addrecursos_perfiles($idperfil_edit_decrypt, $recursosperfiles)
	{
		try {
			if ($idperfil_edit_decrypt == 0) {
				$sql = "INSERT INTO tbl_RecursosPerfiles (
                  IDPerfil,
                  IDRecurso,
                  c,
                  r,
                  u,
                  d) 
                  VALUES  ";

				foreach ($recursosperfiles as $key => $value) {

					$sql .= "
            (" . $idperfil_edit_decrypt . ",
            " . $key . ",
            " . (($value["C"]) ? "1" : "0") . ",
            " . (($value["R"]) ? "1" : "0") . ",
            " . (($value["U"]) ? "1" : "0") . ",
            " . (($value["D"]) ? "1" : "0") . "
            )";
					$sql .= ($key != "R" . count($recursosperfiles)) ? "," : "";
				}

				$stm = $this->pdo->prepare($sql);
				return $stm->execute();
			} elseif ($idperfil_edit_decrypt != 0) {

				$sql_select = "SELECT COUNT(IDPerfil) AS cant_filas FROM tbl_recursosperfiles WHERE IDPerfil=?";
				$stm_select = $this->pdo->prepare($sql_select);
				$stm_select->execute(array($idperfil_edit_decrypt));
				$permisosexistentes_perfil = $stm_select->fetch(PDO::FETCH_OBJ);

				if ($permisosexistentes_perfil->cant_filas > 0) {
					$sql = "UPDATE tbl_recursosperfiles SET 
								c=?,
								r=?,
								u=?,
								d=?  WHERE IDRecurso=? AND IDPerfil =?;";
					$stm = $this->pdo->prepare($sql);
					foreach ($recursosperfiles as $key => $value) {
						$editar_perfil = $stm->execute(array($value->C, $value->R, $value->U, $value->D, $value->id_recurso, $idperfil_edit_decrypt));
					}
					return $editar_perfil;
				} else {
					$arrayobj = new ArrayObject($recursosperfiles);
					$sql = "INSERT INTO tbl_RecursosPerfiles (
										IDPerfil,
										IDRecurso,
										c,
										r,
										u,
										d) 
										VALUES  ";

					foreach ($recursosperfiles as $key => $value) {
						echo $key;
						$sql .= "
							(" . $idperfil_edit_decrypt . ",
							" . $value->id_recurso . ",
							" . (($value->C) ? "1" : "0") . ",
							" . (($value->R) ? "1" : "0") . ",
							" . (($value->U) ? "1" : "0") . ",
							" . (($value->D) ? "1" : "0") . "
							)";
						$sql .= ($key <  $arrayobj->count() - 1) ? "," : "";
					}

					$stm = $this->pdo->prepare($sql);
					return $stm->execute();
				}
			}
		} catch (\Throwable $th) {
			die("addrecursos_perfiles" . $th->getMessage());
		}
	}

	function del_all_userperfil($idPerfil, $TokenPerfil)
	{
		$sql = "DELETE tup.* 
          FROM tbl_UsuariosPerfiles tup 
          INNER JOIN tbl_Perfiles tp ON tp.IDPerfil=tup.IDPerfil
          WHERE tp.TokenPerfil= ? AND tup.IDPerfil=?";
		$smt = $this->pdo->prepare($sql);
		return $smt->execute(array($TokenPerfil, $idPerfil));
	}

	function getpermisosxperfil($IDPerfil)
	{

		try {
			$sql = "SELECT 
              tp.IDPerfil,
              trp.IDRecurso,
              trp.c,
              trp.r,
              trp.u,
              trp.d
            FROM tbl_Perfiles tp
            INNER JOIN tbl_RecursosPerfiles trp ON trp.IDPerfil=tp.IDPerfil
            INNER JOIN tbl_Recursos tr ON tr.IDRecurso=trp.IDRecurso
            WHERE tp.IDPerfil=?;";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDPerfil));
			return ($stm->fetchAll(PDO::FETCH_OBJ));
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function get_permisosxusuario($tokenUser)
	{
		echo $tokenUser;
		try {
			$sql = "SELECT 
                tp.IDPerfil,
                trp.IDRecurso,
                trp.c,trp.r,trp.u,trp.d
              FROM tbl_RecursosPerfiles trp
              JOIN tbl_Recursos tr ON tr.IDRecurso=trp.IDRecurso
              JOIN tbl_Perfiles tp ON tp.IDPerfil=trp.IDPerfil
              JOIN tbl_UsuariosPerfiles tup ON tup.IDPerfil=tp.IDPerfil
              JOIN tbl_User tu ON tu.IDUser=tup.IDUser
              WHERE tu.TokenUser=?;";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($tokenUser));
			return $stm->fetchAll(PDO::FETCH_OBJ);
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

	function eliminar_perfil($IDPerfil_aeliminar, $IDPerfil_reasignacion)
	{
		try {
			$sql = "CALL eliminarPerfil(?,?)";
			$stm = $this->pdo->prepare($sql);
			return $stm->execute(array($IDPerfil_aeliminar, $IDPerfil_reasignacion));
		} catch (\Throwable $th) {
			die($th->getMessage());
		}
	}

}

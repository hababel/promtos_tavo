<?php


class LoginModel
{

	protected $email_login;
	private $pdo;

	function __construct()
	{
		try {
			$this->pdo = Database::Conectar();
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}

	function get_auth($email_login)
	{
		$sql = "SELECT
              tu.IDUser,
              tu.TokenUser,
              tu.PassUser,
              tu.NombreUsuario,
              tu.ApellidosUsuario,
              tu.FechaCreacion,
              CONCAT(tu.NombreUsuario,' ',tu.ApellidosUsuario) AS NameUser,
              tu.ImagenUsuario,
              tu.EmailUsuario,
              tu.EstadoUsuario,
              (SELECT GROUP_CONCAT(tp.IDPerfil SEPARATOR ',')  FROM tbl_UsuariosPerfiles tp WHERE tp.IDUser=tu.IDUser) AS perfiles_asignados
            FROM tbl_User tu 
            WHERE tu.EmailUsuario=?;";
		$result = $this->pdo->prepare($sql);
		$result->execute(array($email_login));
		$data = $result->fetch(PDO::FETCH_OBJ);
		return $data;
	}

	public function validatelogin($emailuser_input)
	{
		$sql = "SELECT
                tu.IDUser,
                tu.TokenUser,
                tu.EmailUsuario,
                CONCAT(tu.NombreUsuario,' ',tu.`ApellidosUsuario`) AS NameUser,
                tu.EstadoUsuario,
              FROM tbl_User tu 
              WHERE tu.EmailUsuario=?;";
		$stm = $this->pdo->prepare($sql);
		$stm->execute(array($emailuser_input));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	function resetpass($newpass, $token)
	{
		try {

			$sql = "UPDATE tbl_User
          SET PassUser=?,
              TokenRecoveryPass=null,
              FechaVencimientoRecovery=null
          WHERE TokenRecoveryPass=?";
			$stm = $this->pdo->prepare($sql);
			return $stm->execute(array($newpass, $token));
		} catch (\PDOException $e) {
			echo $e->getMessage() . '<br>';
		}
	}

	function validatetoken($token)
	{
		$sql = "SELECT
            IDUser,
            EmailUsuario,
            TokenUser,
            FechaVencimientoRecovery
          FROM tbl_User
          where TokenRecoveryPass=?";
		$stm = $this->pdo->prepare($sql);
		$stm->execute(array($token));
		return $stm->fetch(PDO::FETCH_OBJ);
	}

	function updatetoken($tokenrecovery, $TokenUser, $fecha_vencimiento)
	{
		$sql = "UPDATE tbl_User 
            SET
                TokenRecoveryPass=?,
                FechaVencimientoRecovery=?
            WHERE TokenUser=?";
		$stm = $this->pdo->prepare($sql);
		return $stm->execute(array($tokenrecovery, $fecha_vencimiento, $TokenUser,));
	}

	function permission_profile_user_resource($TokenUser)
	{
		$sql = "SELECT 
                tu.IDUser,
                tup.IDPerfil,
                tr.IDRecurso,
                trp.c as 'create',
                trp.r as 'read',
                trp.u as 'update',
                trp.d as 'delete'
            FROM tbl_User tu
            inner join tbl_UsuariosPerfiles tup on tup.IDUser=tu.IDUser
            inner join tbl_Perfiles tp on tp.IDPerfil=tup.IDPerfil
            inner join tbl_RecursosPerfiles trp on trp.IDPerfil=tp.IDPerfil
            inner join tbl_Recursos tr on tr.IDRecurso=trp.IDRecurso
            where tu.TokenUser=?";
		$stm = $this->pdo->prepare($sql);
		$stm->execute(array($TokenUser));
		return $stm->fetchAll(PDO::FETCH_OBJ);
	}
}

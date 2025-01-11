<?php

class ClientesModel
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

  function findemailcliente($email_cliente)
  {
    try {
      $sql = "SELECT COUNT(*) as findemailcliente FROM tbl_Cliente WHERE CorreoCliente=?";
      $stm = $this->pdo->prepare($sql);
      $stm->execute(array($email_cliente));
      return $stm->fetch(PDO::FETCH_OBJ);

      // ob_start();
      // $stm->debugDumpParams();
      // $output = ob_get_contents();
      // ob_end_clean();
      // echo $output;
      // var_dump($result);


    } catch (\Throwable $th) {
      die("FindEmailCustomer" . $th->getMessage());
    }
  }

  function find_documento_cliente($documento_cliente)
  {
    try {
      $sql = "SELECT COUNT(*) as find_documento_cliente FROM tbl_Cliente WHERE DocCliente=?";
      $stm = $this->pdo->prepare($sql);
      $stm->execute(array($documento_cliente));
      return $stm->fetch(PDO::FETCH_OBJ);

      // ob_start();
      // $stm->debugDumpParams();
      // $output = ob_get_contents();
      // ob_end_clean();
      // echo $output;
      // var_dump($result);


    } catch (\Throwable $th) {
      die("FindEmailCustomer" . $th->getMessage());
    }
  }

  function crear_cliente(
    $nombre_cliente,
    $apellidos_cliente,
    $email_cliente,
    $telefono1_cliente,
    $telefono2_cliente,
    $clasificacion,
    $notas_cliente,
    $estado_cliente,
    $token_cliente,
    $usuarioCreacion,
    $fechacreacion,
    $nombre_recomendado,
    $fuente,
    $direcciones,
    $documento_cliente
  ) {

    $arreglo_direccionescliente_json = ($direcciones)?(str_replace('"', '', $direcciones)):null;

    $sql = "Call crearCliente(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $smt = $this->pdo->prepare($sql);

    $smt->bindParam(1, $nombre_cliente, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 80);
    $smt->bindParam(2, $apellidos_cliente, PDO::PARAM_STR);
    $smt->bindParam(3, $email_cliente, PDO::PARAM_STR);
    $smt->bindParam(4, $telefono1_cliente, PDO::PARAM_STR);
    $smt->bindParam(5, $telefono2_cliente, PDO::PARAM_STR);
    $smt->bindParam(6, $clasificacion, PDO::PARAM_STR);
    $smt->bindParam(7, $notas_cliente, PDO::PARAM_STR);
    $smt->bindParam(8, $estado_cliente, PDO::PARAM_BOOL);
    $smt->bindParam(9, $token_cliente, PDO::PARAM_STR);
    $smt->bindParam(10, $usuarioCreacion, PDO::PARAM_INT);
    $smt->bindParam(11, $fechacreacion);
    $smt->bindParam(12, $nombre_recomendado, PDO::PARAM_STR);
    $smt->bindParam(13, $fuente, PDO::PARAM_STR);
    $smt->bindParam(14, $direcciones);
    $smt->bindParam(15, $documento_cliente, PDO::PARAM_STR);

    $smt->execute();
    return ($smt->fetch(PDO::FETCH_OBJ));
  }

  function listar_clientes($estado=null,$idcliente=null){
    $sql= "SELECT 
              tc.IDCliente
              ,tc.DocCliente
              ,tc.NombreCliente
              ,tc.ApellidoCliente
              ,CONCAT(tc.NombreCliente,' ',tc.ApellidoCliente) as NombreCompletoCliente
              ,tc.Telefono1Cliente
              ,tc.Telefono2Cliente
              ,tc.FuenteCreacion
              ,tc.NombreRecomendado
              ,tc.EstadoCliente
              ,tc.ClasificacionCliente
							,COUNT(ts.IDServicio) AS CantidadServiciosAbiertos
							,tc.FechaCreacionCliente
							,tc.LogEstados
            FROM tbl_Cliente tc
						LEFT JOIN tbl_serviciocab ts ON tc.IDCliente = ts.IDCliente
						".(($idcliente)?" WHERE tc.IDCliente=".$idcliente:NULL)."
						GROUP BY 
								tc.IDCliente,
								tc.DocCliente,
								tc.NombreCliente,
								tc.ApellidoCliente,
								tc.Telefono1Cliente,
								tc.Telefono2Cliente,
								tc.ClasificacionCliente,
								tc.NotasCliente,
								tc.FechaCreacionCliente,
								tc.LogEstados;";
    $stm = $this->pdo->prepare($sql);
    $stm->execute();
    return ($idcliente)?$stm->fetch(PDO::FETCH_OBJ):$stm->fetchAll(PDO::FETCH_OBJ);
  }

  function ficha_cliente($IDCliente){
    $resultadoFicheCliente=array();
    $sql = "CALL fichaCliente(?)";
    $stm = $this->pdo->prepare($sql);
    $stm->execute(array($IDCliente));
    // Datos principales del cliente
    $tablaDatosCliente = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();

    // Lista de presupuestos realizados al cliente
    $tablaPresupuestoCliente = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();

    // Lista de servicios es estado 4 - Solucionados/Cerrados
    $tablaServicioCABcerrados = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();

    // Lista de servicios es estado 0,1,2,3 - Abiertos o pendientes
    $tablaServicioCABAbiertos = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();

    //Lista de servicios en estado 5 Anulados
    $tablaServicioCABAnulados = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();
    
    //Lista de futuros servicios
    $tablaServiciosFuturos = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();

    //Lista de direcciones del cliente
    $tablaDireccionesCliente = $stm->fetchAll(PDO::FETCH_OBJ);
    $stm->nextRowset();
    
    //Lista de equipos asignados al cliente
    $tablaEquiposCliente = $stm->fetchAll(PDO::FETCH_OBJ);

    array_push(
      $resultadoFicheCliente,
        $tablaDatosCliente,
        $tablaPresupuestoCliente,
        $tablaServicioCABcerrados,
        $tablaServicioCABAbiertos,
        $tablaServicioCABAnulados,
        $tablaServiciosFuturos,
        $tablaDireccionesCliente,
        $tablaEquiposCliente);

        return  $resultadoFicheCliente;
    
  }

  function lista_direccionxcliente($IDCliente)
  {
    $sql = "SELECT * FROM tbl_clientedirecciones tcd
              WHERE tcd.IDCliente=?";
    $stm = $this->pdo->prepare($sql);
    $stm->execute(array($IDCliente));
    return $stm->fetchAll(PDO::FETCH_OBJ);
  }

	function updatecliente_estado($IDCliente,$nuevoestado=null,$logcambiosestado=null,$nuevaclasificacion=null,$logcambioclasificacion=null){
    $param=array();	
		
		$sql = "UPDATE tbl_Cliente SET ";

		if ($logcambiosestado != null) {
      $sql.="
					EstadoCliente=?,
					LogEstados=?";
			array_push($param, $nuevoestado, $logcambiosestado);
		}
		if($logcambioclasificacion != null){
		$sql.="
				,ClasificacionCliente=?
				LogClasificaciones=?";
			array_push($param,$nuevaclasificacion, $logcambioclasificacion);
		}		
		$sql.="
		WHERE IDCliente=?";
		array_push($param,$IDCliente);

 		$stm = $this->pdo->prepare($sql);
    return $stm->execute($param);

	}
}

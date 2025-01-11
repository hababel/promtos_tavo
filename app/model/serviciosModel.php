<?php

class serviciosModel {

  private $pdo;
  function __construct()
  {
    try {
      $this->pdo = Database::Conectar();
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
  
  function lista_servicios($estado_servicios=[0,1,2,3], $estado_clientes=1,$IDCliente=null,$IDServicio=null){
		if($IDCliente && $IDServicio == null){

					$sql = "SELECT 
									ts.*
									,tp.DescripcionPrioridad
									,tp.ColorPrioridad
									,tp.HorasInicialRespuesta
									,tp.HorasFinalRespuesta
									,ts.IDDoc
									,tec.Serial
									,te.DescripcionEquipo
									,te.ModeloEquipo
									,tem.EquipoMarca
									,tcd.NombreDireccion
									,tcd.BarrioCiudad
									,tcd.PrincipalDir
									,tc.NombreCliente
									,tc.ClasificacionCliente
									,CONCAT(tc.NombreCliente, ' ', tc.ApellidoCliente) AS NombreCompletoCliente
									FROM tbl_ServicioCAB ts
									INNER JOIN tbl_Prioridades tp ON tp.IDPrioridad = ts.IDPrioridad
									INNER JOIN tbl_EquipoCliente tec ON tec.IDEquipoCliente=ts.IDEquipoCliente
									INNER JOIN tbl_Equipo te ON te.IDEquipo=tec.IDEquipo
									INNER JOIN tbl_EquipoMarcas tem ON tem.IDEquipoMarca = te.IDMarcaEquipo
									INNER JOIN tbl_ClienteDirecciones tcd ON tcd.IDClienteDirecciones=tec.IDClienteDireccion
									INNER JOIN tbl_Cliente tc ON tc.IDCliente=ts.IDCliente
									WHERE  tc.IDCliente=?";

					$stm = $this->pdo->prepare($sql);
					$stm->execute(array($IDCliente));
					$result= $stm->fetchAll(PDO::FETCH_OBJ);
		}else if($IDCliente == null && $IDServicio == null){

			$str_estados_servicios= implode(', ', $estado_servicios);
			$sql= "SELECT 
								ts.*
								,tp.DescripcionPrioridad
								,tp.ColorPrioridad
								,tp.HorasInicialRespuesta
								,tp.HorasFinalRespuesta
								,ts.IDDoc
								,tec.Serial
								,te.DescripcionEquipo
								,te.ModeloEquipo
								,tem.EquipoMarca
								,tcd.NombreDireccion
								,tcd.BarrioCiudad
								,tcd.PrincipalDir
								,tc.NombreCliente
								,tc.ClasificacionCliente
								,CONCAT(tc.NombreCliente, ' ', tc.ApellidoCliente) AS NombreCompletoCliente
								FROM tbl_ServicioCAB ts
								INNER JOIN tbl_Prioridades tp ON tp.IDPrioridad = ts.IDPrioridad
								INNER JOIN tbl_EquipoCliente tec ON tec.IDEquipoCliente=ts.IDEquipoCliente
								INNER JOIN tbl_Equipo te ON te.IDEquipo=tec.IDEquipo
								INNER JOIN tbl_EquipoMarcas tem ON tem.IDEquipoMarca = te.IDMarcaEquipo
								INNER JOIN tbl_ClienteDirecciones tcd ON tcd.IDClienteDirecciones=tec.IDClienteDireccion
								INNER JOIN tbl_Cliente tc ON tc.IDCliente=ts.IDCliente
								WHERE  tc.EstadoCliente=? AND ts.Estado in (" . $str_estados_servicios . ")".(($IDCliente)?" AND tc.IDCliente=".$IDCliente:"").";";
    
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($estado_clientes));
			$result = $stm->fetchAll(PDO::FETCH_OBJ);

		}else if($IDServicio && $IDCliente == null){

			$result=array();

			$sql = "Call ObtenerDetalleServicio(?);";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDServicio));

			$result_detalle=$stm->fetchAll(PDO::FETCH_OBJ);
			array_push($result, $result_detalle);

			$stm->nextRowset();
			$productos_servicio = $stm->fetchAll(PDO::FETCH_ASSOC);
			array_push($result,$productos_servicio);

			$stm->nextRowset();
			$actividades_servicio = $stm->fetchAll(PDO::FETCH_ASSOC);
			array_push($result, $actividades_servicio);
		}
    return $result;

  }

  function lista_equiposxdireccion(){
    $sql = "";
  }

  function listar_prioridades($estado=NULL,$IDTenant=NULL){
    $sql= "SELECT * FROM tbl_Prioridades";
    $sql.= ($estado != NULL || $IDTenant != NULL)?" WHERE ":'';
    $sql.=($estado != NULL)? " EstadoPrioridad=".$estado:'';
    $sql.=($estado != NULL && $IDTenant != NULL)? ' AND ':'';
    $sql.=($IDTenant != NULL)? " IDTenant in (".$IDTenant.",0) " :'';

    $stm = $this->pdo->prepare($sql);
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_OBJ);
  }

  function listar_eventos_paracalendario($estado_servicios,  $estado_clientes){
    $str_estados_servicios = implode(', ', $estado_servicios);  
    $sql = "SELECT 
        ts.IDServicio
        ,ts.IDDoc
        ,ts.FechaServicioCreacion
				,ts.FechaServicio
        ,DATE_FORMAT(ts.HoraPlaneacionInicio,'%H:%i:%s') AS HoraPlaneacionInicio
        ,DATE_FORMAT(ts.HoraPlaneadaTerminacion,'%H:%i:%s') AS HoraPlaneadaTerminacion
        ,tut.IDUser AS IDTecnicoAsignado
        ,tut.NombreUsuario AS NombreTecnicoAsignado
        ,tut.ColorTecnico
        ,tut.NombreCortoTecnico
        ,tuc.IDUser AS IDUsuarioCreacion
        ,tuc.NombreUsuario AS NombreUsuarioCreador
        ,tp.IDPrioridad
        ,tp.DescripcionPrioridad
        ,tp.ColorPrioridad
        ,tp.HorasInicialRespuesta
        ,tp.HorasFinalRespuesta
        ,tec.Serial
        ,te.DescripcionEquipo
        ,te.ModeloEquipo
        ,tem.EquipoMarca
        ,tcd.NombreDireccion
        ,tcd.BarrioCiudad
        ,tcd.PrincipalDir
        ,tc.NombreCliente
        ,CONCAT(tc.NombreCliente, ' ', tc.ApellidoCliente) AS NombreCompletoCliente
				,ts.Notas
				,ts.FechaHoraTomado
				,ts.EstadoTomado
				,ts.Estado AS EstadoServicio
        FROM tbl_serviciocab ts
        INNER JOIN tbl_User tuc ON tuc.IDUser=ts.IDUsuarioCreacion 
        left JOIN tbl_User tut ON tut.IDUser=ts.IDTecnicoAsignado
        INNER JOIN tbl_Prioridades tp ON tp.IDPrioridad = ts.IDPrioridad
        INNER JOIN tbl_EquipoCliente tec ON tec.IDEquipoCliente=ts.IDEquipoCliente
        INNER JOIN tbl_Equipo te ON te.IDEquipo=tec.IDEquipo
        INNER JOIN tbl_EquipoMarcas tem ON tem.IDEquipoMarca = te.IDMarcaEquipo
        INNER JOIN tbl_ClienteDirecciones tcd ON tcd.IDClienteDirecciones=tec.IDClienteDireccion
        INNER JOIN tbl_Cliente tc ON tc.IDCliente=tcd.IDCliente
        WHERE tc.EstadoCliente=? AND ts.Estado IN (". $str_estados_servicios.");";
      
    $stm = $this->pdo->prepare($sql);
    $stm->execute(array($estado_clientes));
    return $stm->fetchAll(PDO::FETCH_OBJ);
  }

	function listadotecnicosdisponibles($fechaservicio=null,$hora_inicial=null,$hora_final=null){

		if($fechaservicio && $hora_inicial && $hora_final){
				
				$sql = "CALL getDisponiblestecnico(?,?,?)";
				$stm = $this->pdo->prepare($sql);
				$stm->execute(array($fechaservicio, $hora_inicial, $hora_final));
				
				//Lista de Tecnicos disponibles en las fechas seleccionadas
				$lista_tecnicos_disponibles = $stm->fetchAll(PDO::FETCH_OBJ);
				$stm->nextRowset();

				$stm = null;

		}else{

				$sql="SELECT
					tup.IDUser,
					tup.NombreUsuario,
					tup.ApellidosUsuario,
					CONCAT(tup.NombreUsuario,' ',tup.ApellidosUsuario) AS NombreCompletoTecnico,
					tup.NombreCortoTecnico,
					tup.CalificacionTecnica,
					tup.ColorTecnico
				FROM tbl_User tup
				WHERE tup.UsuarioTecnico=true
				AND tup.DisponibilidadTecnica=true
				ORDER BY tup.CalificacionTecnica DESC;";

				$stm = $this->pdo->prepare($sql);
				$stm->execute();
				$lista_tecnicos_disponibles = $stm->fetchAll(PDO::FETCH_OBJ);
		
		}

		return ($lista_tecnicos_disponibles);
	}

	function InsertarNuevoServicio(

				$FechaServicioCreacion,
				$IDUsuarioCreacion,
				$Estado,
				$FechaServicio,
				$HoraPlaneacionInicio,
				$HoraPlaneadaTerminacion,
				$IDTipoServicio,
				$IDEquipoCliente,
				$DescripcionCausa,
				$IDPrioridad,
				$IDCategoria,
				$IDUsuarioAsignaciontecnico,
				$FechaHoraAsignaciontecnico,
				$IDTecnicoAsignado,
				$IDUserUltimaModificacion,
				$FechaHoraUltimaModificacion,
				$Notas
			){

			$sql = "Call crearServicio(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array(
				$FechaServicioCreacion,
				$IDUsuarioCreacion,
				$Estado,
				$FechaServicio,
				$HoraPlaneacionInicio,
				$HoraPlaneadaTerminacion,
				$IDTipoServicio,
				$IDEquipoCliente,
				$DescripcionCausa,
				$IDPrioridad,
				$IDCategoria,
				$IDUsuarioAsignaciontecnico,
				$FechaHoraAsignaciontecnico,
				$IDTecnicoAsignado,
				$IDUserUltimaModificacion,
				$FechaHoraUltimaModificacion,
				$Notas));
			return $stm->fetchAll(PDO::FETCH_OBJ);


	}

	function InsertarNuevaActividad($IDServicio,$IDUsuario,$FechaActividad,$Descripcionactividad,$EstadoActividad, $EstadoActualServicio){
			
			$arrayvalues="?,?,?,?,?";
			$arrayexecute=array($IDServicio, $IDUsuario, $FechaActividad, $Descripcionactividad, $EstadoActualServicio);
			$sql="INSERT INTO tbl_actividadservicio(
							IDServicio
						, IDUsuario
						, FechaActividad
						, DescripcionActividad
						, EstadoAnt";
			
			if($EstadoActividad){
				$sql.=", EstadoServicio";
				$arrayvalues.= ",?";
				array_push($arrayexecute,$EstadoActividad);
			}

			$sql.=")
					VALUES (". $arrayvalues.")";
			$stm = $this->pdo->prepare($sql);

			if($stm->execute($arrayexecute)){
				$this->cambioestadoservicio($IDServicio, $EstadoActividad);
				return 1;
			}else{
				return 0;
			}
  }

	function ListarActividadesxServicio($IDServicio){
			$sql="	SELECT 
						tas.IDActividadServicio
					, tas.IDServicio
					, tas.IDUsuario
					, tas.FechaActividad
					, tas.DescripcionActividad
					, tas.EstadoServicio
					, tas.EstadoAnt
					,CONCAT(tu.NombreUsuario,' ',tu.ApellidosUsuario) as NombreUsuario
					,tu.ImagenUsuario
					FROM tbl_actividadservicio tas
					JOIN tbl_user tu ON tu.IDUser= tas.IDUsuario 
					WHERE tas.IDServicio=?
					ORDER BY tas.FechaActividad DESC;";
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array($IDServicio));
			return $stm->fetchAll(PDO::FETCH_OBJ);
	}

	function cambioestadoservicio($IDServicio,$Nuevoestado){

			$sql="UPDATE tbl_serviciocab
					SET
						Estado=?
					WHERE IDServicio=?";
			$stm = $this->pdo->prepare($sql);
			return $stm->execute(array($Nuevoestado, $IDServicio));
	}

function listaprioridades(){
		$sql="SELECT * FROM tbl_prioridades where EstadoPrioridad=1";
		$stm = $this->pdo->prepare($sql);
		$stm->execute();
		return $stm->fetchAll(PDO::FETCH_OBJ);
}

}

<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong><i class="bi bi-wrench-adjustable"></i> Servicios </strong></h3>
	<div class="btn-toolbar mb-2 mb-md-0">
		<a class="btn btn-sm btn-primary me-2" href="<?php echo URL_PATH ?>servicios/nuevoservicio" role="button"><i class="bi bi-plus align-text-bottom"></i> Nuevo Servicio</a>
	</div>
</div>
<!-- ./ Titulo -->

<div id="alert_form"></div>
<?php //var_dump($lista_servicios_abiertos["serviciosabiertos"]); 
?>
<div class="container-fluid">

	<div class="tab-content" id="myTabContent">
		<!-- Lista de servicios activos estado (0,1,2,3) -->
		<div class="tab-pane fade show active" id="servicio-tab-abiertas" role="tabpanel" aria-labelledby="abiertas-tab" tabindex="0">
			<div>
				<div class="table-responsive">
					<table class="table table-striped table-hover	table-borderless align-middle table-responsive" id="tbl_servicios">
						<thead class="table-light">
							<tr>
								<th scope="col">Documento</th>
								<th scope="col">Estado</th>
								<th scope="col">Prioridad</th>
								<th scope="col">Vencimiento</th>
								<th scope="col">Fecha incio servicio</th>
								<th scope="col">Nombre Cliente</th>
								<th scope="col">Clasificación</th>
								<th scope="col">Nombre direccion</th>
								<th scope="col">Modelo equipo</th>
								<!-- <th scope="col">Acciones</th> -->
							</tr>
						</thead>
						<tbody class="table-group-divider">

							<?php
							$fecha_hoy = new DateTime();
							if (isset($lista_servicios_abiertos["serviciosabiertos"])) {
								foreach ($lista_servicios_abiertos["serviciosabiertos"] as $key3 => $value3) {
									$backgound_categoria = config_categorias_cliente[$value3->ClasificacionCliente]["backgound_categoria"];
									$color_font = config_categorias_cliente[$value3->ClasificacionCliente]["color_font"];
									$style_font = config_categorias_cliente[$value3->ClasificacionCliente]["style_font"];
									$font_size = config_categorias_cliente[$value3->ClasificacionCliente]["font_size"];
									$FechaHoraPlaneadaTerminacion = $value3->FechaServicio . " " . $value3->HoraPlaneadaTerminacion;
									$FechaHoraPlaneacionInicio = $value3->FechaServicio . " " . $value3->HoraPlaneacionInicio;
									$fechavencimientofinal_segun_prioridad = new DateTime($FechaHoraPlaneadaTerminacion);
									$fecha_vencimiento_final = $fechavencimientofinal_segun_prioridad->modify('+' . $value3->HorasFinalRespuesta . ' hours');
									$diff_fechavencimientoFinal = $fecha_vencimiento_final->diff($fecha_hoy);
									$text_tooltip = "<strong>Vencido</strong> x " . $diff_fechavencimientoFinal->d . "d:" . $diff_fechavencimientoFinal->h . "h.<br>Debio cerrarse el: " . $fecha_vencimiento_final->format("Y-m-d h:m:s");
							?>
									<tr>
										<!-- IdServicio -->
										<td><a href="<?php echo URL_PATH; ?>servicios/detalleservicio/?IDServicio=<?php echo urlencode(openssl_encrypt($value3->IDServicio, METHODENCRIPT, KEY)); ?>"><?php echo "OS-" . $value3->IDDoc; ?></a></td>
										<!-- Estado servicio -->
										<td><?php echo definicion_estado_servicio($value3->Estado); ?></td>
										<!-- Priodidad servicio -->
										<td>
											<?php echo "<span class='badge px-3' style='background-color:" . $value3->ColorPrioridad . "'>" . $value3->DescripcionPrioridad . "</span>"; ?>
										</td>
										<!-- Vencimiento Servicio -->
										<td>
											<?php
											$vencimiento = definicion_vencimiento($value3->FechaServicio, $value3->HoraPlaneadaTerminacion, $value3->HoraPlaneacionInicio, $value3->HorasFinalRespuesta);
											echo (($vencimiento[0] === "+") ? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='" . $vencimiento[1] . "'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'>Vencido</strong></span>" : "-");
											?>
										</td>
										<!-- Fecha planeacion servicio -->
										<td><?php echo (new DateTime($FechaHoraPlaneacionInicio))->format('d-M-Y h:i A'); ?></td>
										<!-- Nombre categoria del cliente -->
										<td>
											<?php echo $value3->NombreCompletoCliente; ?>
										</td>
										<td class="text-center">
											<span class="fw-bold px-3" style="font-size: 0.685rem ; color:<?php echo $color_font; ?>; padding:0.28rem 0.48rem; border-radius: 10px;background-color:<?php echo $backgound_categoria; ?>;<?php echo (($value3->ClasificacionCliente == "VIP") ? 'box-shadow: 0 4px 8px 0 rgba(0, 0, 0,0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.4);' : ''); ?>">
												<?php if ($value3->ClasificacionCliente == "VIP") {
													echo '<i class="bi bi-gem" style="color:green;margin-right: 4px;font-weight: bold;margin-left: 4px;"></i>';
												} ?>
												<?php echo $value3->ClasificacionCliente; ?>
											</span>
										</td>
										<!-- Direccion del cliente  -->
										<td><?php echo $value3->NombreDireccion; ?></td>
										<!-- Modelo del equipo  -->
										<td><?php echo $value3->ModeloEquipo; ?></td>

										<!-- <td><a href="http://<?php //echo URL_PATH 
																							?>editardireccion/?IDServicio=<?php //echo $value3->IDServicio; 
																																																	?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td> -->
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Lista de servicios cerrados estado (4) -->
		<div class="tab-pane fade" id="servicios-tab-historico" role="tabpanel" aria-labelledby="historicoe-tab" tabindex="0" style="background-color: #fff !important;">
			<div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
							<tr>
								<th scope="col">Documento</th>
								<th scope="col">Estado</th>
								<th scope="col">Prioridad</th>
								<th scope="col">Vencimiento</th>
								<th scope="col">Fecha cierre servicio</th>
								<th scope="col">Nombre direccion</th>
								<th scope="col">Modelo equipo</th>
								<th scope="col">Acciones</th>
							</tr>
							</tr>
						</thead>
						<tbody>

							<?php
							if (isset($data_ficha_cliente[2])) {
								foreach ($data_ficha_cliente[2] as $key4 => $value4) {
									$fechacierre_servicio = new DateTime($value4->FechaHoraCierre);
									$fecha_atencionplaneada = new DateTime($value4->FechaHoraPlaneadaTerminacion);
									$dias_entre_cierreyatencion = $fechacierre_servicio->diff($fecha_atencionplaneada);
									$text_tooltip_cerrados = ($dias_entre_cierreyatencion->format('%R') === "-") ? "Se atendio vencido x " . ($dias_entre_cierreyatencion->d) . " dias y " . ($dias_entre_cierreyatencion->h) . " horas" : "Atendido a tiempo";
							?>
									<tr>
										<td><?php echo "OS-" . $value4->IDDoc; ?></td>
										<td><?php echo definicion_estado_servicio($value4->Estado); ?></td>
										<td><?php echo "<span class='badge px-3' style='background-color:" . $value4->ColorPrioridad . "'>" . $value4->DescripcionPrioridad . "</span>"; ?></td>
										<td><?php echo (($dias_entre_cierreyatencion->format('%R') === "-") ? "<span class='badge text-bg-warning' data-bs-toggle='tooltip' data-bs-html='true' data-bs-placement='top' data-bs-title='$text_tooltip_cerrados'><i class='bi bi-exclamation-triangle-fill' style='color:red;font-size: 0.8rem;'></i> <strong style='font-size: 0.56rem;'></strong></span>" : "<i class='bi bi-bookmark-star-fill' style='color:green;'></i> A tiempo !"); ?></td>
										<td><?php echo $value4->FechaHoraCierre;
												?></td>
										<td><?php echo $value4->NombreDireccion;
												?></td>
										<td><?php echo $value4->ModeloEquipo; ?></td>
										<td><a href="http://<?php echo URL_PATH ?>editardireccion/?IDDireccion=<?php echo urlencode(openssl_encrypt($value4->IDServicio, METHODENCRIPT, KEY)); ?>" class="mx-2"><i class="bi bi-pencil-square"></i></a><a href="http://"><i class="bi bi-trash3-fill" style="color:red"></i></a></td>
									</tr>
							<?php }
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
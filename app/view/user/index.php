<!-- Titulo Seccion segun clase en php -->
<?php //var_dump($list_user); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3>
		<strong>
			<?php if ($tecnico) { ?>
				<i class="bi bi-people-fill align-text-bottom"></i> Maestro de Técnicos
			<?php } else { ?>
				<i class="bi bi-person-badge align-text-bottom"></i> Maestro de Usuarios
			<?php } ?>
		</strong>
	</h3>
	<input type="hidden" name="tecnico" id="tecnico" value="<?php echo $tecnico; ?>">
	<div class="btn-toolbar mb-2 mb-md-0">
		<a name="" id="" class="btn btn-sm btn-success me-2" href="<?php echo URL_PATH; ?>usuarios/nuevousuario/?tecnico=<?php echo $tecnico ?>" role="button"><i class="bi bi-plus align-text-bottom"></i> Nuevo <?php echo ($tecnico) ? "técnico" : "usuario"; ?></a>
	</div>
</div>
<!-- ./ Titulo -->
<div id="alert_form">
	<?php if (isset($_SESSION['msg'])) { ?>

		<div class="alert alert-<?php echo $_SESSION['msg']['type']; ?> alert-dismissible fade show" role="alert">
			<strong><?php echo $_SESSION['msg']['title']; ?></strong> <?php echo $_SESSION['msg']['msg']; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php
		unset($_SESSION['msg']);
	} ?>
</div>
<div>
	<table class="table table-striped table-hover	table-borderless align-middle table-responsive" width="100%" id="Table_list_User">
		<thead class="table-light">
			<tr>
				<th>Nombre</th>
				<?php if ($tecnico) { ?>
					<th>Nombre Corto</th>
					<th>Color</th>
				<?php }else{ ?>
				<th>Perfil</th>
				<?php } ?>
				<th>Estado</th>
				<?php if ($tecnico) { ?>
					<th>Disponible</th>
					<th class="text-center">Calificacion (1-5)</th>
				<?php } ?>

				<th>Acciones</th>

			</tr>
		</thead>
		<tbody>

			<?php foreach ($list_user['data'] as $key => $value) { ?>
				<tr>
					<td><?php echo $value['NombreCompletoUsuario']; ?></td>
					<?php if ($tecnico) { ?>
						<td><?php echo $value['NombreCortoTecnico']; ?></td>
						<td><?php echo ($value["ColorTecnico"]) ? '<span class="badge px-3" style="background-color:' . $value["ColorTecnico"] . '">&nbsp;</span>' : ' - sin color -'; ?></td>
					<?php } ?>
					<?php if (!$tecnico) { ?> <td><?php echo $value['Perfiles']; ?></td><?php } ?>
					<td><?php echo ($value['EstadoUsuario']) ? '<i class="bi bi-check-circle-fill" style="font-size: 1rem;color:green;"></i>' : '<span class="text-muted fst-italic">Inactivo</span>'; ?></td>
					<?php if ($tecnico) { ?>
						<td><?php echo ($value["DisponibilidadTecnica"]) ? '<i class="bi bi-wrench-adjustable-circle-fill" style="font-size: 1.3rem;color:green"></i>' : '<span class="text-muted fst-italic">No disponible</span>'; ?></td>
						<td><?php if ($value["CalificacionTecnica"]) { ?>
								<div class="container text-center">
									<div class="row"><?php echo ($value["CalificacionTecnica"] >= 4.8)? '<div class="col-2">
											<i class="bi bi-trophy-fill" style="color:#6610f2"></i>
										</div>':''; ?>
										<div class="col-12">
											<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="<?php echo $value["CalificacionTecnica"];?>" aria-valuemin="0" aria-valuemax="5">
												<div class="progress-bar progress-bar-striped progress-bar-animated <?php echo ($value["CalificacionTecnica"] < 3 )?'bg-danger':(($value["CalificacionTecnica"] >= 3 && $value["CalificacionTecnica"] < 4.5)? 'bg-warning':(($value["CalificacionTecnica"] >= 4.5 && $value["CalificacionTecnica"] < 4.9)? 'bg-info': 'bg-success')); ?>" style="width: <?php echo (($value["CalificacionTecnica"]*100)/5)."%"; ?>"><?php echo $value["CalificacionTecnica"]; ?></div>
											</div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<span class="text-muted fst-italic" style="color:red;">Sin calificación</span>
							<?php } ?>
						</td>
					<?php } ?>
					<td><?php echo $value["boton_editar"]; ?></td>
				</tr>
			<?php } ?>


		</tbody>
	</table>
</div>


<?php  ?>

<!-- Modal cambio contraseña usuario-->
<div class="modal fade" id="modal_changepassuser" tabindex="-1" role="dialog" aria-labelledby="Title_changepassuser" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="Title_changepassuser">Cambio contraseña: - <strong id="nameuser_changepass"></strong></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnclose_modalchangepass"></button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div id="alert_model_changepassuser"></div>
					<div class="mb-3">
						<label for="changepass_user" class="form-label">Nueva contraseña<span style="color:red">*</span></label>
						<div class="input-group mb-3">
							<input type="password" class="form-control form-control-sm" name="changepass_user" id="changepass_user" aria-describedby="changepass_user" autocomplete="off" required>

							<a class="input-group-text text-decoration-none text-black" id="icon_changepass_user" href="#" role="button" onclick="view_pass()">
								<i class="bi bi-eye-slash-fill"></i>
							</a>
							<small id="helpId" id="cumple_check_pass" class="form-text text-muted">
								<span id="icono_validacion_changepass_user"></span>
								<span id="mensaje_validacion_changepass_user">Debe contener: entre 6-12 caracteres, letras mayusculas y minusculas (ambas), numeros.</span>
							</small>
						</div>
					</div>
					<div class="mb-3">
						<label for="confirm_changepass_user" class="form-label">Confirme la nueva contraseña<span style="color:red">*</span></label>
						<div class="input-group mb-3">
							<input type="password" class="form-control form-control-sm" name="confirm_changepass_user" id="confirm_changepass_user" aria-describedby="confirm_changepass_user" autocomplete="off" required>
							<a class="input-group-text text-decoration-none text-black" id="icon_confirm_changepass_user" href="#" role="button" onclick="confirm_view_pass()">
								<i class="bi bi-eye-slash-fill"></i>
							</a>
						</div>

						<div class="invalid-feedback">
							Las contraseñas deben ser iguales. Por favor confirme.
						</div>
						<div class="valid-feedback">
							Contraseñas iguales, muy bien !
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="button_change_pass">

			</div>
		</div>
	</div>
</div>
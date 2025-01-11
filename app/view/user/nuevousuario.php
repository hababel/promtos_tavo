<?php ?>
<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong><i class="bi bi-person-badge align-text-bottom"></i><span id="title_seccion"> Nuevo <?php echo ($tecnico) ? "Tecnico" : "Usuario"; ?></span></strong></h3>
	<div class="btn-toolbar mb-2 mb-md-0">
		<a name="" id="" class="btn btn-sm btn-success me-2" href="<?php echo URL_PATH . (($tecnico) ? 'usuarios/index/?tecnico=true' : 'usuarios'); ?>" role="button"><i class="bi bi-arrow-left"></i> volver</a>
	</div>
</div>
<!-- ./ Titulo -->
<div id="alert_form"></div>

<div class="container-fluid">
	<div><span style="color:red">*</span> - Campos obligatorios</div>

	<div id="alert_new_user"></div>

	<div class="container">
		<form class="row g-3 mt-2" action="<?php echo URL_PATH ?>usuarios/add_newuser<?php echo (isset($data_user)?'/?TKU='. rawurlencode($data_user['IDUser']):''); ?>" method="post" id="form_newuser" name="form_newuser">

			<input type="hidden" name="input_tecnico" id="input_tecnico" value="<?php echo $tecnico; ?>">
			<input type="hidden" name="validacion_newuser" id="validacion_newuser" value="">

			<div class="col-md-6">
				<label for="newuser_nombre" class="form-label">Nombres <span style="color:red">*</span></label>
				<input type="text" class="form-control" id="newuser_nombre" name="newuser_nombre" placeholder="" value="<?php echo isset($data_user) ? $data_user['NombreUsuario'] : ''; ?>" required autocomplete="off" minlength="4">
				<div class="invalid-feedback">El nombre es requerido.</div>
			</div>

			<div class="col-md-6">
				<label for="newuser_apellido" class="form-label">Apellidos <span style="color:red">*</span></label>
				<input type="text" class="form-control" placeholder="" value="<?php echo isset($data_user) ? $data_user['ApellidosUsuario'] : ''; ?>" id="newuser_apellido" name="newuser_apellido" required autocomplete="off" minlength="4">
				<div class="invalid-feedback">El apellido es requerido.</div>
			</div>

			<div class="col-md-6">
				<label for="email" class="form-label">Correo electrónico <span style="color:red">*</span></label>
				<div class="input-group">
					<input type="email" class="form-control is-invalid" id="newuser_email" name="newuser_email" placeholder="usuario@correo.com" required autocomplete="off" value="<?php echo isset($data_user) ? $data_user['EmailUsuario'] : ''; ?>">
					<input type="hidden" class="form-control" id="copy_newuser_email" name="copy_newuser_email" autocomplete="off" value="<?php echo isset($data_user) ? $data_user['EmailUsuario'] : ''; ?>">
					<button class="btn btn-outline-secondary btn-sm" type="button" id="btn_validarcorreo" disabled><i class="bi bi-search" id="icon_new_email"></i>
						<div class="spinner-border spinner-border-sm visually-hidden" id="spinner_new_email" role="status"></div>
					</button>
					<div class="invalid-feedback" id="disponibilidad_email"></div>
				</div>
			</div>
			<?php if (!isset($data_user)) {  // Si no se esta editando un usuario 
			?>
				<div class="col-md-6">
					<label for="newuser_pass" class="form-label">Contraseña <span style="color:red">*</span></label>
					<div class="input-group">
						<input type="password" class="form-control input_aftervalidateemail" id="newuser_pass" name="newuser_pass" required autocomplete="off" maxlength="12" minlength="6" aria-invalid="true" disabled>
						<button class="btn btn-dark input_aftervalidateemail" type="button" id="btn_showpass" disabled><span id="icono_showpass"><i class="bi bi-eye-slash-fill"></i></span></button>
						<div class="invalid-feedback" id="feedbback_pass">La contraseña es obligatoria.
							<ul></ul>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if ($tecnico) { ?>
				<div class="col-md-6">
					<label for="newuser_nombrecorto" class="form-label">Nombre corto <span style="color:red">*</span></label>
					<input type="text" class="form-control input_aftervalidateemail" placeholder="" value="Benitez" id="newuser_nombrecorto" name="newuser_nombrecorto" required autocomplete="off" minlength="4">
					<div class="invalid-feedback">El nombre corto es requerido.</div>
				</div>

				<div class="col-md-2">
					<label for="newuser_color" class="form-label">Color técnico<span style="color:red">*</span></label>
					<input type="color" class="form-control input_aftervalidateemail" id="newuser_color" name="newuser_color" value="#000000" required autocomplete="off" >
				</div>
			<?php } ?>

			<div class="<?php echo (($tecnico) ? 'col-md-4' : 'col'); ?>" style="background-color: #F8F9FA;display:flex;align-items: center;">
				<div class="custom-control custom-switch ps-5">
					<label for="newuser_status " class="form-label me-5">Estado</label>
					<input type="checkbox" class="custom-control-input input_aftervalidateemail" id="newuser_status" name="newuser_status" <?php echo isset($data_user['EstadoUsuario'])?(($data_user['EstadoUsuario'])?'checked':null):null; ?> >
					<label class="custom-control-label <?php echo isset($data_user['EstadoUsuario']) ? (($data_user['EstadoUsuario']) ? 'text-success' : 'text-danger') : 'text-success'; ?> " for="newuser_status" id="estadoLabel"><?php echo isset($data_user['EstadoUsuario']) ? (($data_user['EstadoUsuario']) ? 'Activo' : 'Inactivo') : 'Activo'; ?></label>
				</div>
			</div>
			<div class="<?php echo (($tecnico) ? 'col-md-6' : ((isset($data_user))?'col-12':'col')); ?>">
				<label for="newuser_profile" class="form-label">Asignación de perfil</label>
				<select class="form-select select_2 input_aftervalidateemail" style="width: 100%;" id="newuser_profile" name="newuser_profile[]" multiple>
					<?php foreach ($lista_perfiles_disponibles as $key => $value) { ?>
						<option value="<?php echo $value->IDPerfil; ?>" <?php echo isset($data_user)?(($data_user['perfiles_asignados'])? (in_array($value->IDPerfil, $data_user['perfiles_asignados']) ? "selected" : ""):""):""; ?>><?php echo  $value->NombrePerfil; ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="col-md-12 mt-5">
				<button type="reset" class="btn btn-secondary">Limpiar</button>
				<button type="submit" class="btn btn-success me-2 input_aftervalidateemail" id="btn_guardar_nuevousuario" name="btn_guardar_nuevousuario">Guardar</button>
			</div>

		</form>
	</div>
</div>
<style>
	/* Estilo personalizado para el switch */
	.custom-switch .custom-control-label::before {
		width: 60px;
		/* Ancho del switch */
	}

	.custom-switch .custom-control-label::after {
		left: 28px;
		/* Posición del switch */
	}
</style>
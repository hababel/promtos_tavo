<?php
	$fecha_actual = new DateTime();
	$fecha_creacion = new DateTime($_SESSION['user']['FechaCreacion']);
	$diferencia = $fecha_actual->diff($fecha_creacion);
?>
<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h3>
    <strong><i class="bi bi-person-badge align-text-bottom"></i> Perfil de usuario</strong>
  </h3>
</div>
<!-- ./ Titulo -->
<div id="alert_form"></div>
<div class="container">
  <div class="row g-5">
    <div class="col-md-7 col-lg-8">
      <h4 class="mb-3">Datos principales</h4>
      <form class="needs-validation" id="form_newuser" name="form_newuser">
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="firstName" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="<?php echo ($data_user)? $data_user[0]->NombreUsuario:"";  ?>" required>
            <div class="invalid-feedback">
              El nombre es requerido.
            </div>
          </div>

          <div class="col-sm-6">
            <label for="lastName" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" required value="<?php echo ($data_user)?$data_user[0]->ApellidosUsuario:"" ; ?>">
            <div class="invalid-feedback">
              El apellido es requerido.
            </div>
          </div>

          <div class="col-sm-7">
            <label for="newuser_email" class="form-label">Correo electrónico <span style="color:red" disabled>*</span></label>
            <input type="text" class="form-control" id="newuser_email" name="newuser_email" placeholder="usuario@correo.com" required autocomplete="off" value="<?php echo ($data_user)?$data_user[0]->EmailUsuario:"" ; ?>">
          </div>

          <div class="col-sm-5">
            <label for="address" class="form-label">Fecha creacion</label>
            <input type="datetime-local" class="form-control" id="fechacreacion" placeholder="" required="" value="<?php echo ($data_user)?$data_user[0]->FechaCreacion:"" ; ?>" disabled>
            <div class="form-text" id="basic-addon4"><?php echo $diferencia->format('%y años - %m meses - %d dias'); ?></div>
          </div>

          <div class="col-sm-8">
            <label class="form-label" for="perfiles_usuario">Perfiles asignados</label>
            <select class="custom-select select_2 form-control" style="width: 100%;" name="perfiles_usuario[]" id="perfiles_usuario" multiple <?php echo (!$D10S) ? 'disabled' : null; ?>>
              <?php foreach ($data_perfiles_disponibles as $key => $value) { ?>
                <option value="<?php echo $value["IDPerfil"]; ?>" <?php echo  ($value["selected"]) ? ' selected' : null; ?>><?php echo $value["NombrePerfil"]; ?></option>
              <?php   } ?>
            </select>
          </div>

          <div class="col-sm-4 align-self-center">
            <div class="d-flex justify-content-center ">
              <div class="form-check form-switch align-middle">
                <label class="form-check-label" for="newuser_status" id="text_newuser_status">Activo</label>
                <input class="form-check-input" type="checkbox" role="switch" name="newuser_status" id="newuser_status" <?php echo ($data_user)? (($data_user[0]->EstadoUsuario) ? 'checked' : null):null; ?> <?php echo (!$D10S) ? 'disabled' : null; ?>>
              </div>
            </div>
          </div>

          <div class="col-sm-12">
            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
						<?php if ($_SESSION['user']["ConAcceso"] && $_SESSION['user']["perfiles_Asignados"]){ ?>
              <button class='btn btn-warning btn-sm' type='button' id='changepassuser' name='changepassuser' data-bs-toggle='modal' data-bs-target='#modal_changepassuser' onclick='prepare_changepassuser()'><i class='bi bi-key'></i> Cambiar contraseña</button>
              <button class="btn btn-primary btn-sm" type="button" id="changeuserprofile" name="changeuserprofile">Guardar cambios</button>
						<?php } ?>
            </div>
          </div>
      </form>

      </div>
    </div>

  <div class="col-md-5 col-lg-4">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-primary">Transacciones</span>
      <!-- <span class="badge bg-primary rounded-pill">3</span> -->
    </h4>
    <ul class="list-group mb-3 visually-hidden">
      <li class="list-group-item d-flex justify-content-between lh-sm">
        <div>
          <h6 class="my-0">Servicios completados</h6>
          <!-- <small class="text-body-secondary">Brief description</small> -->
        </div>
        <span class="text-body-secondary">15</span>
      </li>
      <li class="list-group-item d-flex justify-content-between lh-sm">
        <div>
          <h6 class="my-0">Servicios abiertos</h6>
          <!-- <small class="text-body-secondary">Brief description</small> -->
        </div>
        <span class="text-body-secondary">15</span>
      </li>
      <li class="list-group-item d-flex justify-content-between lh-sm">
        <div>
          <h6 class="my-0">Calificacion</h6>
          <!-- <small class="text-body-secondary">Brief description</small> -->
        </div>
        <span class="text-body-secondary">8</span>
      </li>
      <li class="list-group-item d-flex justify-content-between lh-sm">
        <div>
          <h6 class="my-0">Proximos servicios</h6>
        </div>
        <span class="text-body-secondary">10</span>
      </li>

    </ul> 
  </div>

</div>

<!-- Modal cambio contraseña usuario-->
<div class="modal fade" id="modal_changepassuser" tabindex="-1" role="dialog" aria-labelledby="Title_changepassuser" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="Title_changepassuser">Cambio contraseña: - <strong id="nameuser_changepass"></strong></h5>
        <input type="hidden" name="tokenuser_changepass" id="tokenuser_changepass">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnclose_modalchangepass"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="alert_model_changepassuser"></div>
          <!-- <div class="input-group mb-3">
            <button class="btn btn-outline-secondary" type="button" id="button-addon1">Button</button>
            <input type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
          </div> -->

          <div class="input-group  mb-3">
            <label for="changepass_user" class="form-label">Nueva contraseña<span style="color:red">*</span></label>
            <div class="input-group">
              <input type="password" class="form-control form-control-sm" name="changepass_user" id="changepass_user" aria-describedby="changepass_user" autocomplete="off" required>
              <span class="input-group-text" onmouseup="ocultar_pass('changepass_user')" onmouseout="ocultar_pass('changepass_user')" onmousedown="mostrar_pass('changepass_user');"><i class="bi bi-eye-fill"></i></span>
            </div>
            <small id="helpId" id="cumple_check_pass" class="form-text text-muted">
              <span id="icono_validacion_changepass_user"></span>
              <span id="mensaje_validacion_changepass_user">Debe contener: entre 6-12 caracteres, letras mayusculas y minusculas (ambas), numeros.</span>
            </small>
          </div>

          <div class="mb-3">
            <label for="confirm_changepass_user" class="form-label">Confirme la nueva contraseña<span style="color:red">*</span></label>
            <input type="password" class="form-control form-control-sm" name="confirm_changepass_user" id="confirm_changepass_user" aria-describedby="confirm_changepass_user" autocomplete="off" required>
            <div class="invalid-feedback">
              Las contraseñas deben ser iguales. Por favor confirme.
            </div>
            <div class="valid-feedback">
              Contraseñas iguales, muy bien !
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="save_changepassuser">Guardar</button>
      </div>
    </div>
  </div>
</div>
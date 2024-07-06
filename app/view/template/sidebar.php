<?php
if (isset($_SESSION['user'])) {
?>
	<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
		<div class="position-sticky pt-3 sidebar-sticky">
			<ul class="nav flex-column">
				<?php if (isset($_SESSION['user'])) { ?>
						<li class="nav-item">
							<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Dashboard') ? ' active' : null) : null; ?>" aria-current="page" href="<?php echo URL_PATH . "dashboard"; ?>">
								<i class="bi bi-grid-fill align-text-bottom"></i>
								Panel
							</a>
						</li>
						<?php if ((calcularpermisos(1, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
							<li class="nav-item">
								<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Tenant') ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "tenant"; ?>">
									<i class="bi bi-diagram-3-fill align-text-bottom"></i>
									Organización
								</a>
							</li>
						<?php } ?>
						<?php if ((calcularpermisos(4, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
							<li class="nav-item">
								<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Productos') ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "productos"; ?>">
									<i class="bi bi-upc-scan align-text-bottom"></i>
									Productos
								</a>
							</li>
						<?php } ?>
						<?php if ((calcularpermisos(3, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
							<li class="nav-item">
								<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Clientes') ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "clientes"; ?>">
									<i class="bi bi-person-lines-fill"></i>
									Clientes
								</a>
							</li>
						<?php } ?>
						<?php if ((calcularpermisos(5, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
							<li class="nav-item">
								<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Servicios') ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "servicios"; ?>">
									<i class="bi bi-wrench-adjustable align-text-bottom"></i>
									Servicios
								</a>
							</li>
						<?php } ?>
						<?php if ((calcularpermisos(2, $_SESSION['user']['MatrizPermisos'])["read"]) || (calcularpermisos(9, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
							<hr>
							<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mb-3 text-muted text-uppercase">
								<span>Configuracion</span>
							</h6>
							<?php if ((calcularpermisos(2, $_SESSION['user']['MatrizPermisos'])["read"])) {	?>
								<li class="nav-item">
									<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Usuarios' && !$tecnico) ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "usuarios"; ?>">
										<i class="bi bi-person-badge align-text-bottom"></i>
										Usuarios
									</a>
								</li>
							<?php } ?>
							<?php if ((calcularpermisos(9, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
								<li class="nav-item">
									<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Perfiles') ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "perfiles"; ?>">
										<i class="bi bi-stack"></i>
										Perfiles
									</a>
								</li>
							<?php } ?>
							<?php if ((calcularpermisos(2, $_SESSION['user']['MatrizPermisos'])["read"])) { ?>
								<li class="nav-item">
									<a class="nav-link <?php echo (isset($use_method)) ? (($use_method == 'Usuarios' && $tecnico) ? ' active' : null) : null; ?>" href="<?php echo URL_PATH . "usuarios/index/?tecnico=true"; ?>">
										<i class="bi bi-people-fill align-text-bottom"></i>
										Técnicos
									</a>
								</li>
						<?php }
					 ?>
			</ul>
			<hr>
	<?php }
				} ?>

	<ul class="nav flex-column mb-2">
		<li class="nav-item dropup">
			<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="bi bi-person-square rounded-circle me-2" style="font-size: 1rem;"></i>
				<strong><?php echo isset($_SESSION['user']['NombreUsuario']) ? $_SESSION['user']['NombreUsuario'] : die(); ?></strong>
			</a>
			<ul class="dropdown-menu text-small shadow">
				<li><a class="dropdown-item" href="<?php echo URL_PATH ?>usuarios/verperfil/?TKU=<?php echo $_SESSION['user']['TKU']; ?>">Ver perfil</a></li>
				<li>
					<hr class="dropdown-divider">
				</li>
				<li><a class="dropdown-item" href="<?php echo URL_PATH ?>login/logout">Cerrar</a></li>
			</ul>
		</li>
	</ul>

		</div>
	</nav>

<?php } ?>
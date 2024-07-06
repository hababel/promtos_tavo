<!-- Titulo Seccion segun clase en php -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	<h3><strong>Panel principal</strong></h3>
	<div class="btn-toolbar mb-2 mb-md-0">

		<?php if ($permisosProducto["create"]) { ?>

			<button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="offcanvas" data-bs-target="#newproduct" aria-controls="offcanvasRight"><i class="bi bi-bag-plus-fill"></i> Nuevo Producto</button>

		<?php } ?>

		<?php if ($permisosCliente["create"]) { ?>

			<button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="offcanvas" data-bs-target="#newcliente" aria-controls="offcanvasRight"><i class="bi bi-person-plus-fill"></i> Nuevo Cliente</button>

		<?php } ?>

		<?php if ($permisosServicios["create"]) { ?>

			<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#newservices" aria-controls="offcanvasRight"><i class="bi bi-node-plus-fill"></i> Nuevo Servicio</button>

		<?php } ?>

	</div>
</div>
<!-- ./ Titulo -->
<div class="container">

	<div class="row">
		<div class="col-xl-5 col-lg-6">

			<div class="row">
				<div class="col-sm-6">
					<div class="card widget-flat mb-3">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-account-multiple widget-icon bg-success-lighten text-success"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Number of Customers">OS Vencidas</h5>
							<h3 class="mt-3 mb-3">6</h3>
							<span class="mb-0 text-muted">
								<span class="text-danger me-2"><i class="bi bi-arrow-up-circle-fill"></i> 5.27%</span>
								<div>
									<span class="text-nowrap">Ene/24 </span>
									<span class="ms-2">
										<a href="http://" style="text-decoration: none;color:black"> Ver mas <i class="bi bi-arrow-right-circle-fill"></i></a>
									</span>
								</div>
							</span>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

				<div class="col-sm-6">
					<div class="card widget-flat mb-3">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-cart-plus widget-icon bg-danger-lighten text-danger"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Number of Orders">OS Abiertas</h5>
							<h3 class="mt-3 mb-3">11</h3>
							<span class="mb-0 text-muted">
								<span class="text-danger me-2"><i class="bi bi-arrow-up-circle-fill"></i>1.08%</span>
								<div>
									<span class="text-nowrap">Ene/24 </span>
									<span class="ms-2">
										<a href="http://" style="text-decoration: none;color:black"> Ver mas <i class="bi bi-arrow-right-circle-fill"></i></a>
									</span>
								</div>
							</span>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->
			</div> <!-- end row -->

			<div class="row">
				<div class="col-sm-6">
					<div class="card widget-flat mb-3">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-currency-usd widget-icon bg-info-lighten text-info"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Average Revenue">OS Cerradas</h5>
							<h3 class="mt-3 mb-3">8</h3>
							<span class="mb-0 text-muted">
								<span class="text-success me-2"><i class="bi bi-arrow-up-circle-fill"></i> 7.00%</span>
								<div class="d-flex">
									<span class="text-nowrap pt-2">Ene/24 </span>
									<span class="ms-auto pt-2">
										<a href="http://" style="text-decoration: none;color:black"> Ver mas <i class="bi bi-arrow-right-circle-fill"></i></a>
									</span>
								</div>
							</span>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

				<div class="col-sm-6">
					<div class="card widget-flat mb-3">
						<div class="card-body">
							<div class="float-end">
								<i class="mdi mdi-pulse widget-icon bg-warning-lighten text-warning"></i>
							</div>
							<h5 class="text-muted fw-normal mt-0" title="Growth">OS Abiertos VIP</h5>
							<h3 class="mt-3 mb-3">4</h3>
							<div class="mb-0 text-muted">
								<span class="text-success me-2"><i class="bi bi-arrow-up-circle-fill"></i> 4.87%</span>
								<div class="d-flex">
									<span class="text-nowrap pt-2">Ene/24 </span>
									<span class="ms-auto pt-2">
										<a href="http://" style="text-decoration: none;color:black"> Ver mas <i class="bi bi-arrow-right-circle-fill"></i></a>
									</span>
								</div>
							</div>
						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->
			</div> <!-- end row -->

		</div> <!-- end col -->

		<div class="col-xl-7 col-lg-6">
			<div class="card widget-flat">
				<div class="d-flex card-header justify-content-between align-items-center">
					<h4 class="header-title">Projections Vs Actuals</h4>
				</div>
				<div class="card-body">

				</div> <!-- end card-body-->
			</div> <!-- end card-->

		</div> <!-- end col -->
	</div>
</div>
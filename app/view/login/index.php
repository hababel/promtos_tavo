<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Anibal Benitez">
	<meta name="generator" content="PROMTOS 1.0">
	<title>APP PROMTOS</title>

	<link href="<?php echo URL_PATH; ?>app/assets/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo URL_PATH; ?>app/assets/css/sign-in.css" rel="stylesheet">

	<style>
		footer {
			color: white;
			/* background-color: #F0F0F0; */
			width: 100%;
			height: 100px;
			position: absolute;
			bottom: 0;
			left: 0;
		}

		body {
			background-color: #edf8fd;
			display: flex;
			justify-content: center;
			align-items: center;
		}
	</style>

</head>

<body class="text-center">
	<div class="row container d-flex justify-content-center">

		<?php if (isset($_SESSION['sessData'])) { ?>
			<div class="mb-5" id="alert_login">
				<div class="alert alert-<?php echo $_SESSION['sessData']['status']['type']; ?> alert-dismissible fade show" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong class="pe-3"><?php echo $_SESSION['sessData']['status']['title']; ?>: </strong> <?php echo $_SESSION['sessData']['status']['msg']; ?>
				</div>
			</div>
		<?php
			session_destroy();
		}
		?>

		<div class="row container">
			<div>
				<div>
					<h1>APP - PROMTOS</h1>
				</div>
				<div class="form-signin w-100 m-auto">
					<form action="<?php echo URL_PATH; ?>login/authlogin" method="post">
						<div class="form-floating">
							<input type="email" class="form-control" id="login_email" name="login_email" placeholder="usuario@correo.com" required autocomplete="on">
							<label for="login_email">Correo electrónico</label>
						</div>
						<div class="form-floating">
							<input type="password" class="form-control" id="login_pass" name="login_pass" placeholder="Contraseña" required autocomplete="off">
							<label for="login_pass">Contraseña</label>
						</div>
						<button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>
					</form>
					<div style="margin-top:10px;">
						<p class="mb-1">
							<a href="<?php echo URL_PATH; ?>login/requestrememberpass">Olvide mi clave</a>
						</p>
					</div>
					<footer>
						<div class="text-muted my-4" style="font-size: smaller;">
							<p class="mb-1">&copy; 2022–<?php echo date("Y"); ?> PROMTOS. Medellín - Colombia</p>
							<p>Creado por: <strong>Anibal Benitez A</strong></p>
						</div>
					</footer>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo URL_PATH; ?>app/assets/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>

	<script>
		document.addEventListener("DOMContentLoaded", function(event) {
			var alert_login = document.getElementById("alert_login");

			if (alert_login) {
				setTimeout(function() {
					alert_login.classList.add("visually-hidden")
				}, 5800);
			}
		})
	</script>

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		404 Page Not Found
	</title>

</head>

<body>
	<div class="error-container">
		<div>
			<h1> 404 </h1>
			<p>La pagina a la que estas ingresando no existe.</p>
			<a href="<?php echo URL_PATH; ?>">Vuelve al inicio</a>
		</div>
	</div>
</body>

<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		font-family: Arial, sans-serif;
		background-color: #D3D3D3;
		display: flex;
		justify-content: center;
		align-items: center;
		height: 100vh;
	}

	.error-container {
		padding-left: 40px;
		text-align: left;
		background-color: #fff;
		width: 580px;
		height: 400px;
		border-radius: 5px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		display: flex;
		align-items: center;
	}

	h1 {
		font-size: 5rem;
		color: #ff5733;
	}

	p {
		font-size: 1.5rem;
		color: #333;
		margin-bottom: 20px;
	}

	a {
		text-decoration: none;
		background-color: #ff5733;
		color: #fff;
		padding: 10px 20px;
		border-radius: 3px;
		font-weight: bold;
		transition: background-color 0.3s ease;
	}

	a:hover {
		background-color: #e6482e;
		padding: 10px 30px;
	}
</style>

</html>
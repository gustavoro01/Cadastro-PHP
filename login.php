<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			background: rgb(249, 249, 250);
			background: linear-gradient(90deg, rgba(249, 249, 250, 1) 0%, rgba(222, 222, 222, 1) 30%, rgba(196, 196, 196, 1) 100%);
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100vh;
		}

		.form-container {
			max-width: 400px;
			width: 100%;
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 10px;
			background: rgb(241, 248, 255);
			background: linear-gradient(90deg, rgba(241, 248, 255, 1) 0%, rgba(227, 239, 255, 1) 29%, rgba(135, 147, 159, 1) 100%);
		}
	</style>
</head>

<body>



	<div class="form-container">

		<div class="text-center mb-4">
			<h2 class="mb-4">Welcome back !</h2>
		</div>
		<form method="POST" action="valida.php">

			<div class="row mb-2">
				<label>User</label>
				<input type="text" class="form-control" name="usuario" placeholder="User"><br><br>
			</div>

			<div class="row mb-2">
				<label>Password</label>
				<input type="password" class="form-control" name="senha" placeholder="Password"><br><br>
			</div>

			<div class="form-group text-center">
				<input type="submit" name="btnLogin" value="To acess" class="btn btn-primary"></input>
			</div>


			<div class="text-center mb-1">
				<h4>You don't have an account?</h4>
				<a href="cadastrar.php">Sing up</a>
			</div>


		</form>
		<!-- Mensagem de erro -->
		<?php

		if (!empty($_SESSION['msg'])) {

			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}


		}

		?>
</body>

</html>
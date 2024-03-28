<?php
session_start();
ob_start();
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if ($btnCadUsuario) {
	include_once 'conexao.php';
	$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	//var_dump($dados);
	$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

	$result_usuario = "INSERT INTO usuarios (nome, email, usuario, senha) VALUES (
					'" . $dados['nome'] . "',
					'" . $dados['email'] . "',
					'" . $dados['usuario'] . "',
					'" . $dados['senha'] . "'
					)";
	$resultado_usario = mysqli_query($conn, $result_usuario);
	if (mysqli_insert_id($conn)) {
		$_SESSION['msgcad'] = "Usuário cadastrado com sucesso";
		header("Location: login.php");
	} else {
		$_SESSION['msg'] = "Erro ao cadastrar o usuário";
	}
}


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<title>Cadastrar</title>
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

	<?php
	if (isset($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
	?>
	<div class="form-container">
		<div class="text-center mb-4">
			<h2 class="mb-4">Sing up</h2>
		</div>
		<form method="POST" action="">

			<div class="row mb-3">
				<label class="form-label">Name</label>
				<input type="text" class="form-control" name="nome" placeholder="Name"><br><br>
			</div>

			<div class="row mb-3">
				<label class="form-label">E-mail</label>
				<input type="text" class="form-control" name="email" placeholder="E-mail"><br><br>
			</div>

			<div class="row mb-3">
				<label class="form-label">User</label>
				<input type="text" class="form-control" name="usuario" placeholder="User"><br><br>
			</div>

			<div class="row mb-3">
				<label class="form-label">Password</label>
				<input type="password" class="form-control" name="senha" placeholder="Password"><br><br>
			</div>

			<div class="form-group text-center">
				<input type="submit" name="btnCadUsuario" value="Sing up" class="btn btn-primary"></input>
			</div>

			<div class="text-center mb-1">
				Remembered? <a href="login.php">Click here</a> Login
			</div>


		</form>
</body>

</html>
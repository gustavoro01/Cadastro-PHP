<?php
session_start();
ob_start();
if (!empty($_SESSION['id'])) {
	// echo "Olá " . $_SESSION['nome'] . ", Bem vindo <br>";
	// echo "<a href='sair.php'>Sair</a>";
} else {
	// $_SESSION['msg'] = "Área restrita";
	// header("Location: login.php");

}



$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "celke";
//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
// Verificar a conexão
if ($conn->connect_error) {
	die("Erro de conexão: " . $conn->connect_error);
}


$btnCadastrar = filter_input(INPUT_POST, 'btnCadastrar', FILTER_SANITIZE_STRING);



// Função para inserir dados na tabela de fornecedores
function inserirFornecedor($nome_fornecedor, $conexao)
{
	// Preparando a consulta SQL
	$sql = "INSERT INTO `fornecedores`( `nome`) VALUES ('$nome_fornecedor')";

	// Preparando a declaração SQL
	$stmt = $conexao->prepare($sql);

	// Vinculando parâmetros
	// $stmt->bind_param("s", "'$nome_fornecedor'");

	// Executando a consulta
	if ($stmt->execute()) {
		// Retorna o ID do fornecedor inserido
		return $conexao->insert_id;
	} else {
		// Em caso de falha, retorna falso
		return false;
	}
}



$nome_fornecedor = isset($_POST["nome_fornecedor"]) ? $_POST["nome_fornecedor"] : "";







?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastrar Produtos</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<style>
		body {
			background: rgb(249, 249, 250);
			background: linear-gradient(90deg, rgba(249, 249, 250, 1) 0%, rgba(222, 222, 222, 1) 30%, rgba(196, 196, 196, 1) 100%);

		}

		.form-container {
			margin-top: 15%;

		}

		.btn {
			margin-top: 5%;
		}
	</style>
</head>

<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">Mini Sistema</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
			aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="PaginaInicial.php">Home<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="fornecedor.php">Cadastrar Fornecedor <span
							class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="cadastroProdutos.php">Cadastrar Produto</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="PaginaProdutos.php">Ver Produtos</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="form-container">
					<form method="POST" action="">
						<div class="text-center mb-4">
							<h2>Register Supplier</h2>
						</div>
						<form action="" method="POST">

							<div class="row mb-3">
								<label for="fornecedor"> Supplier:</label><br>
								<input type="text" placeholder="Supplier" class="form-control" id="nome_fornecedor"
									name="nome_fornecedor" required><br><br>
							</div>
							<?php
							// Verificando se a inserção foi bem sucedida
							if ($nome_fornecedor !== "") {
								// Chamando a função para inserir dados na tabela de fornecedores
								$id_fornecedor = inserirFornecedor($nome_fornecedor, $conn);
								if (!$id_fornecedor) {
									echo "Erro ao inserir dados do fornecedor...";

								} else {
									echo "Fornecedor Cadastrado com sucesso.";
									unset($_POST[""]);
								}
							}
							?>
							<div class="form-group text-center">
								<input type="submit" name="btnCadastrar" value="Register"
									class="btn btn-primary"></input>
							</div>
				</div>

				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
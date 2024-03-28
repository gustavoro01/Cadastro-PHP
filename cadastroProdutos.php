<?php
session_start();
ob_start();
if (!empty($_SESSION['id'])) {
    //echo "Olá " . $_SESSION['nome'] . ", Bem vindo <br>";
//	echo "<a href='sair.php'>Sair</a>";
} else {
    $_SESSION['msg'] = "Área restrita";
    header("Location: login.php");
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
function inserirProdutos($nome_produto, $id_forn, $preco, $conexao)
{
    // Preparando a consulta SQL
    $sql = "INSERT INTO `fornecedores`( `nome`) VALUES ('$nome_produto')";
    $sql = "INSERT INTO `produtos`( `nome`, `id_fornecedor`, `preco`) VALUES ('$nome_produto','$id_forn','$preco')";

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

$_SESSION['msgcad'] = "Erro ao cadastrar.";

$nome_produto = isset($_POST["produto"]) ? $_POST["produto"] : "";
$id_fornecedor = isset($_POST["id_fornecedor"]) ? $_POST["id_fornecedor"] : "";
$preco = isset($_POST["preco"]) ? $_POST["preco"] : "";
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

            .btn {
                margin-top: 5%;
            }

            .msg {
                background-color: #f0f0f0;
                border: 1px solid #ccc;
                color: #333;
                padding: 10px;
                margin-bottom: 10px;
            }
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
                    <li class="nav-item">
                        <a class="nav-link" href="sair.php">Logout</a>
                    </li>
                </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <div class="text-center mb-4">
                        <h2>Product Registration </h2>
                    </div>
                    <form action="" method="POST">

                        <div class="row mb-3">
                            <label for="produto">Register Product:</label><br>
                            <input type="text" class="form-control" id="produto" name="produto" required><br>
                        </div>

                        <div class="row mb-3">
                            <label for="preco">Price:</label><br>
                            <input type="text" class="form-control" id="preco" name="preco" required><br>
                        </div>

                        <?php $query = $conn->query("SELECT id_fornecedor, nome FROM fornecedores"); ?>


                        <div class="row mb-3">
                            <label for="fornecedor"> Supplier:</label><br>
                            <select name="id_fornecedor" class="form-control">
                                <?php
                                $result = $query->fetch_all();
                                foreach ($result as $reg) {
                                    var_dump($reg); ?>

                                    <option value="<?php echo $reg[0]; ?>">
                                        <?php echo $reg[1]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php
                        // Verificando se a inserção foi bem sucedida
                        if (!empty($nome_produto !== "") && ($id_fornecedor !== "" && $preco !== "")) {
                            // Chamando a função para inserir dados na tabela de fornecedores
                            $id_Produto = inserirProdutos($nome_produto, $id_fornecedor, $preco, $conn);
                            if (isset($id_Produto)) {
                                $_SESSION['msg'] = "Sucesso ao cadastrar produto!!!";
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        } else if (isset($_SESSION['msgcad'])) {

                        }


                        ?>
                        <div class="form-group text-center">
                            <input type="submit" name="btnCadastrar" value="Register" class="btn btn-primary"></input>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
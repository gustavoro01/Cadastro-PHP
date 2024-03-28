<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Adicionar Produtos ao Carrinho</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-RDrLqXg9VhYjlR9FZw3LRD8zPx50f7PU6lP9Tsy95ZcG11WWtvd5rqBfB5gZDlVfKoVzYVpncV5B2LM9HdQl3Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background: rgb(249, 249, 250);
            background: linear-gradient(90deg, rgba(249, 249, 250, 1) 0%, rgba(222, 222, 222, 1) 30%, rgba(196, 196, 196, 1) 100%);
            display: flexbox;
        }
    </style>
</head>

<?php

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



?>

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
                <li class="nav-item">
                    <a class="nav-link" href="sair.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    // Consulta SQL para recuperar todos os produtos
    $sql = "SELECT id_produto, nome, preco FROM produtos";
    $resultado = $conn->query($sql);
    // Verifica se há resultados
    if ($resultado->num_rows > 0) {
        // Loop pelos resultados e exibir cada produto
        while ($linha = $resultado->fetch_assoc()) {

            //retorna o primeiro produto 
            echo '<div class="container mt-2">';
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $linha["nome"] . '</h5>';
            echo '<p class="card-text">Preço: R$' . $linha["preco"] . '</p>';
            echo '<button class="btn btn-primary btn-block add-to-cart-btn" data-id_produto="' . $linha["id_produto"] . '">';
            echo '<i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho <span class="badge badge-light">0</span>';
            echo '</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="card-body">';
        echo '<h5 class="text-center">Nenhum produto encontrado.</h5>';
        echo '</div>';


    } // Fecha a conexão com o banco de dados $conexao->close();
    ?>
    <!-- Bootstrap JavaScript (opcional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- jQuery (necessário para Bootstrap e AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Font Awesome (necessário para os ícones) -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        $(document).ready(function () {
            // Variável para armazenar os produtos no carrinho
            var cartItems = {};

            // Evento para adicionar um produto ao carrinho
            $(".add-to-cart-btn").click(function () {
                var productId = $(this).data("id_produto");
                if (cartItems[productId]) {
                    cartItems[productId]++;
                } else {
                    cartItems[productId] = 1;
                }
                updateCartIcon(productId, cartItems[productId]);
                updateTotal();
            });

            // Evento para atualizar o ícone de contagem de produtos adicionados
            function updateCartIcon(productId, quantity) {
                $(".add-to-cart-btn[data-id_produto='" + productId + "'] .badge").text(quantity);
                $(".remove-from-cart-btn[data-id_produto='" + productId + "']").removeClass("d-none");
            }

            // Evento para atualizar o total dos produtos
            function updateTotal() {
                var total = 0;
                $(".add-to-cart-btn").each(function () {
                    var productId = $(this).data("id_produto");
                    var quantity = cartItems[productId] || 0;
                    var price = parseFloat($(this).closest(".card-body").find(".card-text:last").text().replace("Preço: R$", "").replace(",", "."));
                    total += quantity * price;
                });
                $("#total").text("Total: R$" + total.toFixed(2));
            }
        });


    </script>
    <!-- //retorna o preco -->
    <div class="container mt-1">
        <div class="row">
            <div class="col-md-11">
                <p id="total">Total: R$0,00</p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
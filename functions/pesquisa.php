<?php
// Inclua o arquivo de conexão ao banco de dados
include 'conexao.php';

// Variável para armazenar os resultados
$resultados = "";

// Verifique se o formulário de pesquisa foi enviado e se há algum termo de busca
if (isset($_GET['searchTerm']) && !empty($_GET['searchTerm'])) {
    $searchTerm = $conn->real_escape_string($_GET['searchTerm']);

    // Escreva a consulta SQL para buscar os clientes e seus veículos
    $sql = "SELECT clientes.nome_completo, clientes.cpf, veiculos.tip_veiculo, veiculos.marca, veiculos.modelo, veiculos.placa
            FROM clientes
            INNER JOIN veiculos ON clientes.id = veiculos.id_cliente
            WHERE clientes.nome_completo LIKE '%$searchTerm%' OR clientes.cpf LIKE '%$searchTerm%'";

    // Execute a consulta e verifique se houve algum erro
    $result = $conn->query($sql);

    if ($result === false) {
        $resultados = "Erro ao executar a consulta: " . $conn->error;
    } else {
        // Verifique se há resultados
        if ($result->num_rows > 0) {
            // Comece a criar a tabela HTML para os resultados
            $resultados .= "<table class='table table-bordered table-striped table-hover'>";
            $resultados .= "<thead><tr><th>Nome do Cliente</th><th>CPF</th><th>Tipo de Veículo</th><th>Marca</th><th>Modelo</th><th>Placa</th></tr></thead>";
            $resultados .= "<tbody>";

            // Percorra cada linha do resultado
            while ($row = $result->fetch_assoc()) {
                $resultados .= "<tr>";
                $resultados .= "<td>" . $row['nome_completo'] . "</td>";
                $resultados .= "<td>" . $row['cpf'] . "</td>";
                $resultados .= "<td>" . $row['tip_veiculo'] . "</td>";
                $resultados .= "<td>" . $row['marca'] . "</td>";
                $resultados .= "<td>" . $row['modelo'] . "</td>";
                $resultados .= "<td>" . $row['placa'] . "</td>";
                $resultados .= "</tr>";
            }

            $resultados .= "</tbody></table>";
        } else {
            $resultados = "<p class='no-result'>Nenhum cliente encontrado.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pesquisa de Clientes</title>

    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../assets/css/pesquisa.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet"/>

    <!-- Link do Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Formulário de busca -->
    <div class="container mt-5">
        <h2 class="text-center">Buscar Cliente</h2>
        <form action="pesquisa.php" method="GET" class="mb-5">
            <div class="form-group">
                <label for="searchTerm">Nome ou CPF do Cliente</label>
                <input type="text" class="form-control" id="searchTerm" name="searchTerm" placeholder="Digite o nome ou CPF" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Buscar</button>
        </form>
    </div>

    <!-- Exibição dos resultados -->
    <div class="table-container">
        <?php
        // Exiba os resultados da pesquisa, se houver
        echo $resultados;
        ?>
    </div>

    <!-- Bootstrap JS e jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

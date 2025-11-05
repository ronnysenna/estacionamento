<?php
// Arquivo para inserir dados de teste no banco
include 'conexao.php';

echo "<h2>Inserindo Dados de Teste</h2>";

// Dados de teste
$clientes_teste = [
    ['JOÃO SILVA', '12345678901'],
    ['MARIA SANTOS', '98765432100'],
    ['PEDRO OLIVEIRA', '11111111111']
];

$veiculos_teste = [
    // Para João Silva (cliente 1)
    [1, 'CARRO', 'TOYOTA', 'COROLLA', 'ABC1234'],
    [1, 'MOTO', 'HONDA', 'CB600F', 'MOT5678'],
    
    // Para Maria Santos (cliente 2)
    [2, 'CARRO', 'FORD', 'FIESTA', 'DEF5678'],
    
    // Para Pedro Oliveira (cliente 3)
    [3, 'CAMINHAO', 'VOLVO', 'FH540', 'CAM9999'],
    [3, 'CARRO', 'CHEVROLET', 'ONIX', 'GHI9012']
];

// Inserir clientes
foreach ($clientes_teste as $index => $cliente) {
    $nome = $cliente[0];
    $cpf = $cliente[1];
    
    // Verificar se já existe
    $check = $conn->query("SELECT id FROM clientes WHERE cpf = '$cpf'");
    if ($check && $check->num_rows == 0) {
        $sql = "INSERT INTO clientes (nome_completo, cpf) VALUES ('$nome', '$cpf')";
        if ($conn->query($sql)) {
            echo "<p>✅ Cliente '$nome' inserido com sucesso!</p>";
        } else {
            echo "<p>❌ Erro ao inserir cliente '$nome': " . $conn->error . "</p>";
        }
    } else {
        echo "<p>ℹ️ Cliente '$nome' já existe no banco.</p>";
    }
}

// Buscar IDs reais dos clientes
$clientes_ids = [];
foreach ($clientes_teste as $cliente) {
    $cpf = $cliente[1];
    $result = $conn->query("SELECT id FROM clientes WHERE cpf = '$cpf'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $clientes_ids[] = $row['id'];
    }
}

// Inserir veículos
foreach ($veiculos_teste as $index => $veiculo) {
    $cliente_index = $veiculo[0] - 1; // Converter para índice do array
    if (isset($clientes_ids[$cliente_index])) {
        $id_cliente = $clientes_ids[$cliente_index];
        $tip_veiculo = $veiculo[1];
        $marca = $veiculo[2];
        $modelo = $veiculo[3];
        $placa = $veiculo[4];
        
        // Verificar se já existe
        $check = $conn->query("SELECT id FROM veiculos WHERE placa = '$placa'");
        if ($check && $check->num_rows == 0) {
            $sql = "INSERT INTO veiculos (id_cliente, tip_veiculo, marca, modelo, placa) 
                    VALUES ($id_cliente, '$tip_veiculo', '$marca', '$modelo', '$placa')";
            if ($conn->query($sql)) {
                echo "<p>✅ Veículo '$marca $modelo' ($placa) inserido com sucesso!</p>";
            } else {
                echo "<p>❌ Erro ao inserir veículo '$marca $modelo': " . $conn->error . "</p>";
            }
        } else {
            echo "<p>ℹ️ Veículo com placa '$placa' já existe no banco.</p>";
        }
    }
}

echo "<hr>";
echo "<h3>Resumo do Banco:</h3>";

// Mostrar totais
$result_clientes = $conn->query("SELECT COUNT(*) as total FROM clientes");
$result_veiculos = $conn->query("SELECT COUNT(*) as total FROM veiculos");

if ($result_clientes) {
    $row = $result_clientes->fetch_assoc();
    echo "<p>📊 Total de clientes: " . $row['total'] . "</p>";
}

if ($result_veiculos) {
    $row = $result_veiculos->fetch_assoc();
    echo "<p>📊 Total de veículos: " . $row['total'] . "</p>";
}

echo "<div class='mt-4'>";
echo "<a href='pesquisa.php' class='btn btn-primary'>🔍 Ir para Pesquisa</a> ";
echo "<a href='../home.html' class='btn btn-secondary'>🏠 Voltar à Home</a>";
echo "</div>";

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dados de Teste</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        .btn { margin: 5px; }
    </style>
</head>
<body></body>
</html>

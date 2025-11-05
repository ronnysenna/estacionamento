<?php
// Ativar exibição de erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclua o arquivo de conexão ao banco de dados
include 'conexao.php';

$mensagem = "";
$cliente = null;
$veiculos = [];

// Verificar se foi passado um ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cliente_id = (int)$_GET['id'];
    
    // Buscar dados do cliente
    $sql_cliente = "SELECT * FROM clientes WHERE id = $cliente_id";
    $result_cliente = $conn->query($sql_cliente);
    
    if ($result_cliente && $result_cliente->num_rows > 0) {
        $cliente = $result_cliente->fetch_assoc();
        
        // Buscar veículos do cliente
        $sql_veiculos = "SELECT * FROM veiculos WHERE id_cliente = $cliente_id";
        $result_veiculos = $conn->query($sql_veiculos);
        
        if ($result_veiculos && $result_veiculos->num_rows > 0) {
            while ($veiculo = $result_veiculos->fetch_assoc()) {
                $veiculos[] = $veiculo;
            }
        }
    } else {
        $mensagem = "Cliente não encontrado!";
    }
} else {
    $mensagem = "ID do cliente não fornecido!";
}

// Processar formulário de atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente_id'])) {
    $cliente_id = (int)$_POST['cliente_id'];
    $nome_completo = strtoupper($conn->real_escape_string($_POST['nome_completo']));
    $cpf = strtoupper($conn->real_escape_string($_POST['cpf']));
    
    // Atualizar cliente
    $sql_update_cliente = "UPDATE clientes SET nome_completo = '$nome_completo', cpf = '$cpf' WHERE id = $cliente_id";
    
    if ($conn->query($sql_update_cliente) === TRUE) {
        // Atualizar veículos
        $tip_veiculo = $_POST['tip_veiculo'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $placa = $_POST['placa'];
        $veiculo_ids = $_POST['veiculo_id'];
        
        $sucesso_veiculos = true;
        
        for ($i = 0; $i < count($tip_veiculo); $i++) {
            if (isset($veiculo_ids[$i]) && !empty($veiculo_ids[$i])) {
                // Atualizar veículo existente
                $veiculo_id = (int)$veiculo_ids[$i];
                $tip_veiculo_atual = strtoupper($conn->real_escape_string($tip_veiculo[$i]));
                $marca_atual = strtoupper($conn->real_escape_string($marca[$i]));
                $modelo_atual = strtoupper($conn->real_escape_string($modelo[$i]));
                $placa_atual = strtoupper($conn->real_escape_string($placa[$i]));
                
                $sql_update_veiculo = "UPDATE veiculos SET 
                                      tip_veiculo = '$tip_veiculo_atual',
                                      marca = '$marca_atual',
                                      modelo = '$modelo_atual',
                                      placa = '$placa_atual'
                                      WHERE id = $veiculo_id AND id_cliente = $cliente_id";
                
                if ($conn->query($sql_update_veiculo) !== TRUE) {
                    $sucesso_veiculos = false;
                    break;
                }
            } else {
                // Inserir novo veículo
                $tip_veiculo_atual = strtoupper($conn->real_escape_string($tip_veiculo[$i]));
                $marca_atual = strtoupper($conn->real_escape_string($marca[$i]));
                $modelo_atual = strtoupper($conn->real_escape_string($modelo[$i]));
                $placa_atual = strtoupper($conn->real_escape_string($placa[$i]));
                
                $sql_insert_veiculo = "INSERT INTO veiculos (id_cliente, tip_veiculo, marca, modelo, placa)
                                      VALUES ($cliente_id, '$tip_veiculo_atual', '$marca_atual', '$modelo_atual', '$placa_atual')";
                
                if ($conn->query($sql_insert_veiculo) !== TRUE) {
                    $sucesso_veiculos = false;
                    break;
                }
            }
        }
        
        if ($sucesso_veiculos) {
            echo "<script>
                    alert('Cliente atualizado com sucesso!');
                    window.location.href = 'pesquisa.php';
                  </script>";
        } else {
            $mensagem = "Erro ao atualizar veículos: " . $conn->error;
        }
    } else {
        $mensagem = "Erro ao atualizar cliente: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Cliente</title>

    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Editar Cliente e Veículos</h2>
    
    <?php if (!empty($mensagem)): ?>
        <div class="alert alert-danger"><?= $mensagem ?></div>
    <?php endif; ?>
    
    <?php if ($cliente): ?>
    <form method="POST">
        <input type="hidden" name="cliente_id" value="<?= $cliente['id'] ?>">
        
        <!-- Campos para o cliente -->
        <div class="form-group">
            <label for="nome_completo">Nome Completo do Cliente</label>
            <input type="text" class="form-control" id="nome_completo" name="nome_completo" 
                   value="<?= htmlspecialchars($cliente['nome_completo']) ?>" required>
        </div>
        <div class="form-group">
            <label for="cpf">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" 
                   value="<?= htmlspecialchars($cliente['cpf']) ?>" required>
        </div>

        <!-- Seção para veículos -->
        <div id="veiculos-section">
            <h4>Veículos</h4>
            <?php foreach ($veiculos as $index => $veiculo): ?>
            <div class="veiculo">
                <?php if ($index > 0): ?><hr><?php endif; ?>
                <input type="hidden" name="veiculo_id[]" value="<?= $veiculo['id'] ?>">
                <div class="form-group">
                    <label>Tipo de Veículo</label>
                    <input type="text" class="form-control" name="tip_veiculo[]" 
                           value="<?= htmlspecialchars($veiculo['tip_veiculo']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Marca</label>
                    <input type="text" class="form-control" name="marca[]" 
                           value="<?= htmlspecialchars($veiculo['marca']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <input type="text" class="form-control" name="modelo[]" 
                           value="<?= htmlspecialchars($veiculo['modelo']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Placa</label>
                    <input type="text" class="form-control" name="placa[]" 
                           value="<?= htmlspecialchars($veiculo['placa']) ?>" required>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Botão para adicionar mais veículos -->
        <button type="button" class="btn btn-secondary" id="add-veiculo-btn">Adicionar Veículo</button>

        <!-- Botões de ação -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success">💾 Salvar Alterações</button>
            <a href="pesquisa.php" class="btn btn-secondary">↩️ Voltar</a>
        </div>
    </form>
    <?php endif; ?>
</div>

<script>
document.getElementById('add-veiculo-btn').addEventListener('click', function() {
    var veiculoSection = document.getElementById('veiculos-section');
    var newVeiculo = document.createElement('div');
    newVeiculo.classList.add('veiculo');
    newVeiculo.innerHTML = `
        <hr>
        <input type="hidden" name="veiculo_id[]" value="">
        <div class="form-group">
            <label>Tipo de Veículo</label>
            <input type="text" class="form-control" name="tip_veiculo[]" placeholder="Carro, Moto, etc." required>
        </div>
        <div class="form-group">
            <label>Marca</label>
            <input type="text" class="form-control" name="marca[]" placeholder="Digite a marca do veículo" required>
        </div>
        <div class="form-group">
            <label>Modelo</label>
            <input type="text" class="form-control" name="modelo[]" placeholder="Digite o modelo do veículo" required>
        </div>
        <div class="form-group">
            <label>Placa</label>
            <input type="text" class="form-control" name="placa[]" placeholder="Digite a placa do veículo" required>
        </div>`;
    veiculoSection.appendChild(newVeiculo);
});
</script>

</body>
</html>

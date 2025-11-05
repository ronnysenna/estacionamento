<?php
// Ativar exibição de erros para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclua o arquivo de conexão ao banco de dados
include 'conexao.php';

$mensagem = "";
$sucesso = false;

// Verificar se foi passado um ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $cliente_id = (int)$_GET['id'];
    
    // Buscar dados do cliente antes de deletar (para confirmar)
    $sql_cliente = "SELECT nome_completo FROM clientes WHERE id = $cliente_id";
    $result_cliente = $conn->query($sql_cliente);
    
    if ($result_cliente && $result_cliente->num_rows > 0) {
        $cliente = $result_cliente->fetch_assoc();
        
        // Iniciar transação para garantir integridade
        $conn->begin_transaction();
        
        try {
            // Deletar primeiro os veículos (devido à chave estrangeira)
            $sql_delete_veiculos = "DELETE FROM veiculos WHERE id_cliente = $cliente_id";
            if (!$conn->query($sql_delete_veiculos)) {
                throw new Exception("Erro ao deletar veículos: " . $conn->error);
            }
            
            // Depois deletar o cliente
            $sql_delete_cliente = "DELETE FROM clientes WHERE id = $cliente_id";
            if (!$conn->query($sql_delete_cliente)) {
                throw new Exception("Erro ao deletar cliente: " . $conn->error);
            }
            
            // Se chegou até aqui, commit na transação
            $conn->commit();
            $mensagem = "Cliente '" . $cliente['nome_completo'] . "' e seus veículos foram excluídos com sucesso!";
            $sucesso = true;
            
        } catch (Exception $e) {
            // Rollback em caso de erro
            $conn->rollback();
            $mensagem = $e->getMessage();
        }
        
    } else {
        $mensagem = "Cliente não encontrado!";
    }
} else {
    $mensagem = "ID do cliente não fornecido!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Deletar Cliente</title>

    <link rel="stylesheet" href="../assets/css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="text-center">
        <h2>Resultado da Exclusão</h2>
        
        <?php if ($sucesso): ?>
            <div class="alert alert-success">
                <h4>✅ Sucesso!</h4>
                <p><?= $mensagem ?></p>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <h4>❌ Erro!</h4>
                <p><?= $mensagem ?></p>
            </div>
        <?php endif; ?>
        
        <div class="mt-4">
            <a href="pesquisa.php" class="btn btn-primary">↩️ Voltar à Pesquisa</a>
            <a href="../home.html" class="btn btn-secondary">🏠 Ir para Home</a>
        </div>
    </div>
</div>

<?php if ($sucesso): ?>
<script>
    // Redirecionar automaticamente após 3 segundos
    setTimeout(function() {
        window.location.href = 'pesquisa.php';
    }, 3000);
</script>
<?php endif; ?>

</body>
</html>

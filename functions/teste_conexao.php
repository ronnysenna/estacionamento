<?php
// Incluir o arquivo de conexão
include 'conexao.php';

echo "<h2>Teste de Conexão com o Banco de Dados</h2>";

// Verificar se a conexão foi estabelecida
if ($conn) {
    echo "<p style='color: green;'>✅ Conexão estabelecida com sucesso!</p>";
    
    // Testar se as tabelas existem
    $tabelas = ['clientes', 'veiculos'];
    
    foreach ($tabelas as $tabela) {
        $result = $conn->query("SHOW TABLES LIKE '$tabela'");
        
        if ($result && $result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Tabela '$tabela' encontrada</p>";
            
            // Contar registros na tabela
            $count_result = $conn->query("SELECT COUNT(*) as total FROM $tabela");
            if ($count_result) {
                $row = $count_result->fetch_assoc();
                echo "<p>&nbsp;&nbsp;&nbsp;📊 Total de registros: " . $row['total'] . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Tabela '$tabela' não encontrada</p>";
        }
    }
    
    // Informações da conexão
    echo "<br><h3>Informações da Conexão:</h3>";
    echo "<p><strong>Host:</strong> " . $DB_HOST . "</p>";
    echo "<p><strong>Usuário:</strong> " . $DB_USER . "</p>";
    echo "<p><strong>Banco:</strong> " . $DB_NAME . "</p>";
    echo "<p><strong>Versão MySQL:</strong> " . $conn->server_info . "</p>";
    
} else {
    echo "<p style='color: red;'>❌ Falha na conexão!</p>";
}

$conn->close();
?>

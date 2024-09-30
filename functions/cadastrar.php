<?php
// Inclua o arquivo de conexão ao banco de dados
include 'conexao.php';

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar os dados do cliente
    $nome_completo = strtoupper($conn->real_escape_string($_POST['nome_completo']));
    $cpf = strtoupper($conn->real_escape_string($_POST['cpf']));

    // Inserir o cliente no banco de dados
    $sql_clientes = "INSERT INTO clientes (nome_completo, cpf) VALUES ('$nome_completo', '$cpf')";

    if ($conn->query($sql_clientes) === TRUE) {
        // Obter o ID do cliente recém-cadastrado
        $id_cliente = $conn->insert_id;

        // Capturar os dados dos veículos
        $tip_veiculo = $_POST['tip_veiculo'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $placa = $_POST['placa'];

        // Loop para inserir cada veículo no banco de dados
        for ($i = 0; $i < count($tip_veiculo); $i++) {
            $tip_veiculo_atual = strtoupper($conn->real_escape_string($tip_veiculo[$i]));
            $marca_atual = strtoupper($conn->real_escape_string($marca[$i]));
            $modelo_atual = strtoupper($conn->real_escape_string($modelo[$i]));
            $placa_atual = strtoupper($conn->real_escape_string($placa[$i]));

            $sql_veiculos = "INSERT INTO veiculos (id_cliente, tip_veiculo, marca, modelo, placa)
                             VALUES ('$id_cliente', '$tip_veiculo_atual', '$marca_atual', '$modelo_atual', '$placa_atual')";

            if ($conn->query($sql_veiculos) !== TRUE) {
                echo "Erro ao inserir veículo: " . $conn->error;
                exit;
            }
        }

        // Mensagem de sucesso e redirecionamento
        echo "
        <script>
            alert('Cadastro realizado com sucesso!');
            setTimeout(function() {
                window.location.href = '../home.html'; // Substitua por 'index.php' se for o arquivo correto
            }, 2000);
        </script>
        ";
    } else {
        echo "Erro ao cadastrar cliente: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>

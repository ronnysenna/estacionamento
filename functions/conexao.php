<?php
$DB_HOST = "usrv1660.hstgr.io";  // Nome do servidor, geralmente 'localhost'
$DB_USER = "u139114102_estacionamento";         // Nome de usuário do MySQL
$DB_PASSWORD = "@Ideal2015net";         // Senha do MySQL
$DB_NAME = "u139114102_estacionamento";  // Nome do banco de dados onde a tabela 'produtos' está

// Criando a conexão
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

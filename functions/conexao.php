<?php
$DB_HOST = "localhost";  // Nome do servidor, geralmente 'localhost'
$DB_USER = "seuusuario";         // Nome de usuário do MySQL
$DB_PASSWORD = "suasenha";         // Senha do MySQL
$DB_NAME = "nomedobanco";  // Nome do banco de dados onde a tabela 'produtos' está

// Criando a conexão
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

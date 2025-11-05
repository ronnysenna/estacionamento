<?php
// Função para carregar variáveis do .env
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Ignorar comentários
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
    return true;
}

// Carregar o arquivo .env
$envPath = dirname(__DIR__) . '/.env';
loadEnv($envPath);

// Configurações do banco de dados a partir do .env
$DB_HOST = getenv('DB_HOST') ?: 'localhost';
$DB_USER = getenv('DB_USER') ?: '';
$DB_PASSWORD = getenv('DB_PASSWORD') ?: '';
$DB_NAME = getenv('DB_NAME') ?: '';

// Verificar se as variáveis foram carregadas
if (empty($DB_HOST) || empty($DB_USER) || empty($DB_NAME)) {
    die("Erro: Variáveis de ambiente do banco de dados não foram carregadas corretamente.");
}

// Criando a conexão
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

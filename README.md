
# Sistema de Cadastro de Clientes e Veículos para Estacionamento

Este projeto é um sistema simples de cadastro de clientes e veículos para um estacionamento. A aplicação permite o cadastro de múltiplos veículos para cada cliente e a busca por clientes por nome ou CPF.

## Funcionalidades

- **Cadastro de Clientes**: O sistema permite cadastrar informações de clientes, como nome, CPF e outros dados pessoais.
- **Cadastro de Veículos**: Para cada cliente, é possível associar vários veículos, incluindo informações como placa, marca, modelo e ano.
- **Busca por Clientes**: A aplicação oferece uma funcionalidade de pesquisa por nome ou CPF para facilitar a localização de clientes no sistema.
- **Gerenciamento de Veículos**: A aplicação permite visualizar e gerenciar todos os veículos associados a um cliente específico.


## Demonstração
 
  
  <p><a href="http://instalacao-forms.free.nf/estac/home.html">🔗 Veja o projeto clicando aqui !</p></a>

  
## 🛠 Tecnnologias Utilizadas


  <p><a href="https://skillicons.dev"><img src="https://skillicons.dev/icons?i=html,css,js,php,mysql" /></a>


## 🔗 Links
[![portfolio](https://img.shields.io/badge/my_portfolio-333?style=for-the-badge&logo=ko-fi&logoColor=white)](https://ronnysenna.github.io/)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/ronnysenna/)
[![Instagram](https://img.shields.io/badge/-Instagram-%23E4405F?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/ronnysenna/?hl=pt_BR)


## Imagens do Sistema

### Tela Inicial
![Tela Inicial](https://files.oaiusercontent.com/file-3uSxpdKRfHIcJDH36plBHXAL?se=2024-09-30T13%3A54%3A04Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D299%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Dimage.png&sig=U2/Onkdd4CoR1l91FpkOQnxPbQxk7/mM1zoJ0maNec4%3D)

### Tela de Cadastro de Cliente e Veículos
![Tela de Cadastro de Cliente](https://files.oaiusercontent.com/file-B5A9OibrXpzaanrungZduijS?se=2024-09-30T13%3A54%3A04Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D299%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Dimage.png&sig=wDib8jS4hhSpMXj/FuiIY1JbcbOsD728FMYkTY%2BmG5g%3D)

### Tela de Busca de Clientes
![Tela de Busca de Cliente](https://files.oaiusercontent.com/file-sjqMnSMGBSetikzLEFa2CBTm?se=2024-09-30T13%3A54%3A04Z&sp=r&sv=2024-08-04&sr=b&rscc=max-age%3D299%2C%20immutable%2C%20private&rscd=attachment%3B%20filename%3Dimage.png&sig=F2M9gYPs6bJ2lZzslekDCY5MBI3ZGGRfmbNB1eEKY20%3D)

## Conexão com o Banco de Dados (PHP)

A aplicação utiliza PHP para se conectar ao banco de dados MySQL. O código a seguir demonstra como a conexão é feita:

```php
<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; // ou o servidor onde o banco está hospedado
$username = "root";        // nome de usuário do banco de dados
$password = "";            // senha do banco de dados
$dbname = "estacionamento"; // nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

echo "Conexão bem-sucedida!";
?>

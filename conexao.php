<?php
// Conexão com a base de dados MySQL criada pelo script dbcaduser.sql.
// Configuração padrão de desenvolvimento local do XAMPP: root sem senha.
// Em outros ambientes, altere o usuário e a senha conforme seu MySQL.
declare(strict_types=1);

$servidor = getenv('CADASTRO_DB_HOST') ?: '127.0.0.1';
$usuarioBanco = getenv('CADASTRO_DB_USER') ?: 'root';
$senhaBanco = getenv('CADASTRO_DB_PASSWORD') !== false ? getenv('CADASTRO_DB_PASSWORD') : '';
$nomeBanco = getenv('CADASTRO_DB_NAME') ?: 'DBCadUser';
$portaBanco = (int) (getenv('CADASTRO_DB_PORT') ?: 3306);

// Mantém o comportamento de falha consistente entre as versões do PHP 7.4+.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// A variável $conexao fica disponível para cadastrar.php.
$conexao = mysqli_connect($servidor, $usuarioBanco, $senhaBanco, $nomeBanco, $portaBanco);
mysqli_set_charset($conexao, 'utf8mb4');

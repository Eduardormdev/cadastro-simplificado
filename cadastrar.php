<?php
// Recebe o formulário, valida os campos e grava o cadastro no MySQL.
declare(strict_types=1);
session_start();

function retornar(string $tipo, string $texto, string $nome = '', string $email = ''): void
{
    $_SESSION['mensagem'] = ['tipo' => $tipo, 'texto' => $texto];
    $_SESSION['valores'] = ['nome' => $nome, 'email' => $email];
    header('Location: index.php', true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php', true, 303);
    exit;
}

// Verifica se o envio partiu do formulário desta aplicação (proteção CSRF).
$tokenEnviado = $_POST['csrf_token'] ?? null;
$tokenSalvo = $_SESSION['csrf_token'] ?? null;
if (!is_string($tokenEnviado) || !is_string($tokenSalvo) || !hash_equals($tokenSalvo, $tokenEnviado)) {
    retornar('erro', 'Sua sessão expirou. Atualize a página e tente novamente.');
}

$nomeOriginal = $_POST['nome'] ?? '';
$emailOriginal = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!is_string($nomeOriginal) || !is_string($emailOriginal) || !is_string($senha)) {
    retornar('erro', 'Os dados enviados são inválidos.');
}

$nome = trim($nomeOriginal);
$email = trim($emailOriginal);

if (!mb_check_encoding($nome, 'UTF-8') || mb_strlen($nome, 'UTF-8') < 2 || mb_strlen($nome, 'UTF-8') > 120) {
    retornar('erro', 'Informe um nome com 2 a 120 caracteres.', $nome, $email);
}

if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    retornar('erro', 'Digite um endereço de e-mail válido.', $nome, $email);
}

if (!mb_check_encoding($senha, 'UTF-8') || strpos($senha, chr(0)) !== false || mb_strlen($senha, 'UTF-8') < 8 || strlen($senha) > 72) {
    retornar('erro', 'Use pelo menos 8 caracteres e no máximo 72 bytes na senha. Letras acentuadas podem ocupar mais de um byte.', $nome, $email);
}

// password_hash usa um algoritmo de hash com sal, mais adequado para senhas
// que criptografia reversível. Não armazenamos a senha original.
try {
    $senhaProtegida = password_hash($senha, PASSWORD_DEFAULT);
    if ($senhaProtegida === false) {
        retornar('erro', 'Não foi possível processar a senha. Tente novamente.', $nome, $email);
    }

    require __DIR__ . '/conexao.php';

    // Prepared statement evita que dados informados no formulário alterem o SQL.
    $comando = mysqli_prepare($conexao, 'INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)');
    mysqli_stmt_bind_param($comando, 'sss', $nome, $email, $senhaProtegida);
    mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    mysqli_close($conexao);

    // Renova o token após cadastrar com sucesso e impede reenvio ao atualizar.
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    retornar('sucesso', 'Cadastro realizado com sucesso! Seus dados foram registrados no banco.');
} catch (mysqli_sql_exception $erro) {
    error_log('Erro no cadastro de usuário: ' . $erro->getMessage());
    if ((int) $erro->getCode() === 1062) {
        retornar('erro', 'Este endereço de e-mail já está cadastrado.', $nome, $email);
    }
    retornar('erro', 'Não foi possível concluir o cadastro. Verifique o MySQL e tente novamente.', $nome, $email);
} catch (Throwable $erro) {
    error_log('Erro inesperado no cadastro de usuário: ' . $erro->getMessage());
    retornar('erro', 'Ocorreu um erro ao processar seu cadastro. Tente novamente.', $nome, $email);
}

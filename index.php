<?php
// Aula prática: formulário de cadastro (PHP + MySQL).
// Este formulário envia os dados para cadastrar.php, que faz a validação definitiva.
declare(strict_types=1);
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$mensagem = $_SESSION['mensagem'] ?? null;
$valores = $_SESSION['valores'] ?? ['nome' => '', 'email' => ''];
unset($_SESSION['mensagem'], $_SESSION['valores']);

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro de usuário</title>
  <link rel="stylesheet" href="css/formulario.css">
</head>
<body>
  <main class="cadastro">
    <h1>Cadastro de usuário</h1>
    <p>Preencha os campos abaixo para se cadastrar.</p>

    <?php if (is_array($mensagem) && isset($mensagem['texto'], $mensagem['tipo'])): ?>
      <p class="mensagem <?= $mensagem['tipo'] === 'sucesso' ? 'sucesso' : 'erro' ?>"
         role="<?= $mensagem['tipo'] === 'sucesso' ? 'status' : 'alert' ?>">
        <?= escapar((string) $mensagem['texto']) ?>
      </p>
    <?php endif; ?>

    <form action="cadastrar.php" method="post">
      <input type="hidden" name="csrf_token" value="<?= escapar($_SESSION['csrf_token']) ?>">

      <label for="nome">Nome completo</label>
      <input id="nome" name="nome" type="text"
             value="<?= escapar(is_string($valores['nome'] ?? null) ? $valores['nome'] : '') ?>"
             minlength="2" maxlength="120" autocomplete="name" required>

      <label for="email">E-mail</label>
      <input id="email" name="email" type="email"
             value="<?= escapar(is_string($valores['email'] ?? null) ? $valores['email'] : '') ?>"
             maxlength="190" autocomplete="email" required>

      <label for="senha">Senha</label>
      <input id="senha" name="senha" type="password"
             minlength="8" maxlength="72" autocomplete="new-password" aria-describedby="ajuda-senha" required>
      <small id="ajuda-senha">Use pelo menos 8 caracteres e no máximo 72 bytes. Caracteres acentuados podem ocupar mais de um byte.</small>

      <button type="submit">Cadastrar</button>
    </form>
  </main>
</body>
</html>

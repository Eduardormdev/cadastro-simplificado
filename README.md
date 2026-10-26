# Cadastro simplificado de usuários

Repositório público: https://github.com/Eduardormdev/cadastro-simplificado

Projeto acadêmico de cadastro com PHP, MySQL e HTML. O formulário recebe nome, e-mail e senha, valida os dados no navegador e no servidor e grava os registros no banco de dados.

## Recursos

- Validação de nome, e-mail e senha
- Proteção contra envio CSRF
- Senha armazenada com `password_hash`
- Gravação com instrução preparada do MySQLi
- Avisos de sucesso e erro no formulário
- Interface simples em HTML e CSS

## Arquivos

- `index.php`: formulário e mensagens
- `cadastrar.php`: validação e gravação do cadastro
- `conexao.php`: configuração da conexão MySQLi
- `dbcaduser.sql`: criação do banco `DBCadUser` e da tabela `usuario`
- `css/formulario.css`: estilos do formulário

## Como executar com XAMPP

1. Copie a pasta `cadastro-simplificado` para `C:\xampp\htdocs`.
2. Inicie os serviços Apache e MySQL no painel do XAMPP.
3. Acesse o phpMyAdmin e importe o arquivo `dbcaduser.sql`.
4. Abra `http://localhost/cadastro-simplificado/` no navegador.

Por padrão, a conexão usa a configuração local do XAMPP. Para outro ambiente, defina as variáveis `CADASTRO_DB_HOST`, `CADASTRO_DB_USER`, `CADASTRO_DB_PASSWORD`, `CADASTRO_DB_NAME` e `CADASTRO_DB_PORT`.

## Observação

Este projeto foi desenvolvido para fins acadêmicos e execução local. O código-fonte não inclui dados de usuários nem credenciais de banco.

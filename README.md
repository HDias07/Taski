# Taski

Sistema web simples de gerenciamento de tarefas desenvolvido em PHP com MySQL.

## Sobre o projeto

O Taski foi criado como projeto acadêmico com o objetivo de permitir o cadastro e a organização de tarefas em uma interface simples e prática.

## Funcionalidades

- Login de usuário
- Cadastro de tarefas
- Listagem de tarefas
- Edição de tarefas
- Alteração de status entre pendente e concluído
- Exclusão de tarefas

## Tecnologias utilizadas

- PHP
- MySQL
- HTML
- CSS

## Estrutura principal

- `index.php`: tela de login
- `login.php`: validação de acesso
- `home.php`: painel principal com cadastro e listagem de tarefas
- `editar_tarefa.php`: edição de tarefas
- `conexao.php`: conexão com o banco de dados
- `banco.sql`: estrutura inicial do banco

## Como executar

1. Instale um ambiente local com PHP e MySQL, como o XAMPP.
2. Coloque a pasta do projeto dentro de `htdocs`.
3. Crie o banco de dados `sistema_usuarios`.
4. Importe ou execute os comandos SQL necessários do arquivo `banco.sql`.
5. Acesse o projeto pelo navegador.

## Observação

Este projeto foi desenvolvido para fins de estudo e pode receber melhorias futuras em segurança, organização de código e tratamento de dados.

<?php
session_start();
include('../conexao.php');

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Goi Delícias</title>
    <link rel="icon" href="../favicon.png" type="image/png">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('../painel-cliente/img/logo.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
        button {
            padding: 10px 20px;
            background: #d2691e;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #b55315;
        }
        .actions {
            margin-top: 15px;
        }
        .actions a {
            color: #d2691e;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            font-family: Arial, sans-serif;
            font-size: 16px;
            animation: fadeOut 4s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; top: 0; }
        }
    </style>
</head>
<body>
    <?php
    if (isset($_SESSION['mensagem'])) {
        echo "<div class='alert'>" . $_SESSION['mensagem'] . "</div>";
        unset($_SESSION['mensagem']);
    }
    ?>
    <div class="container">
        <h2>Cadastro do Cliente</h2>
        <form action="cadastro_processa.php" method="POST">
            <input type="text" name="nome" placeholder="Nome completo" required><br>
            <input type="email" name="email" placeholder="E-mail" required><br>
            <input type="text" name="telefone" placeholder="Telefone (com DDD)" required><br>
            <input type="text" name="endereco" placeholder="Endereço completo" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Cadastrar</button>
        </form>
        <div class="actions">
            <span>Já tem conta?</span>
            <a href="login.php">Fazer login</a>
        </div>
    </div>
</body>
</html>

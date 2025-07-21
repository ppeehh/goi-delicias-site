<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../conexao.php');

// Redireciona se já estiver logado
if (isset($_SESSION['cliente_id'])) {
    header("Location: index.php");
    exit;
}

// Processa o login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $cliente = $resultado->fetch_assoc();
        if (password_verify($senha, $cliente['senha'])) {
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nome'] = $cliente['nome'];
            $_SESSION['cliente_email'] = $cliente['email'];

            header("Location: index.php");
            exit;
        }
    }

    $erro = "E-mail ou senha inválidos.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Goi Delícias</title>
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
            width: 320px;
            text-align: center;
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
            color: #d2691e;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            padding: 10px 20px;
            background: #d2691e;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #b55315;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .register {
            margin-top: 15px;
        }
        .register a {
            color: #d2691e;
            text-decoration: none;
        }
        .register a:hover {
            text-decoration: underline;
        }
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            font-family: Arial, sans-serif;
            font-size: 16px;
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            85% { opacity: 1; }
            100% { opacity: 0; top: 0; }
        }
        .voltar-btn {
            position: absolute;
            top: 10px;
            left: 10px;
        }
        .voltar-btn a button {
            padding: 6px 12px;
            background: #ccc;
            color: #333;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .voltar-btn a button:hover {
            background: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Botão Voltar -->
        <div class="voltar-btn">
            <a href="http://localhost/goi_delicias/">
                <button type="button">← Voltar</button>
            </a>
        </div>

        <h2>Login do Cliente</h2>

        <!-- Mensagem de erro (login inválido) -->
        <?php if (isset($erro)) echo "<p class='error'>$erro</p>"; ?>

        <!-- Mensagem de logout (vinda do logout.php) -->
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<div class='alert'>" . $_SESSION['mensagem'] . "</div>";
            unset($_SESSION['mensagem']);
        }
        ?>

        <form method="POST">
            <input type="email" name="email" placeholder="E-mail" required><br>
            <input type="password" name="senha" placeholder="Senha" required><br>
            <button type="submit">Entrar</button>
        </form>

        <div class="register">
            <p>Não tem cadastro? <a href="cadastro.php">Clique aqui</a></p>
        </div>

    </div>
</body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $usuario = $_POST['usuario'];
  $senha = hash('sha256', $_POST['senha']);

  $res = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'");
  if (mysqli_num_rows($res) == 1) {
    $_SESSION['adm_logado'] = true;
    header("Location: index.php");
    exit();
  } else {
    $erro = "Usuário ou senha inválidos.";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - ADM</title>
  <link rel="icon" href="../favicon.png" type="image/png">
  <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-image: url('../painel-cliente/img/logo.png'); /* mesmo fundo do cliente */
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
    .top-button {
        position: absolute;
        top: 10px;
        left: 10px;
    }
    .top-button a {
        text-decoration: none;
    }
    .top-button button {
        padding: 6px 12px;
        background: #ccc;
        color: #333;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .top-button button:hover {
        background: #aaa;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top-button">
      <a href="http://localhost/goi_delicias/">
        <button type="button">← Voltar</button>
      </a>
    </div>

    <h2>Login do Administrador</h2>
    
    <?php if (isset($erro)) echo "<div class='error'>$erro</div>"; ?>
    
    <form method="post">
      <input type="text" name="usuario" placeholder="Usuário" required><br>
      <input type="password" name="senha" placeholder="Senha" required><br>
      <button type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>

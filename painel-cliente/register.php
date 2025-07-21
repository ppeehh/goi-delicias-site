<?php
include('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO clientes (nome, telefone, email, senha, endereco) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $telefone, $email, $senha, $endereco);

    if ($stmt->execute()) {
        header("Location: login.php?msg=cadastro_ok");
        exit;
    } else {
        echo "Erro ao cadastrar.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Goi Delícias</title>
  <link rel="icon" href="../favicon.png" type="image/png">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      background: url('../painel-cliente/img/logo.png') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    h2 {
      text-align: center;
      color: #d2691e;
      margin-bottom: 20px;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #d2691e;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #b55315;
    }
    .voltar {
      margin-top: 15px;
      text-align: center;
    }
    .voltar a {
      color: #d2691e;
      text-decoration: none;
      font-size: 14px;
    }
    .voltar a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Cadastro do Cliente</h2>
    <form method="POST">
      <input type="text" name="nome" placeholder="Nome completo" required>
      <input type="text" name="telefone" placeholder="Telefone com DDD" required>
      <input type="email" name="email" placeholder="E-mail" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <textarea name="endereco" placeholder="Endereço completo" required rows="3"></textarea>
      <button type="submit">Cadastrar</button>
    </form>
    <div class="voltar">
      <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
    </div>
  </div>
</body>
</html>

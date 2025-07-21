<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../conexao.php');
if (!isset($_SESSION['adm_logado'])) {
  header("Location: login.php");
  exit();
}

?>

<a href="adicionar_prato.php">
    <button style="padding:10px 20px; background:#28a745; color:#fff; border:none; border-radius:6px; cursor:pointer;">
        + Adicionar Prato
    </button>
</a>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Administração - Goi Delícias</title>
  <link rel="icon" href="/goi_delicias/favicon.png?v=3" type="image/png">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .logout-btn {
      background-color: #d9534f;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .menu a {
      margin-right: 15px;
      text-decoration: none;
      color: #007BFF;
      font-weight: bold;
    }
    .pedido, .prato {
      margin-bottom: 10px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
    }
    .prato-actions a {
      margin-right: 10px;
      color: #333;
    }
  </style>
</head>
<body>

  <div class="top-bar">
    <h1>Administração - Goi Delícias</h1>
    <a href="logout.php" class="logout-btn">Sair</a>
  </div>

   <h2>Pratos Cadastrados</h2>
  <?php
  $res = mysqli_query($conn, "SELECT * FROM pratos ORDER BY id DESC");
  while($row = mysqli_fetch_assoc($res)) {
    echo "<div class='prato'>
            <strong>{$row['nome']}</strong> - R$ {$row['preco']} - Categoria: {$row['categoria']}<br>
            <img src='../painel-cliente/img/{$row['imagem']}' width='100'><br>
            <div class='prato-actions'>
              <a href='editar_prato.php?id={$row['id']}'>Editar</a>
              <a href='deletar_prato.php?id={$row['id']}' onclick='return confirm(\"Tem certeza que deseja deletar?\")'>Deletar</a>
            </div>
          </div>";
  }
  ?>

</body>
</html>

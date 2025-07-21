<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../conexao.php');

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Goi Delícias - Cardápio</title>
  <link rel="icon" href="/goi_delicias/favicon.png?v=3" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    .logout {
      text-align: right;
      margin-bottom: 10px;
    }
    .logout form {
      display: inline;
    }
    .logout button {
      background-color: #dc3545;
      padding: 6px 12px;
      font-size: 14px;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .logout button:hover {
      background-color: #c82333;
    }
    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .categoria {
      flex: 1 1 300px;
      max-width: 350px;
      border: 1px solid #ddd;
      padding: 15px;
      border-radius: 8px;
      background-color: #f9f9f9;
    }
    .categoria h2 {
      text-align: center;
      margin-bottom: 15px;
      color: #333;
    }
    .produto {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 1px solid #ccc;
      padding-bottom: 10px;
    }
    .produto img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .produto p {
      margin: 5px 0;
      font-weight: bold;
    }
    button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 7px 15px;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
    select {
      padding: 5px;
      margin-right: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .categoria {
        flex: 1 1 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Botão Sair -->
  <div class="logout">
    <form action="logout.php" method="post">
        <button type="submit">Sair</button>
    </form>
  </div>

  <h1>Bem-vindo à Goi Delícias - Cardápio</h1>
  
  <div class="container">
    <?php
      $categorias = ['doce', 'salgado', 'bebida'];

      foreach ($categorias as $cat) {
        echo "<div class='categoria'>";
        echo "<h2>" . ucfirst($cat) . "s</h2>";

        $res = mysqli_query($conn, "SELECT * FROM pratos WHERE categoria='$cat'");

        if (mysqli_num_rows($res) > 0) {
          while($row = mysqli_fetch_assoc($res)) {
            echo "<div class='produto'>";
            echo "<img src='../painel-cliente/img/{$row['imagem']}' alt='{$row['nome']}'>";
            echo "<p>{$row['nome']} - R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";

            echo "<form method='post' action='adicionar_carrinho.php'>";
            echo "<input type='hidden' name='id_prato' value='{$row['id']}'>";
            echo "<select name='quantidade'>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            echo "</select>";
            echo "<button type='submit'>Adicionar ao Carrinho</button>";
            echo "</form>";

            echo "</div>";
          }
        } else {
          echo "<p>Não há produtos nesta categoria.</p>";
        }

        echo "</div>";
      }
    ?>
  </div>

</body>
</html>

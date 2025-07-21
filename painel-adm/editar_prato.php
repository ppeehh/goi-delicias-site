<?php
include('../conexao.php');

if (!isset($_GET['id'])) {
  echo "ID do prato não informado.";
  exit;
}

$id = intval($_GET['id']);

// Buscar dados atuais do prato
$sql = "SELECT * FROM pratos WHERE id = $id";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 0) {
  echo "Prato não encontrado.";
  exit;
}
$prato = mysqli_fetch_assoc($res);

// Processar edição ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $preco = $_POST['preco'];
  $imagem = $_POST['imagem'];
  $categoria = $_POST['categoria'];

  $update_sql = "UPDATE pratos SET nome='$nome', preco=$preco, imagem='$imagem', categoria='$categoria' WHERE id=$id";
  if (mysqli_query($conn, $update_sql)) {
    echo "<p style='color:green;font-weight:bold;'>Prato atualizado com sucesso!</p>";
    echo "<a href='index.php' style='color:#007bff;'>Voltar ao painel</a>";
    exit;
  } else {
    echo "Erro ao atualizar prato: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Prato - Goi Delícias</title>
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
      width: 400px;
      text-align: center;
    }
    h2 {
      margin-bottom: 20px;
      color: #d2691e;
    }
    input, select {
      width: 90%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }
    button {
      padding: 12px 24px;
      background: #d2691e;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
    }
    button:hover {
      background: #b55315;
    }
    .back-link {
      margin-top: 15px;
    }
    .back-link a {
      color: #007bff;
      text-decoration: none;
    }
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Editar Prato</h2>
    <form method="post">
      <input type="text" name="nome" value="<?= htmlspecialchars($prato['nome']) ?>" placeholder="Nome do prato" required>
      <input type="number" step="0.01" name="preco" value="<?= $prato['preco'] ?>" placeholder="Preço" required>
      <input type="text" name="imagem" value="<?= htmlspecialchars($prato['imagem']) ?>" placeholder="Nome da imagem" required>
      <select name="categoria" required>
        <option value="">Selecione a categoria</option>
        <option value="doce" <?= $prato['categoria'] == 'doce' ? 'selected' : '' ?>>Doce</option>
        <option value="salgado" <?= $prato['categoria'] == 'salgado' ? 'selected' : '' ?>>Salgado</option>
        <option value="bebida" <?= $prato['categoria'] == 'bebida' ? 'selected' : '' ?>>Bebida</option>
      </select>
      <button type="submit">Salvar Alterações</button>
    </form>
    <div class="back-link">
      <a href="index.php">
            <button type="button" style="background: #6c757d;">Voltar ao Painel</button>
        </a>
    </div>
  </div>
</body>
</html>

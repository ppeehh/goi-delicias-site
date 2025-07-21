<?php
session_start();
include('../conexao.php');

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$sql = "SELECT nome, telefone, endereco FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrinho - Goi Delícias</title>
  <link rel="icon" href="../favicon.png" type="image/png">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      overflow-x: hidden;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .tabela-container {
      overflow-x: auto;
      width: 100%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      min-width: 500px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .botoes {
      margin-top: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
    }

    .botoes button {
      padding: 10px 20px;
      border: none;
      background-color: #007bff;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }

    .botoes button:hover {
      background-color: #0056b3;
    }

    @media (max-width: 600px) {
      table {
        min-width: unset;
      }

      table, thead, tbody, th, td, tr {
        display: block;
      }

      thead {
        display: none;
      }

      tr {
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        background-color: #f9f9f9;
      }

      td {
        position: relative;
        padding-left: 50%;
        text-align: left;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        top: 10px;
        font-weight: bold;
        white-space: nowrap;
      }

      .botoes {
        flex-direction: column;
        align-items: stretch;
      }
    }
  </style>
</head>
<body>

<h1>Seu Carrinho</h1>

<?php if (!empty($_SESSION['carrinho'])): ?>
  <div class="tabela-container">
    <table>
      <thead>
        <tr>
          <th>Produto</th>
          <th>Preço Unitário</th>
          <th>Quantidade</th>
          <th>Subtotal</th>
          <th>Remover</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $total = 0;
        foreach ($_SESSION['carrinho'] as $id => $item):
            $nome = $item['nome'];
            $preco = floatval($item['preco']);
            $qtd = isset($item['quantidade']) ? intval($item['quantidade']) : 1;
            $subtotal = $preco * $qtd;
            $total += $subtotal;
        ?>
        <tr>
          <td data-label="Produto"><?= htmlspecialchars($nome) ?></td>
          <td data-label="Preço Unitário">R$ <?= number_format($preco, 2, ',', '.') ?></td>
          <td data-label="Quantidade"><?= $qtd ?></td>
          <td data-label="Subtotal">R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
          <td data-label="Remover"><a href="../painel-cliente/remover_carrinho.php?id=<?= $id ?>">Remover</a></td>
        </tr>
        <?php endforeach; ?>
        <tr>
          <td colspan="3"><strong>Total (consultar frete no WhatsApp finalizando o pedido)</strong></td>
          <td colspan="2"><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
        </tr>
      </tbody>
    </table>
  </div>

  <?php
    $mensagem = "Olá, gostaria de fazer um pedido:\n\n";
    foreach ($_SESSION['carrinho'] as $item) {
        $nome = $item['nome'];
        $preco = floatval($item['preco']);
        $qtd = isset($item['quantidade']) ? intval($item['quantidade']) : 1;
        $mensagem .= " $nome - $qtd x R$ " . number_format($preco, 2, ',', '.') . "\n";
    }
    $mensagem .= "\nEndereço: " . $cliente['endereco'];
    $mensagem .= "\nNome: " . $cliente['nome'];
    $mensagem .= "\nTelefone: " . $cliente['telefone'];

    $mensagem_codificada = urlencode($mensagem);
    $numero_whatsapp = "5511976435786";
    $link_whatsapp = "https://wa.me/$numero_whatsapp?text=$mensagem_codificada";
  ?>

  <div class="botoes">
    <a href="index.php"><button>Continuar comprando</button></a>
    <a href="<?= $link_whatsapp ?>" target="_blank"><button>Finalizar Pedido</button></a>
  </div>

<?php else: ?>
  <p style="text-align: center;">Seu carrinho está vazio. <a href="index.php">Clique aqui para ver os produtos.</a></p>
<?php endif; ?>

</body>
</html>

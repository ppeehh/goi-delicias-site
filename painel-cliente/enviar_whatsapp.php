<?php
session_start();
include('../conexao.php');

// Verifica se cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// Garante que há itens no carrinho
if (empty($_SESSION['carrinho'])) {
    header("Location: index.php");
    exit;
}

// Dados do cliente
$nome = $_SESSION['cliente_nome'];
$telefone = $_SESSION['cliente_telefone'] ?? '';
$endereco = $_SESSION['cliente_endereco'] ?? '';
$email = $_SESSION['cliente_email'];

// Mensagem do pedido
$mensagem = "Olá! Gostaria de fazer um pedido:\n\n";
foreach ($_SESSION['carrinho'] as $item) {
    $mensagem .= "{$item['nome']} - {$item['quantidade']} x R$ " . number_format($item['preco'], 2, ',', '.') . "\n";
}
$mensagem .= "\nTotal: R$ " . number_format(array_sum(array_map(fn($i) => $i['preco'] * $i['quantidade'], $_SESSION['carrinho'])), 2, ',', '.');
$mensagem .= "\n\nNome: $nome\nTelefone: $telefone\nEndereço: $endereco";

// Codifica para URL
$link = "https://wa.me/5511976435786?text=" . urlencode($mensagem);

// Limpa carrinho (opcional)
unset($_SESSION['carrinho']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Redirecionando...</title>
  <script>
    // Abre WhatsApp e redireciona após 2 segundos
    window.onload = function () {
      window.open("<?= $link ?>", "_blank"); 
      setTimeout(() => {
        window.location.href = "index.php";
      }, 2000);
    }
  </script>
</head>
<body>
  <p>Enviando pedido para o WhatsApp... Aguarde...</p>
</body>
</html>

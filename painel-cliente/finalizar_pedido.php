<?php
session_start();
include('../conexao.php');

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se há itens no carrinho
if (empty($_SESSION['carrinho'])) {
    echo "Carrinho vazio.";
    exit;
}

// Dados do cliente logado
$cliente_id = $_SESSION['cliente_id'];
$stmt = $conn->prepare("SELECT nome, email, telefone, endereco FROM clientes WHERE id = ?");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    echo "Cliente não encontrado.";
    exit;
}

// Monta a mensagem do pedido
$mensagem = "Olá! Gostaria de fazer um pedido:\n\n";

foreach ($_SESSION['carrinho'] as $item) {
    $produto = $item['nome'];
    $preco = number_format($item['preco'], 2, ',', '.');
    $qtd = $item['quantidade'];
    $mensagem .= "- $produto x$qtd (R$ $preco)\n";
}

$total = array_reduce($_SESSION['carrinho'], function($carry, $item) {
    return $carry + ($item['preco'] * $item['quantidade']);
}, 0);

$mensagem .= "\nTotal: R$ " . number_format($total, 2, ',', '.');

// Adiciona os dados do cliente
$mensagem .= "\n\nNome: " . $cliente['nome'];
$mensagem .= "\nE-mail: " . $cliente['email'];
$mensagem .= "\nTelefone: " . $cliente['telefone'];
$mensagem .= "\nEndereço: " . $cliente['endereco'];

// Codifica a mensagem para uso na URL
$mensagem_url = urlencode($mensagem);

// Número da loja (substitua pelo número real)
$numero_whatsapp = "5511976435786";

// Redireciona para o WhatsApp com a mensagem
header("Location: https://wa.me/$numero_whatsapp?text=$mensagem_url");
exit;
?>

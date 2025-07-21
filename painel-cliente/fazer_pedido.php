<?php
session_start();
include('../conexao.php');

// Verifica se cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o id_prato foi enviado pelo POST
if (!isset($_POST['id_prato']) || empty($_POST['id_prato'])) {
    echo "<p>ID do prato não informado.</p>";
    echo "<a href='index.php'>Voltar</a>";
    exit;
}

$id_prato = intval($_POST['id_prato']); // Converte para inteiro para segurança
$data = date('Y-m-d H:i:s');

// Prepara a query para inserir pedido
$stmt = $conn->prepare("INSERT INTO pedidos (id_prato, status, data_pedido) VALUES (?, 'pendente', ?)");
$stmt->bind_param("is", $id_prato, $data);

if ($stmt->execute()) {
    echo "<p style='color: green; font-weight: bold;'>Pedido realizado com sucesso!</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>Erro ao realizar o pedido. Tente novamente.</p>";
}

$stmt->close();
?>

<a href="index.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #d2691e; color: white; border-radius: 6px; text-decoration: none;">Voltar ao cardápio</a>

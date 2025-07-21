<?php
session_start();
include('../conexao.php');

if (isset($_POST['id_prato']) && isset($_POST['quantidade'])) {
    $id = (int) $_POST['id_prato'];
    $quantidade = (int) $_POST['quantidade'];
    if ($quantidade < 1) $quantidade = 1; // Garantir quantidade mínima

    // Buscar o prato no banco de dados
    $res = mysqli_query($conn, "SELECT * FROM pratos WHERE id = $id");
    $item = mysqli_fetch_assoc($res);

    if (!$item) {
        echo "Prato não encontrado.";
        exit;
    }

    // Inicializa o carrinho na sessão, se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    // Se o item já existe no carrinho, incrementa a quantidade, senão adiciona novo
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]['quantidade'] += $quantidade;
    } else {
        $_SESSION['carrinho'][$id] = [
            'nome' => $item['nome'],
            'preco' => $item['preco'],
            'imagem' => $item['imagem'],
            'categoria' => $item['categoria'],
            'quantidade' => $quantidade
        ];
    }

    // Redireciona para a página do carrinho
    header('Location: ver_carrinho.php');
    exit;
} else {
    echo "ID do prato ou quantidade não fornecidos.";
}

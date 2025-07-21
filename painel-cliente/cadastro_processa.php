<?php
session_start();
include('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe e limpa os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $senha = $_POST['senha'];

    // Validações simples (pode ser ampliado)
    if (empty($nome) || empty($email) || empty($telefone) || empty($endereco) || empty($senha)) {
        $_SESSION['mensagem'] = "Preencha todos os campos.";
        header("Location: cadastro.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = "E-mail inválido.";
        header("Location: cadastro.php");
        exit;
    }

    // Verifica se o email já está cadastrado
    $sql = "SELECT id FROM clientes WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['mensagem'] = "E-mail já cadastrado.";
        $stmt->close();
        header("Location: cadastro.php");
        exit;
    }
    $stmt->close();

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere no banco de dados
    $sql = "INSERT INTO clientes (nome, email, telefone, endereco, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $telefone, $endereco, $senha_hash);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Cadastro realizado com sucesso! Faça login para continuar.";
        $stmt->close();
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao cadastrar. Tente novamente.";
        $stmt->close();
        header("Location: cadastro.php");
        exit;
    }
} else {
    // Se não for POST, redireciona para cadastro
    header("Location: cadastro.php");
    exit;
}

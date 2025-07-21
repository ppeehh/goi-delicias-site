<?php
session_start();
include('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $imagem = $_FILES['imagem']['name'];

    $destino = '../imagens/' . $imagem;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

    $sql = "INSERT INTO pratos (nome, preco, imagem, categoria) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdss", $nome, $preco, $imagem, $categoria);
    $stmt->execute();

    $_SESSION['mensagem'] = "Prato adicionado com sucesso!";
    header("Location: adicionar_prato.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Prato</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('../painel-cliente/img/logo.png'); /* mesmo fundo dos logins */
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
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            z-index: 9999;
            font-family: Arial, sans-serif;
            font-size: 16px;
            animation: fadeOut 5s forwards;
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            85% { opacity: 1; }
            100% { opacity: 0; top: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['mensagem'])) {
            echo "<div class='alert'>" . $_SESSION['mensagem'] . "</div>";
            unset($_SESSION['mensagem']);
        }
        ?>
        <h2>Adicionar Novo Prato</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Nome do prato" required>
            <input type="number" step="0.01" name="preco" placeholder="Preço" required>
            <input type="file" name="imagem" accept="image/*" required>
            <select name="categoria" required>
                <option value="">Selecione a categoria</option>
                <option value="doce">Doce</option>
                <option value="salgado">Salgado</option>
                <option value="bebida">Bebida</option>
            </select>
            <button type="submit">Salvar</button>
        </form>
        <br>
        <a href="index.php">
            <button type="button" style="background: #6c757d;">Voltar ao Painel</button>
        </a>
    </div>
</body>
</html>

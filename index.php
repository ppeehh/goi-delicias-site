<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Goi Delícias - Bem Vindo!</title>
  <link rel="icon" href="favicon.png" type="image/png">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('imagem/logo.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .conteudo {
      background: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      max-width: 90%;
    }

    h1 {
      color: #d35400;
      margin-bottom: 30px;
      font-size: 2em;
    }

    .painel-btn {
      display: inline-block;
      margin: 15px 10px;
      padding: 15px 30px;
      background-color: #f39c12;
      color: white;
      font-size: 18px;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .painel-btn:hover {
      background-color: #e67e22;
    }

    /* Responsividade */
    @media (max-width: 600px) {
      .conteudo {
        padding: 20px;
      }

      h1 {
        font-size: 1.5em;
      }

      .painel-btn {
        display: block;
        margin: 10px auto;
        width: 100%;
        max-width: 300px;
        font-size: 16px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="conteudo">
    <h1>Bem-vindo ao Goi Delícias</h1>
    <a class="painel-btn" href="painel-cliente/index.php">Faça seu Pedido</a>
    <a class="painel-btn" href="painel-adm/index.php">Administração</a>
  </div>
</body>
</html>

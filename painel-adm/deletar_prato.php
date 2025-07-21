<?php
include('../conexao.php');

if (!isset($_GET['id'])) {
  echo "ID do prato não informado.";
  exit;
}

$id = intval($_GET['id']);

// Deletar o prato do banco
$sql = "DELETE FROM pratos WHERE id = $id";

if (mysqli_query($conn, $sql)) {
  header("Location: index.php?msg=Prato deletado com sucesso");
  exit;
} else {
  echo "Erro ao deletar prato: " . mysqli_error($conn);
}

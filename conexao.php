<?php
$host = "localhost";
$user = "goidelic_usuario";
$pass = "55215230Goi.";
$db = "goidelic_goidelic_loja";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { die("Falha na conexão: " . mysqli_connect_error()); }
?>
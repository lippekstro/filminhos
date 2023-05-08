<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";

try {
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    if (!empty($_FILES['foto']['tmp_name'])) {
        $imagem = file_get_contents($_FILES['foto']['tmp_name']);
    }
    $senha = $_POST['senha'];
    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $usuario = new Usuario();
    $usuario->nome = $nome;
    $usuario->email = $email;
    $usuario->foto = $foto;
    $usuario->senha = $senha;
    if(isset($imagem)){
        $usuario->foto = $imagem;
    }
    $usuario->criar();

    header("Location: /filminhos/views/login.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}
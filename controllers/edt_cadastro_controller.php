<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";
session_start();

try {
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $usuario = new Usuario($id_usuario);
    $usuario->nome = $nome;
    $usuario->email = $email;
    $usuario->editar();

    header("Location: /filminhos/views/perfil.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

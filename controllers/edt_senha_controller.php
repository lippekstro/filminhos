<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario.php";
session_start();

try {
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $senha_antiga = $_POST['antiga_senha'];
    $nova = $_POST['senha'];
    $nova = password_hash($nova, PASSWORD_DEFAULT);

    $query = "SELECT * FROM usuario WHERE id_usuario = :id_usuario LIMIT 1";
    $conexao = Conexao::conectar();
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(":id_usuario", $id_usuario);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($senha_antiga, $registro['senha'])) {
        $usuario = new Usuario($id_usuario);
        $usuario->senha = $nova;
        $usuario->editaSenha();
        header("Location: /filminhos/views/perfil.php");
        exit();
    } else {
        $_SESSION['erro'] = "Senha incorreta";
        header("Location: /filminhos/views/edita_senha.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

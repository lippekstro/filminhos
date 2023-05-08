<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/usuario_grupo.php";
session_start();

try {
    $nome = htmlspecialchars($_POST['nome_grupo']);
    $descricao = htmlspecialchars($_POST['descricao']);
    $id_usuario = $_SESSION['usuario']['id_usuario'];

    $grupo = new Grupo();
    $grupo->nome = $nome;
    $grupo->descricao = $descricao;
    $id_grupo = $grupo->criar();

    try {
        $usuario_grupo = new UsuarioGrupo();
        $usuario_grupo->id_grupo = $id_grupo;
        $usuario_grupo->id_usuario = $id_usuario;
        $usuario_grupo->criar();
        
        $_SESSION['msg'] = 'Grupo Criado com Sucesso';
        header("Location: /filminhos/views/grupos.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo_filme.php";
session_start();

try {
    $id_filme = htmlspecialchars($_GET['id_filme']);
    $id_grupo = htmlspecialchars($_GET['id_grupo']);

    $grupo_filme = new GrupoFilme();
    $grupo_filme->id_grupo = $id_grupo;
    $grupo_filme->id_filme_api = $id_filme;
    $grupo_filme->criar();

    $_SESSION['msg'] = 'Filme Adicionado com Sucesso';
    header("Location: /filminhos/views/detalhes_grupo.php?id_grupo=$id_grupo");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

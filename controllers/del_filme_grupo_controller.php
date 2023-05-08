<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/filminhos/models/grupo_filme.php';

try {
    $id_grupo_filme = $_GET['id_grupo_filme'];
    $id_grupo = $_GET['id_grupo'];

    $grupo_filme = new GrupoFilme($id_grupo_filme);

    $grupo_filme->deletar();

    $_SESSION['msg'] = 'Filme Removido';
    header("Location: /filminhos/views/detalhes_grupo.php?id_grupo=$id_grupo");
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
}
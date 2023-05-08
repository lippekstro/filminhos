<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
session_start();

try {
    $id_convidado = $_GET['id_convidado'];
    $id_grupo = $_GET['id_grupo'];

    $convite = new Convite();
    $convite->id_usuario = $id_convidado;
    $convite->id_grupo = $id_grupo;
    $convite->criar();

    header("Location: /filminhos/views/detalhes_grupo.php?id_grupo=$id_grupo");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

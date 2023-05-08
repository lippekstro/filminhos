<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
session_start();

try {
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    $id_grupo = $_GET['id_grupo'];
    $id_convite = $_GET['id_convite'];

    $convite = new Convite($id_convite);
    $convite->confirmaConvite($id_grupo, $id_usuario);
    $convite->deletar();

    
    header("Location: /filminhos/views/perfil.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

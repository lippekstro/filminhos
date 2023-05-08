<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/convite.php";
session_start();

try {
    $id_convite = $_GET['id_convite'];

    $convite = new Convite($id_convite);
    $convite->deletar();

    $_SESSION['msg'] = 'Convite Recusado';
    header("Location: /filminhos/views/perfil.php");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

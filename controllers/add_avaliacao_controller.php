<?php
/* require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/grupo.php"; */
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/models/nota.php";
session_start();

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $id_usuario = $data['id_usuario'];
    $id_filme = $data['id_filme'];
    $nota_valor = $data['nota'];

    $jaVotou = Nota::jaVotou($id_usuario, $id_filme);

    if ($jaVotou) {
        $nota = new Nota($jaVotou);
        $nota->id_usuario = $id_usuario;
        $nota->nota = $nota_valor;
        $nota->id_filme_api = $id_filme;
        $nota->editar();
    } else {
        $nota = new Nota();
        $nota->nota = $nota_valor;
        $nota->id_usuario = $id_usuario;
        $nota->id_filme_api = $id_filme;
        $nota->criar();
    }


    header("Location: /filminhos/views/detalhes.php?id_filme=$id_filme");
    exit();
} catch (PDOException $e) {
    echo $e->getMessage();
}

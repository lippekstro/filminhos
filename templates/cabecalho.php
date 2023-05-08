<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/configs/sessoes.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/filminhos/configs/config.php";
date_default_timezone_set('America/Sao_Paulo');

$api_key = API_KEY;
$lang = LANG;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="/filminhos/css/style.css">
</head>

<body>
    <header>
        <nav>
            <a href="/filminhos/index.php">Inicio</a>
            <?php if (isset($_SESSION['usuario']['email'])) : ?>
                <a href="/filminhos/views/grupos.php">Grupos</a>
                <a href="/filminhos/views/perfil.php">Perfil</a>
                <a href="/filminhos/controllers/logout_controller.php">Logout</a>
            <?php else : ?>
                <a href="/filminhos/views/login.php">Login</a>
            <?php endif; ?>

        </nav>
    </header>
    <main>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/filminhos/models/usuario.php';
session_start();

try{
    $email = htmlspecialchars($_POST['email']);
    $senha = htmlspecialchars($_POST['senha']);
    Usuario::logar($email, $senha);
} catch (Exception $e) {
    echo $e->getMessage();
}
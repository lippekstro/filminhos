<?php
session_start();
session_unset();
session_destroy();
$_SESSION['msg'] = 'Saida com Sucesso';
header("Location: /filminhos/views/login.php");
exit();
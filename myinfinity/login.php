<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nick = $_POST['nick'];
        $pass = $_POST['contraseña'];


        if(checkLogin($nick,$pass)){
            session_start();

            //Se guarda en la sesion el nick del usuario que se ha logeado
            $_SESSION['nick'] = $nick;

            header("Location: /index.php");
        }
        else{
            header("Location: /login.php");
        }
        exit();
    }

    echo $twig->render('login.html', []);
?>
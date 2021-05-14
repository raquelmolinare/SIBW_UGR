<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);


    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nick = $_POST['nick'];
        $pass = $_POST['contraseña'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];

        //insertUser($nick, $pass, $nombre, $apellidos, $email, 'registrado');
        
        if( insertUser($nick, $pass, $nombre, $apellidos, $email, 'registrado') ){
            session_start();

            //Se guarda en la sesion el nick del usuario que se ha logeado
            $_SESSION['nick'] = $nick;

            header("Location: index.php");
        }
        else{
            header("Location: signup.php");
        }

        header("Location: index.php");
        exit();
    }

    echo $twig->render('signup.html', []);
?>
<?php

    function consultarEvento($contenido){


        require_once "/usr/local/lib/php/vendor/autoload.php";
        
        include("bd.php");

        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader);

        session_start();

        $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo');

        if( isset($_SESSION['nick']) ){

            $user = getUser($_SESSION['nick']); 

            $usuario['nick']= $user['nick'];
            $usuario['tipo']= $user['tipo'];
        }

        $busqueda = buscarEventos($contenido); //busca los eventos que coinciden en a bd


        echo $twig->render('lista.html', ['busqueda' => $busqueda, 'usuario' => $usuario, 'contenido' => $contenido]);
    }

    if(isset($_POST["consulta"])) {
        consultarEvento($_POST["consulta"]);
    }
    

?>

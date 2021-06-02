<?php
    require_once "/usr/local/lib/php/vendor/autoload.php";

    include("bd.php");

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);

    //1. Gestion de la sesion del usuario
    session_start();

    $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo','nombre' => 'defecto','apellidos' => 'defecto','email' => 'defecto');

    if( isset($_SESSION['nick']) ){

        $user = getUser($_SESSION['nick']); 

        $usuario['nick']= $user['nick'];
        $usuario['tipo']= $user['tipo'];
        $usuario['nombre']= $user['nombre'];
        $usuario['apellidos']= $user['apellidos'];
        $usuario['email']= $user['email'];

        //Restringido acceso a usuairos gestor y superusuario
        if($usuario['tipo']==="registrado" or $usuario['tipo']==="moderador"){
            header("Location: /index.php");
        }
    }
    else{
        header("Location: /login.php");
    }


    //2.Gestion de los eventos
    //Consultamos los eventos
    if(isset ($_GET['cont'])){ //Si está definida la variable ev
        $contenido = $_GET['cont'];
        if($contenido != ""){
            $eventos = buscarEventos($contenido);
        }
        else{
            $eventos = getEventos();
        }
        
    }
    else{
        $eventos = getEventos();
    }
    
    
    //Gestion de los eventos
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        if(isset($_POST["buscar"])){
            $contenido = $_POST['busqueda'];
            header("Location:/listaeventos.php/?cont=".$contenido);
        }

        exit();
    }

   //Renderizar la pagina
   echo $twig->render('listaeventos.html', ['usuario' => $usuario, 'eventos' => $eventos]);

?>

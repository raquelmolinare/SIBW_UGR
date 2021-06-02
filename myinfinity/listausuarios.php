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

        //Restringido acceso a usuairo superusuario
        if($usuario['tipo'] != "superusuario"){
            header("Location: /index.php");
        }
    }
    else{
        header("Location: /login.php");
    }


    //2.Gestion de los eventos
    //Consultamos los eventos
    if(isset ($_GET['nick'])){ //Si está definida la variable ev
        $nick = $_GET['nick'];
        if($nick!= ""){
            if($nick != $usuario['nick']){
                $usuarios = getUsuariosNick($nick);
            }
            else{

            }
        }
        else{
            $usuarios = getUsuarios($usuario['nick']);
        }
        
    }
    else{
        $usuarios = getUsuarios($usuario['nick']);
    }
    
    
    //Gestion de los eventos
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        if(isset($_POST["buscar"])){
            $nick = $_POST['busqueda'];
            header("Location:/listausuarios.php/?nick=".$nick);
        }

        if(isset($_POST["editarpermisosusuario"])){
            $nickUser = $_POST['editarpermisosusuario'];
            header("Location:/editarusuarios.php/?user=".$nickUser);
        }

        exit();
    }

   //Renderizar la pagina
   echo $twig->render('listausuarios.html', ['usuario' => $usuario, 'usuarios' => $usuarios]);

?>

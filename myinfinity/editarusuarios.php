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

        //Restringido acceso a usuario superusuario
        if($usuario['tipo'] != "superusuario"){
            header("Location: /index.php");
        }
    }
    else{
        header("Location: /login.php");
    }


    //2.Gestion de los eventos

    //Asegurarnos del parametro evento que llega para evitar consultas icorrectas a la BD
    if(isset ($_GET['user'])){ //Si está definida la variable ev
        $nick = $_GET['user']; //Se toma el id
        $usuariobuscado = getUser($nick); 
    }
    else{
        $nick = -1;
    }
   
    //Gestion de los eventos
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
       
        if(isset($_POST["changeRegistrado"])){
            $nickUser = $_POST['editarpermisosusuario'];
            usuarioRegistrado( $nickUser);
            header("Location:/editarusuarios.php/?user=".$nickUser);
        }

        if(isset($_POST["changeModerador"])){
            $nickUser = $_POST['editarpermisosusuario'];;
            usuarioModerador( $nickUser);
            header("Location:/editarusuarios.php/?user=".$nickUser);
        }

        if(isset($_POST["changeGestor"])){
            $nickUser = $_POST['editarpermisosusuario'];
            usuarioGestor($nickUser);
            header("Location:/editarusuarios.php/?user=".$nickUser);
        }

        if(isset($_POST["changeSuperusuario"])){
            $nickUser = $_POST['editarpermisosusuario'];
            usuarioSuperusuario( $nickUser);
            header("Location:/editarusuarios.php/?user=".$nickUser);
        }
        
        exit();
    }

   //Renderizar la pagina
   echo $twig->render('editarusuario.html', ['usuario' => $usuario, 'usuariobuscado' => $usuariobuscado]);

?>

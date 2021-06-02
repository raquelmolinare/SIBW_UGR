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

        //Restringido acceso a usuairos moderador gestor y superusuario
        if($usuario['tipo']==="registrado"){
            header("Location: /index.php");
        }
    }
    else{
        header("Location: /login.php");
    }


    //2.Gestion de los comentarios
    //Consultamos los comentarios del evento
    if(isset ($_GET['cont'])){ //Si está definida la variable ev
        $contenido = $_GET['cont'];
        if($contenido != ""){
            $comentarios = buscarComentarios($contenido);
        }
        else{
            $comentarios = getAllComentarios();
        }
        
    }
    else{
        $comentarios = getAllComentarios();
    }
    
    
    //Gestion de los comentarios
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        if(isset($_POST["buscar"])){
            $contenido = $_POST['busquedamusica'];
            header("Location:/comentarios.php/?cont=".$contenido);
        }

        if(isset($_POST["eliminarcomentario"])) {
            $idComentario = $_POST['eliminarcomentario'];
            eliminarComentario($idComentario);
            header("Location:/comentarios.php/?cont=".$contenido);
          }

        exit();
    }

   //Renderizar la pagina
   echo $twig->render('comentarios.html', ['usuario' => $usuario, 'comentarios' => $comentarios]);

?>

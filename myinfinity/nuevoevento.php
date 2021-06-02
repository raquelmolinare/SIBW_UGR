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


    //2.Añadir evento

    //Gestion de los eventos
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        
        if(isset($_POST["nuevoevento"])){
            $nombre= $_POST['nuevonombre'];
            $lugar= $_POST['nuevolugar'];
            $fecha= $_POST['nuevafecha'];
            $motivo= $_POST['nuevomotivo'];
            $descripcion= $_POST['nuevadescripcion'];
            $enlaceArtista= $_POST['nuevoenlaceArtista'];
            $nombreArtista= $_POST['nuevonombreArtista'];
            $instaArtista= $_POST['nuevoinstaArtista'];
            $twArtista= $_POST['nuevotwArtista'];
            //Comprobar que ningun campo esta vacio
            if($nombre!="" and $lugar!="" and $fecha!="" and $motivo!="" and $descripcion!="" and $enlaceArtista!="" and $nombreArtista!="" and $instaArtista!="" and $twArtista!=""){
                addEvento($nombre,$lugar,$fecha,$motivo,$descripcion,$enlaceArtista,$nombreArtista,$instaArtista,$twArtista);
                header("Location: /");
            }
            else{
                header("Location: /nuevoevento.php");
            }
            header("Location: /nuevoevento.php");
        }
    
        exit();
    }

   //Renderizar la pagina
   echo $twig->render('nuevoevento.html', ['usuario' => $usuario, 'imagenes' => $imagenes,  'etiquetas' => $etiquetas]);

?>

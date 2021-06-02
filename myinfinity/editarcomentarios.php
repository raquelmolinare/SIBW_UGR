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

    //Consultamos las palabras prohibidas
    $prohibidas = getPalabrasProhibidas();

    //Asegurarnos del parametro comentario que llega para evitar consultas icorrectas a la BD
    if(isset ($_GET['comentario'])){ //Si está definida la variable ev
        $idComentario = $_GET['comentario']; //Se toma el id
        $comentario = getComentario($idComentario); 
    }
    else{
        $idComentario = -1;
    }
   
    //Gestion de los comentarios
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        if(isset($_POST["guardarNombre"])){
            $idComentario = $_POST['idcomentario'];
            $nombre = $_POST['nuevonombre'];
            editNombreComentario($idComentario,$nombre);
            header("Location:/editarcomentarios.php/?comentario=". $idComentario);
        }

        if(isset($_POST["guardarEmail"])) {
            $idComentario = $_POST['idcomentario'];
            $email = $_POST['nuevoemail'];
            editEmailComentario($idComentario,$email);
            header("Location:/editarcomentarios.php/?comentario=". $idComentario);
        }

        if(isset($_POST["guardarTexto"])) {
            $idComentario = $_POST['idcomentario'];
            $texto = $_POST['nuevotexto'];
            editTextoComentario($idComentario,$texto);
            header("Location:/editarcomentarios.php/?comentario=". $idComentario);
        }

        if(isset($_POST["volver"])) {
            $idEv=$_POST['idEvento'];
            header("Location: /evento.php/?ev=".$idEv);
        }

        if(isset($_POST["cancelar"])) {
            $idComentario = $_POST['idcomentario'];
            header("Location: /editarcomentarios.php/?comentario=".$idComentario);
        }
        

        exit();
    }

   //Renderizar la pagina
   echo $twig->render('editarcomentarios.html', ['usuario' => $usuario, 'comentario' => $comentario, 'prohibidas' => $prohibidas]);

?>

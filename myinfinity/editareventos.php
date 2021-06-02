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

    //Asegurarnos del parametro evento que llega para evitar consultas icorrectas a la BD
    if(isset ($_GET['ev'])){ //Si está definida la variable ev
        $idEvento = $_GET['ev']; //Se toma el id
        $evento = getEvento($idEvento); 

        //Si el evento no esta publico y el tipo no es gestor se le lleva al index porque no puede visualizar este evento
        if( ( $evento['publicado'] === 0 ) and ($usuario['tipo'] !== 'gestor') ){
            header("Location: /index.php");
        }

        //Consultamos al modelo por las imagenes del evento
        $imagenes = getImagenes($idEvento);

        //Consultamos al modelo por las etiquetas del evento
        $etiquetas = getEtiquetas($idEvento);
    }
    else{
        $idEvento = -1;
    }
   
    //Gestion de los eventos
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        
        if(isset($_POST["guardarNombre"])){
            $idEvento = $_POST['idevento'];
            $nombre= $_POST['nuevonombre'];
            editNombreEvento($idEvento,$nombre);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarLugar"])){
            $idEvento = $_POST['idevento'];
            $lugar= $_POST['nuevolugar'];
            editLugarEvento($idEvento,$lugar);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarFecha"])){
            $idEvento = $_POST['idevento'];
            $fecha= $_POST['nuevafecha'];
            editFechaEvento($idEvento,$fecha);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarMotivo"])){
            $idEvento = $_POST['idevento'];
            $motivo= $_POST['nuevomotivo'];
            editMotivoEvento($idEvento,$motivo);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarDescripcion"])){
            $idEvento = $_POST['idevento'];
            $descripcion= $_POST['nuevadescripcion'];
            editDescripcionEvento($idEvento,$descripcion);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarEnlaceArtista"])){
            $idEvento = $_POST['idevento'];
            $enlaceArtista= $_POST['nuevoenlaceArtista'];
            editEnlaceArtistaEvento($idEvento,$enlaceArtista);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarnombreArtista"])){
            $idEvento = $_POST['idevento'];
            $nombreArtista= $_POST['nuevonombreArtista'];
            editNombreArtistaEvento($idEvento,$nombreArtista);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardarinstaArtista"])){
            $idEvento = $_POST['idevento'];
            $instaArtista= $_POST['nuevoinstaArtista'];
            editInstaArtistaEvento($idEvento,$instaArtista);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["guardartwArtista"])){
            $idEvento = $_POST['idevento'];
            $twArtista= $_POST['nuevotwArtista'];
            editTwArtistaEvento($idEvento,$twArtista);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        /*
        if(isset($_POST["guardar"])){
            $idEvento = $_POST['idevento'];
            $= $_POST['nuevo'];
            editEvento($idEvento,$);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }*/

        if(isset($_POST["volver"])) {
            header("Location: /");
        }

        if(isset($_POST["cancelar"])) {
            $idEvento = $_POST['idevento'];
            header("Location: /editareventos.php/?ev=".$idEvento);
        }


        //ESTADO PUBLICADO O NO PUBLICADO

        if(isset($_POST["publicarevento"])){
            $idEvento = $_POST['idevento'];
            publicarEvento($idEvento);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["ocultarevento"])){
            $idEvento = $_POST['idevento'];
            ocultarEvento($idEvento);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }


        //IMAGENES

        if(isset($_POST["eliminarimagen"])){
            $idImagen = $_POST['eliminarimagen'];
            $idEvento = $_POST['idevento'];
            eliminarImagen($idImagen);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["addPortada"])){
            $srcImagen = $_POST['nuevaImagen'];
            $idEvento = $_POST['idevento'];
            if($srcImagen != ""){
                addImagenPortada( $srcImagen,$idEvento);
            }
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["addGaleria"])){
            $srcImagen = $_POST['nuevaImagen'];
            $idEvento = $_POST['idevento'];
            if($srcImagen != ""){
                addImagenGaleria( $srcImagen,$idEvento);
            }
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        //ETIQUETAS

        if(isset($_POST["eliminaretiqueta"])){
            $idEtiqueta = $_POST['eliminaretiqueta'];
            $idEvento = $_POST['idevento'];
            eliminarEtiqueta($idEtiqueta);
            header("Location: /editareventos.php/?ev=".$idEvento);
        }

        if(isset($_POST["addEtiqueta"])){
            $etiqueta = $_POST['nuevaEtiqueta'];
            $idEvento = $_POST['idevento'];
            if($etiqueta != ""){
                addEtiqueta( $etiqueta,$idEvento);
            }
            header("Location: /editareventos.php/?ev=".$idEvento);
        }
        
        exit();
    }

   //Renderizar la pagina
   echo $twig->render('editareventos.html', ['usuario' => $usuario, 'evento' => $evento, 'imagenes' => $imagenes,  'etiquetas' => $etiquetas]);

?>

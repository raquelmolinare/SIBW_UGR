<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  $urlImprimir = "url por defecto";

  //1. Gestion de la sesion del usuario
  session_start();

  $usuario = array('nick' => 'defecto', 'tipo' => 'anonimo','nombre' => 'defecto','apellidos' => 'defecto','email' => 'defecto');

  if( isset($_SESSION['nick']) ){

      $user = getUser($_SESSION['nick']); 

      $usuario['nick']= $user['nick'];
      $usuario['tipo']= $user['tipo'];
  }
  else{
      //header("Location: login.php");
  }

  //2.Gestion de los eventos
  //Asegurarnos del parametro ev que llega para evitar consultas icorrectas a la BD
  if(isset ($_GET['ev'])){ //Si está definida la variable ev
    $idEv = $_GET['ev']; //Se toma el id
  }
  else{ //Si no lo está
    $idEv = -1; //Se toma id -1 que no existe en la BD
  }

  //Si se recibe la busqueda
  if(isset ($_GET['busq'])){
    $busqueda = $_GET['busq'];
  }
  else{ //Si no lo está
    $busqueda = "";
  }

  //Consultamos al modelo por el evento requerido
  $evento = getEvento($idEv);

  //Si el evento no esta publico y el tipo no es gestor se le lleva al index porque no puede visualizar este evento
  if( ( $evento['publicado'] === 0 ) and ($usuario['tipo'] !== 'gestor') ){
    header("Location: /index.php");
  }

  //Consultamos al modelo por las imagenes que forman parte de la galeria del evento requerido
  $imagenes = getImagenesGaleria($idEv);

  //Consultamos los comentarios del evento
  $comentarios = getComentarios($idEv);

  //Consultamos las palabras prohibidas
  $prohibidas = getPalabrasProhibidas();

  $urlImprimir = "/evento_imprimir.php/?ev=" . $idEv;


  //Gestion de los comentarios
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    if(isset($_POST["nuevocomentario"])){
      //$nombre = $_POST['nombreInput'];
      //$email = $_POST['emailInput'];
      $texto = $_POST['comentarioInput'];
      $idEv=$_POST['idEvento'];
      
      //Comprobar que ningún campo está vacio
      if($texto!=""){
          nuevoComentario($usuario['nick'], $idEv, $texto);
      }
      header("Location: /evento.php/?ev=".$idEv);
    }

    if(isset($_POST["eliminarcomentario"])) {
      $idComentario = $_POST['eliminarcomentario'];
      $idEv=$_POST['idEvento'];
      eliminarComentario($idComentario);
      header("Location: /evento.php/?ev=".$idEv);
    }


    if(isset($_POST["editarcomentario"])) {
      $idComentario = $_POST['editarcomentario'];
      $idEv=$_POST['idEvento'];
      header("Location: /editarcomentarios.php/?comentario=".$idComentario);
    }


    exit();
  }

  //Renderizar la pagina
  echo $twig->render('evento.html', ['usuario' => $usuario,'evento' => $evento, 'imagenes' => $imagenes, 'comentarios' => $comentarios, 'urlImprimir' => $urlImprimir, 'prohibidas' => $prohibidas, 'busqueda' => $busqueda ]);

?>

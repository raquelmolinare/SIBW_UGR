<?php

    //Variable para manejar la conexion unica a base de datos
    $mysqli = null;


    function conexionBD(){

        global $mysqli;

        //Si no se ha realizado la conexion anteriormente
        if( $mysqli == null ){

            //1. Crear un objeto de tipo mysqli : host / usuario / contraseña / BD
            $mysqli = new mysqli("mysql", "usuario", "usuario", "SIBW");

            //2. Comprobación de conexion
            if( $mysqli->connect_errno ){
                echo("Fallo al conectar : " . $mysqli->connect_error);
            }
        }     

        return $mysqli;
    }

  
    function getEvento($idEv){

        $evento = array('nombre' => 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'fecha' => 'Fecha por defecto', 'motivo' => 'Motivo por defecto', 'descripcion' => 'Descripcion por defecto',
        'enlaceArtista' => 'Enlace por defecto', 'nombreArtista' => 'Artista por defecto', 'instaArtista' => 'Instagram por defecto', 'twArtista' => 'Twitter por defecto');
        
        //Realizamos consultas de evento

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el evento en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista FROM eventos WHERE id=?");
        $consulta->bind_param("i",$idEv);

        $consulta->execute();
        $res = $consulta->get_result();
        
        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            //Devolvemos un array asociativo con la informacion requerida
            $evento = array('nombre' => $row['nombre'], 'lugar' => $row['lugar'], 'fecha' => $row['fecha'], 'motivo' => $row['motivo'], 'descripcion' => $row['descripcion'],
            'enlaceArtista' => $row['enlaceArtista'], 'nombreArtista' => $row['nombreArtista'], 'instaArtista' => $row['instaArtista'], 'twArtista' => $row['twArtista']);
        }

        //cerrar sentencia
        $consulta->close();

        return $evento;
    }

    function getImagenesGaleria($idEv){

        $imagenes;
        
        //Realizamos consultas de imagenes
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT src FROM imagenes WHERE idEvento=? AND (tipo='galeria' OR tipo='portada,galeria')");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $imagenes[$i] = $row['src'];
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $imagenes;
    }

    
    function getEventos(){

        $eventos; //Contendrá todos los eventos

        //Información de cada evento
        $evento = array('nombreArtista' => 'Nombre por defecto', 'motivo' => 'Motivo por defecto', 'imgPortada' => 'Portada por defecto', 'urlEvento' => 'Url por defecto');
        $imgPortada ='Portada por defecto'; //url de la imagen portada
        $urlEvento = 'Url por defecto'; //url del evento

        //Realizamos consultas de eventos

        //Necesitamos el id de cada evento que haya en la tabla eventos

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD();

        //1.Consuultar todos los eventos
        $consulta = $mysqli->prepare("SELECT id, motivo, nombreArtista FROM eventos");
        
        $consulta->execute();
        $res = $consulta->get_result();
        
        $i = 0;
        if( $res->num_rows > 0){
            while( $row = $res->fetch_assoc() ){ //Por cada fila y por tanto por cada evento

                //Obtenemos el id del evento 
                $id_ev = $row['id'];

                //Calculamos la url
                $urlEvento = "/evento.php/?ev=" . $id_ev;

                //Obtenemos la img que es portada
                $imgPortada = getPortada($id_ev);

                //Completamos los campos
                $evento = array('nombreArtista' => $row['nombreArtista'], 'motivo' => $row['motivo'], 'imgPortada' => $imgPortada, 'urlEvento' => $urlEvento);

                //Insertamos el evento en eventos
                $eventos[$i] = $evento;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();

        return $eventos;
    }


    function getPortada($idEv){

        $portada = "Portada por defecto";
        
        //Realizamos consultas de imagenes
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD, aquella con tipo portada
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT src FROM imagenes WHERE idEvento=? AND (tipo='portada' OR tipo='portada,galeria')");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        if( $res->num_rows > 0){
            $row = $res->fetch_assoc();
            $portada = $row['src'];
        }

        //cerrar sentencia
        $consulta->close();
        
        return $portada;
    }

    function getComentarios($idEv){

        $comentarios;
        $comentario = array('nombreAutor' => 'Nombre por defecto', 'comentario' => 'Comentario por defecto', 'fecha' => 'fecha por defecto');
        $fecha;
        
        //Realizamos consultas de comentarios
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT nombre, comentario, fecha FROM comentarios WHERE idEvento=?");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                //Completamos los campos
                $comentario = array('nombreAutor' => $row['nombre'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha']);

                //Insertamos el comentario en comentarios
                $comentarios[$i] = $comentario;

                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $comentarios;
    }
    
    function getPalabrasProhibidas(){

        $prohibidas;
        
        //Realizamos consultas de palabra prohibidas
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        $consulta = $mysqli->prepare("SELECT palabra FROM prohibidas");

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;
        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                //Insertamos la palabra prohibida obtenida en prohibidas
                $prohibidas[$i] =  $row['palabra'];
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $prohibidas;
    }


    //------------------------------------------------------------------------
    // Funcion para insertar un usuario
    function insertUser($nick,$passw, $nombre, $apellidos, $email, $tipo) {

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se inserta el usuario en la BD
        $peticion = "INSERT INTO usuarios (nick,passw,nombre,apellidos,email,tipo) VALUES ('$nick','" . password_hash($passw,PASSWORD_DEFAULT) . "','$nombre','$apellidos','$email','$tipo')"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para comprobar un usuario y contraseña en la base de datos
    function checkLogin($nick, $passw) {

        $resultado = false;

        //Realizamos consulta del usuario en la base de datos
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el usuario en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT passw FROM usuarios WHERE nick=?");
        $consulta->bind_param("s",$nick);

        $consulta->execute();
        $res = $consulta->get_result();
        
        //Si el numero de filas obtenido de la base de datos es mayor que 0 entonces hay un usuario con ese nick
        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            $contraseña = $row['passw'];

            //Comprobamos que la contraseña coincide con la de la base de datos
            if (password_verify($passw, $contraseña )) {
                //Si la contraseña es valida entonces el usuario y la contraseña son validos
                $resultado = true;
            }
        }
        else{ //Si no, no existe en la abse de datos un usuario con ese nick
            $resultado = false;
        }

        //cerrar sentencia
        $consulta->close();
        
        return $resultado;
    }
      
    //------------------------------------------------------------------------
    // Funcion para obtener la informacion de un usuario de la base de datos a partir de su nick
    function getUser($nick) {
        $usuario = array('nick' => 'Nick por defecto', 'passw' => 'Contraseña por defecto', 'tipo' => 'Tipo por defecto',
                            'nombre' => 'Nombre por defecto','apellidos' => 'Apellidos por defecto','email' => 'Email por defecto',    );
        
        //Realizamos consultas de usuario
        
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el usuario en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT nick,passw,nombre,apellidos,email,tipo FROM usuarios WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            $usuario = array('nick' => $row['nick'], 'passw' => $row['passw'], 'tipo' => $row['tipo'],'nombre' => $row['nombre'],'apellidos' => $row['apellidos'],'email' => $row['email']);
        }

        //cerrar sentencia
        $consulta->close();

        return $usuario;
    }

    

    //------------------------------------------------------------------------
    // Funcion para editar un usuario
    function editUser($nick,$passw, $nombre, $apellidos, $email) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET nick='$nick',passw='" . password_hash($passw,PASSWORD_DEFAULT) . "',nombre='$nombre',apellidos='$apellidos',email='$email' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    /*
    //------------------------------------------------------------------------
    // Funcion para recuperar un usuario
    function recuperarUsuario($nick,$pass, $nombre, $apellidos, $email) {

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET passw='$contraseña',nombre='$nombre',apellidos='$apellidos',email='$email' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }
    
    //------------------------------------------------------------------------
    // Funcion para cambiar la contraseña
    function changePassword($passw,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET passw='password_hash($pass,PASSWORD_DEFAULT)' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    function editUserNick($nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET nick='$nick' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    function editUserNombre($nombre,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET nombre='$nombre' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    function editUserApellidos($apellidos,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET apellidos='$apellidos' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    function editUserEmail($email,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET email='$email' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    */

    //insertUser('raquel','contraseñara','Raquel','Molina Reche','raquel@correo.es','registrado');
    //insertUser('fran','contraseñafran','Fran','Apellido1 Apellido2','fran@correo.es','moderador');
    //insertUser('alex','contraseñaalex','Alex','Apellido1 Apellido2','alex@correo.es','gestor');
    //insertUser('javi','contraseñajavi','Javi','Apellido1 Apellido2','javi@correo.es','superusuario');
  
?>

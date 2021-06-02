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

        $evento = array('id' => 'id por defecto','nombre' => 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'fecha' => 'Fecha por defecto', 'motivo' => 'Motivo por defecto', 'descripcion' => 'Descripcion por defecto',
        'enlaceArtista' => 'Enlace por defecto', 'nombreArtista' => 'Artista por defecto', 'instaArtista' => 'Instagram por defecto', 'twArtista' => 'Twitter por defecto', 'publicado' => 'Publicado por defecto');
        
        //Realizamos consultas de evento

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el evento en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT id,nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado FROM eventos WHERE id=?");
        $consulta->bind_param("i",$idEv);

        $consulta->execute();
        $res = $consulta->get_result();
        
        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            //Devolvemos un array asociativo con la informacion requerida
            $evento = array('id' => $row['id'],'nombre' => $row['nombre'], 'lugar' => $row['lugar'], 'fecha' => $row['fecha'], 'motivo' => $row['motivo'], 'descripcion' => $row['descripcion'],
            'enlaceArtista' => $row['enlaceArtista'], 'nombreArtista' => $row['nombreArtista'], 'instaArtista' => $row['instaArtista'], 'twArtista' => $row['twArtista'],'publicado' => $row['publicado']);
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

    function getImagenes($idEv){

        $imagen= array( 'id' => 'id por defecto','src' => 'src por defecto','tipo' => 'Tipo por defecto');
        $imagenes;

        
        //Realizamos consultas de imagenes
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idImagen,src, tipo FROM imagenes WHERE idEvento=?");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $imagen = array('id' => $row['idImagen'],'src' => $row['src'],'tipo' => $row['tipo']);
                $imagenes[$i] = $imagen;
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
        $evento = array('id' => 'id por defecto','nombre' => 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'fecha' => 'Fecha por defecto', 'motivo' => 'Motivo por defecto', 'descripcion' => 'Descripcion por defecto',
        'enlaceArtista' => 'Enlace por defecto', 'nombreArtista' => 'Artista por defecto', 'instaArtista' => 'Instagram por defecto', 'twArtista' => 'Twitter por defecto', 'publicado' => 'Publicado por defecto','imgPortada' => 'Portada por defecto', 'urlEvento' => 'Url por defecto');
        
        $imgPortada ='Portada por defecto'; //url de la imagen portada
        $urlEvento = 'Url por defecto'; //url del evento

        //Realizamos consultas de eventos

        //Necesitamos el id de cada evento que haya en la tabla eventos

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD();

        //1.Consuultar todos los eventos
        $consulta = $mysqli->prepare("SELECT id,nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado FROM eventos");
        
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
                $evento = array('id' => $row['id'],'nombre' => $row['nombre'], 'lugar' => $row['lugar'], 'fecha' => $row['fecha'], 'motivo' => $row['motivo'], 'descripcion' => $row['descripcion'],
                'enlaceArtista' => $row['enlaceArtista'], 'nombreArtista' => $row['nombreArtista'], 'instaArtista' => $row['instaArtista'], 'twArtista' => $row['twArtista'], 'publicado' => $row['publicado'], 'imgPortada' => $imgPortada, 'urlEvento' => $urlEvento);

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
        $comentario = array('idComentario' => 'id defecto','nombreAutor' => 'Nombre por defecto', 'comentario' => 'Comentario por defecto', 'fecha' => 'fecha por defecto', 'modificado' => 'null');
        $fecha;
        
        //Realizamos consultas de comentarios
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idComentario,nombre, comentario, fecha, modificado FROM comentarios WHERE idEvento=?");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                //Completamos los campos
                $comentario = array('idComentario' => $row['idComentario'],'nombreAutor' => $row['nombre'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'modificado' => $row['modificado']);
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





    //------------------USUARIOS------------------------------

    //------------------------------------------------------------------------
    // Funcion para insertar un usuario
    function insertUser($nick,$passw, $nombre, $apellidos, $email, $tipo) {

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se inserta el usuario en la BD
        //$peticion = "INSERT INTO usuarios (nick,passw,nombre,apellidos,email,tipo) VALUES ('$nick','" . password_hash($passw,PASSWORD_DEFAULT) . "','$nombre','$apellidos','$email','$tipo')";  
        //$res = $mysqli->query($peticion);

        $consulta = $mysqli->prepare("INSERT INTO usuarios (nick,passw,nombre,apellidos,email,tipo) VALUES (?,?,?,?,?,?)");
        $consulta->bind_param("ssssss", $nick,password_hash($passw,PASSWORD_DEFAULT),$nombre, $apellidos, $email, $tipo);

        $consulta->execute();
        $res = $consulta->get_result();

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
    // Funcion para obtener la informacion de un usuario de la base de datos a partir de su nick
    function getNombreUsuario($nick) {
        $nombre;
        
        //Realizamos consultas de usuario
        
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el usuario en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT nombre FROM usuarios WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            $nombre = $row['nombre'];
        }

        //cerrar sentencia
        $consulta->close();


        return $nombre;
    }


    //------------------------------------------------------------------------
    // Funcion para obtener la informacion de un usuario de la base de datos a partir de su nick
    function getEmailUsuario($nick) {
        $email;
        
        //Realizamos consultas de usuario
        
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consulta el usuario en la BD
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT email FROM usuarios WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            $email = $row['email'];
        }

        //cerrar sentencia
        $consulta->close();

        return $email;
    }

    //------------------------------------------------------------------------
    // Funcion para editar un usuario
    /*
    function editUser($nick,$passw, $nombre, $apellidos, $email) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        //$peticion = "UPDATE usuarios SET nick='$nick',passw='" . password_hash($passw,PASSWORD_DEFAULT) . "',nombre='$nombre',apellidos='$apellidos',email='$email' WHERE nick='$nick'"; 
       //$res = $mysqli->query($peticion);

        $consulta = $mysqli->prepare("UPDATE usuarios SET nick=?,passw=?,nombre=?,apellidos=?,email=? WHERE nick=?");
        $consulta->bind_param("ssssss", $nick,password_hash($passw,PASSWORD_DEFAULT),$nombre, $apellidos, $email, $nick);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }*/

    //------------------------------------------------------------------------
    // Funcion para cambiar la contraseña
    function changePassword($passw,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET passw='" . password_hash($passw,PASSWORD_DEFAULT) . "' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    //------------------------------------------------------------------------
    //Funcion para editar el nick de un usuario
    function editUserNick($nicknuevo, $nickantiguo) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET nick='$nicknuevo' WHERE nick='$nickantiguo'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }
    
    //------------------------------------------------------------------------
    // Funcion para cambiar el nombre
    function editUserNombre($nombre,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET nombre='$nombre' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para cambiar los apellidos
    function editUserApellidos($apellidos,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET apellidos='$apellidos' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para cambiar el email
    function editUserEmail($email,$nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $peticion = "UPDATE usuarios SET email='$email' WHERE nick='$nick'"; 
        $res = $mysqli->query($peticion);

        return $res;
    }





    //------------------COMENTARIOS------------------------------

    //------------------------------------------------------------------------
    //Funcion para insertar un nuevo comentario
    function nuevoComentario($userNick, $idEvento, $texto){

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        $fecha = date("Y-m-d H:i:s");

        $nombre = getNombreUsuario($userNick);
        $email = getEmailUsuario($userNick);

        //2.Se inserta el usuario en la BD
        $consulta = $mysqli->prepare("INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES (?,?,?,?,?,false)");
        $consulta->bind_param("issss",$idEvento,$nombre,$email,$texto,$fecha);

        $consulta->execute();
        $res = $consulta->get_result();

        //cerrar sentencia
        $consulta->close();

        return $res;
       
    }

    //------------------------------------------------------------------------
    //Funcion para borrar un comentario
    function eliminarComentario($idComentario){

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.
        $consulta = $mysqli->prepare("DELETE FROM comentarios WHERE idComentario=?"); 
        $consulta->bind_param("i", $idComentario);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
       
    }

    //------------------------------------------------------------------------
    //Funcion para borrar todos los comentarios de un evento
    function eliminarComentariosEvento($idEvento){

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.
        $consulta = $mysqli->prepare("DELETE FROM comentarios WHERE idEvento=?"); 
        $consulta->bind_param("i", $idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
       
    }

    //------------------------------------------------------------------------
    //Funcion para obtener un comentario por su id
    function getComentario($idComentario){

        $comentario = array('idComentario' => 'id defecto','idEvento' => 'id defecto','nombreAutor' => 'Nombre por defecto', 'emailAutor' => 'Email por defecto', 'comentario' => 'Comentario por defecto', 'fecha' => 'fecha por defecto', 'modificado' => 'null');
        
        //Realizamos consultas de comentarios
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idComentario,idEvento,nombre,email, comentario, fecha, modificado FROM comentarios WHERE idComentario=?");
        $consulta->bind_param("i", $idComentario);

        $consulta->execute();
        $res = $consulta->get_result();

        if( $res->num_rows > 0){
            $row = $res->fetch_assoc(); //Para acceder como un diccionario
            //Completamos los campos
            $comentario = array('idComentario' => $row['idComentario'],'idEvento' => $row['idEvento'],'nombreAutor' => $row['nombre'],'emailAutor' => $row['email'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'modificado' => $row['modificado']);          
        }

        //cerrar sentencia
        $consulta->close();
        
        return $comentario;
    }

    //------------------------------------------------------------------------
    // Funcion para editar el nombre de un comentario
    function editNombreComentario($idComentario, $nombre) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el comentario en la BD
        $consulta = $mysqli->prepare("UPDATE comentarios SET nombre='$nombre',modificado=true WHERE idComentario=?"); 
        $consulta->bind_param("i", $idComentario);

        $consulta->execute();
        $res = $consulta->get_result();
        return $res;
    }


    //------------------------------------------------------------------------
     // Funcion para editar el email de un comentario
     function editEmailComentario($idComentario, $email) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el comentario en la BD
        $consulta = $mysqli->prepare("UPDATE comentarios SET email='$email',modificado=true WHERE idComentario=?");
        $consulta->bind_param("i", $idComentario);

        $consulta->execute();
        $res = $consulta->get_result(); 
        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para editar el texto de un comentario
    function editTextoComentario($idComentario, $texto) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el comentario en la BD
        $consulta = $mysqli->prepare("UPDATE comentarios SET comentario='$texto',modificado=true WHERE idComentario=?"); 
        $consulta->bind_param("i", $idComentario);

        $consulta->execute();
        $res = $consulta->get_result();
        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para obtener todos los comentarios
    function getAllComentarios(){

        $comentarios;
        $comentario = array('idComentario' => 'id defecto','nombreAutor' => 'Nombre por defecto', 'comentario' => 'Comentario por defecto', 'fecha' => 'fecha por defecto', 'modificado' => 'null');
        $fecha;
        
        //Realizamos consultas de comentarios
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idComentario,nombre, comentario, fecha, modificado FROM comentarios");

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                //Completamos los campos
                $comentario = array('idComentario' => $row['idComentario'],'nombreAutor' => $row['nombre'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'modificado' => $row['modificado']);
                //Insertamos el comentario en comentarios
                $comentarios[$i] = $comentario;

                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $comentarios;
    }

    //------------------------------------------------------------------------
    // Funcion para obtener todos los comentarios
    function buscarComentarios($contenido){

        $comentarios;
        $comentario = array('idComentario' => 'id defecto','nombreAutor' => 'Nombre por defecto', 'comentario' => 'Comentario por defecto', 'fecha' => 'fecha por defecto', 'modificado' => 'null');
        $fecha;
        
        //Realizamos consultas de comentarios
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idComentario,nombre, comentario, fecha, modificado FROM comentarios WHERE nombre LIKE '%$contenido%' OR comentario LIKE '%$contenido%'");
        //$consulta->bind_param('s',$contenido);


        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                //Completamos los campos
                $comentario = array('idComentario' => $row['idComentario'],'nombreAutor' => $row['nombre'], 'comentario' => $row['comentario'], 'fecha' => $row['fecha'], 'modificado' => $row['modificado']);
                //Insertamos el comentario en comentarios
                $comentarios[$i] = $comentario;

                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $comentarios;
    }



    //------------------EVENTOS------------------------------

    //Eliminar un evento
    function buscarEventos($contenido){

        $eventos; //Contendrá todos los eventos

        //Información de cada evento
        $evento = array('id' => 'id por defecto','nombre' => 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'fecha' => 'Fecha por defecto', 'motivo' => 'Motivo por defecto', 'descripcion' => 'Descripcion por defecto',
        'enlaceArtista' => 'Enlace por defecto', 'nombreArtista' => 'Artista por defecto', 'instaArtista' => 'Instagram por defecto', 'twArtista' => 'Twitter por defecto','imgPortada' => 'Portada por defecto', 'urlEvento' => 'Url por defecto');
        
        $imgPortada ='Portada por defecto'; //url de la imagen portada
        $urlEvento = 'Url por defecto'; //url del evento

        //Realizamos consultas de eventos

        //Necesitamos el id de cada evento que haya en la tabla eventos

        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD();

        //1.Consuultar todos los eventos
        if($contenido !== ""){
            $pablabra = "%".$contenido."%";
        }
        else{
            $pablabra = "";
        }
        
        $consulta = $mysqli->prepare("SELECT * FROM eventos WHERE descripcion LIKE ? or nombre LIKE ?");
        $consulta->bind_param('ss',$pablabra,$pablabra);
        
        $consulta->execute();
        $res = $consulta->get_result();
        
        $i = 0;
        if( $res->num_rows > 0){
            //echo("-encontrado--");
            while( $row = $res->fetch_assoc() ){ //Por cada fila y por tanto por cada evento

                //Obtenemos el id del evento 
                $id_ev = $row['id'];

                //Calculamos la url
                $urlEvento = "/evento.php/?ev=" . $id_ev;

                //Obtenemos la img que es portada
                $imgPortada = getPortada($id_ev);

                //Completamos los campos
                $evento = array('id' => $row['id'],'nombre' => $row['nombre'], 'lugar' => $row['lugar'], 'fecha' => $row['fecha'], 'motivo' => $row['motivo'], 'descripcion' => $row['descripcion'],
                'enlaceArtista' => $row['enlaceArtista'], 'nombreArtista' => $row['nombreArtista'], 'instaArtista' => $row['instaArtista'], 'twArtista' => $row['twArtista'], 'publicado' => $row['publicado'], 'imgPortada' => $imgPortada, 'urlEvento' => $urlEvento);

                //Insertamos el evento en eventos
                $eventos[$i] = $evento;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();

        return $eventos;
    }

    //Eliminar un evento
    function eliminarEvento($idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se eliminan las etiquetas del evento
        eliminarEtiquetasEvento($idEvento);

        //3.Se eliminan las imagenes del evento
        eliminarImagenesEvento($idEvento);

        //4.Se eliminan los comentarios del evento
        eliminarComentariosEvento($idEvento);

        //5.Se elimina el evento
        $consulta = $mysqli->prepare("DELETE FROM eventos WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //------------------------------------------------------------------------
    // Funcion para editar el nombre de un evento
    function editNombreEvento($idEvento,$nombre) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET nombre='$nombre' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    function editLugarEvento($idEvento,$lugar){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET lugar='$lugar' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    function editFechaEvento($idEvento,$fecha){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET fecha='$fecha' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    function editMotivoEvento($idEvento,$motivo){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET motivo='$motivo' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }
    
    function editDescripcionEvento($idEvento,$descripcion){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET descripcion='$descripcion' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }
    
    function editEnlaceArtistaEvento($idEvento,$enlaceArtista){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET enlaceArtista='$enlaceArtista' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }
    
    function editNombreArtistaEvento($idEvento,$nombreArtista){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET nombreArtista='$nombreArtista' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }
    
    function editInstaArtistaEvento($idEvento,$instaArtista){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET instaArtista='$instaArtista' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }
    
    function editTwArtistaEvento($idEvento,$twArtista){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET twArtista='$twArtista' WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Funcion para editar el estado del evento a publcado
    function publicarEvento($idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET publicado=true WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Funcion para editar el estado del evento a no publcado
    function ocultarEvento($idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("UPDATE eventos SET publicado=false WHERE id=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Eliminar una imagen de un evento
    function eliminarImagen($idImagen){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("DELETE FROM imagenes WHERE idImagen=?");
        $consulta->bind_param('i',$idImagen);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Eliminar todas las imagenes de un evento
    function eliminarImagenesEvento($idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.
        $consulta = $mysqli->prepare("DELETE FROM imagenes WHERE idEvento=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Añadir una imagen portada a un evento
    function addImagenPortada( $srcImagen,$idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("INSERT INTO imagenes (idEvento, src, tipo) VALUES (?,?,'portada')");
        $consulta->bind_param('is',$idEvento,$srcImagen);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Añadir una imagen galeria un evento
    function addImagenGaleria( $srcImagen,$idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("INSERT INTO imagenes (idEvento, src, tipo) VALUES (?,?,'galeria')");
        $consulta->bind_param('is',$idEvento,$srcImagen);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Obtener las etiquetas de un evento
    function getEtiquetas($idEv){

        $etiqueta= array( 'id' => 'id por defecto','etiqueta' => 'etiqueta por defecto');
        $etiquetas;

        
        //Realizamos consultas de imagenes
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se consultan las imagenes del evento en la BD (Aquellas que son de tipo galeria)
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idEtiqueta,etiqueta FROM etiquetas WHERE idEvento=?");
        $consulta->bind_param("i", $idEv);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $etiqueta = array('id' => $row['idEtiqueta'],'etiqueta' => $row['etiqueta']);
                $etiquetas[$i] = $etiqueta;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();
        
        return $etiquetas;
    }
    

    //Eliminar una etiqueta de un evento
    function eliminarEtiqueta($idEtiqueta){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("DELETE FROM etiquetas WHERE idEtiqueta=?");
        $consulta->bind_param('i',$idEtiqueta);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Eliminar todas etiqueta de un evento
    function eliminarEtiquetasEvento($idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("DELETE FROM etiquetas WHERE idEvento=?");
        $consulta->bind_param('i',$idEvento);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    //Añadir una etiqueta a un evento
    function addEtiqueta( $etiqueta,$idEvento){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el evento en la BD
        $consulta = $mysqli->prepare("INSERT INTO etiquetas (idEvento, etiqueta) VALUES (?,?)");
        $consulta->bind_param('is',$idEvento,$etiqueta);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }


    //Añadir un nuevo evento
    function addEvento($nombre,$lugar,$fecha,$motivo,$descripcion,$enlaceArtista,$nombreArtista,$instaArtista,$twArtista){
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2. Se inserta el evento
        $consulta = $mysqli->prepare("INSERT INTO eventos (nombre, lugar, fecha, motivo,  descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista) VALUES (?,?,?,?,?,?,?,?,?)");
        $consulta->bind_param('sssssssss',$nombre,$lugar,$fecha,$motivo,$descripcion,$enlaceArtista,$nombreArtista,$instaArtista,$twArtista);

        $consulta->execute();
        $res = $consulta->get_result();      

        return $res;
    }

    function getEventosEtiqueta($etiqueta){


        //Obtener los id de los eventos con esa etiqueta
        $ids;
        $etiquetas = array();

        
        //Realizamos consultas de imagenes
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.
        //Prevenir inyecciones de SQL o de otro código
        $consulta = $mysqli->prepare("SELECT idEvento FROM etiquetas WHERE etiqueta=?");
        $consulta->bind_param("s", $etiqueta);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;

        if( $res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                $ids = $row['idEvento'];
                $etiquetas[$i] = $ids;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();

        $eventos; //Contendrá todos los eventos

        //Información de cada evento
        $evento = array('id' => 'id por defecto','nombre' => 'Nombre por defecto', 'lugar' => 'Lugar por defecto', 'fecha' => 'Fecha por defecto', 'motivo' => 'Motivo por defecto', 'descripcion' => 'Descripcion por defecto',
        'enlaceArtista' => 'Enlace por defecto', 'nombreArtista' => 'Artista por defecto', 'instaArtista' => 'Instagram por defecto', 'twArtista' => 'Twitter por defecto','publicado' => 'Publicado por defecto','imgPortada' => 'Portada por defecto', 'urlEvento' => 'Url por defecto');
        
        $imgPortada ='Portada por defecto'; //url de la imagen portada
        $urlEvento = 'Url por defecto'; //url del evento

        $j = 0;
        $i = 0;

        while($j != sizeof($etiquetas)){
          
            $id=$etiquetas[$j];
            
            //Realizamos consultas de eventos

            //Necesitamos el id de cada evento que haya en la tabla eventos

            //1. Conexion
            //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
            $mysqli = conexionBD();

            //1.Consuultar todos los eventos
            $consulta = $mysqli->prepare("SELECT id,nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado FROM eventos WHERE id=?");
            $consulta->bind_param("i", $id);

            $consulta->execute();
            $res = $consulta->get_result();
            
           
            if( $res->num_rows > 0){
                while( $row = $res->fetch_assoc() ){ //Por cada fila y por tanto por cada evento

                    //Obtenemos el id del evento 
                    $id_ev = $row['id'];

                    //Calculamos la url
                    $urlEvento = "/evento.php/?ev=" . $id_ev;

                    //Obtenemos la img que es portada
                    $imgPortada = getPortada($id_ev);

                    //Completamos los campos
                    $evento = array('id' => $row['id'],'nombre' => $row['nombre'], 'lugar' => $row['lugar'], 'fecha' => $row['fecha'], 'motivo' => $row['motivo'], 'descripcion' => $row['descripcion'],
                    'enlaceArtista' => $row['enlaceArtista'], 'nombreArtista' => $row['nombreArtista'], 'instaArtista' => $row['instaArtista'], 'twArtista' => $row['twArtista'], 'publicado' => $row['publicado'], 'imgPortada' => $imgPortada, 'urlEvento' => $urlEvento);

                    //Insertamos el evento en eventos
                    $eventos[$i] = $evento;
                    $i++;
                }
            }

            //cerrar sentencia
            $consulta->close();

            $j++;

        }
        
        
        return $eventos;
    }


    //------------------USUARIOS------------------------------------

    //Obtiene todos los usuairos del sistema menos el que se pasa por parametro
    function getUsuarios($nickUsuario){

        $usuarios; 

        //Información de cada usuario
        $usuario = array('nick' => 'Nick por defecto', 'passw' => 'Contraseña por defecto', 'tipo' => 'Tipo por defecto',
                            'nombre' => 'Nombre por defecto','apellidos' => 'Apellidos por defecto','email' => 'Email por defecto',    );
        
        //Realizamos consultas de usuario
        
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //1.Consuultar todos los eventos
        $consulta = $mysqli->prepare("SELECT nick,passw,nombre,apellidos,email,tipo FROM usuarios WHERE nick!=?");
        $consulta->bind_param('s',$nickUsuario);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;
        if( $res->num_rows > 0){
            while( $row = $res->fetch_assoc() ){ //Por cada fila y por tanto por cada evento

                $usuario = array('nick' => $row['nick'], 'passw' => $row['passw'], 'tipo' => $row['tipo'],'nombre' => $row['nombre'],'apellidos' => $row['apellidos'],'email' => $row['email']);
                //Insertamos el evento en eventos
                $usuarios[$i] = $usuario;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();

        return $usuarios;
    }

    //Obtiene todos los usuairos del sistema menos el que se pasa por parametro
    function getUsuariosNick($nickUsuario){

        $usuarios; 

        //Información de cada usuario
        $usuario = array('nick' => 'Nick por defecto', 'passw' => 'Contraseña por defecto', 'tipo' => 'Tipo por defecto',
                            'nombre' => 'Nombre por defecto','apellidos' => 'Apellidos por defecto','email' => 'Email por defecto',    );
        
        //Realizamos consultas de usuario
        
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //1.Consuultar todos los eventos
        $consulta = $mysqli->prepare("SELECT nick,passw,nombre,apellidos,email,tipo FROM usuarios WHERE nick=?");
        $consulta->bind_param('s',$nickUsuario);

        $consulta->execute();
        $res = $consulta->get_result();

        $i = 0;
        if( $res->num_rows > 0){
            while( $row = $res->fetch_assoc() ){ //Por cada fila y por tanto por cada evento

                $usuario = array('nick' => $row['nick'], 'passw' => $row['passw'], 'tipo' => $row['tipo'],'nombre' => $row['nombre'],'apellidos' => $row['apellidos'],'email' => $row['email']);
                //Insertamos el evento en eventos
                $usuarios[$i] = $usuario;
                $i++;
            }
        }

        //cerrar sentencia
        $consulta->close();

        return $usuarios;
    }


    // Funcion para cambiar los permisos a un ususrio
    function usuarioRegistrado($nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $consulta = $mysqli->prepare("UPDATE usuarios SET tipo='registrado' WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    // Funcion para cambiar los permisos a un ususrio
    function usuarioModerador($nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $consulta = $mysqli->prepare("UPDATE usuarios SET tipo='moderador' WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    // Funcion para cambiar los permisos a un ususrio
    function usuarioGestor($nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $consulta = $mysqli->prepare("UPDATE usuarios SET tipo='gestor' WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }

    // Funcion para cambiar los permisos a un ususrio
    function usuarioSuperusuario($nick) {
        //1. Conexion
        //El mismo metodo conexionBD maneja que solo se realice la conexion en la primera consulta a la BD
        $mysqli = conexionBD(); 

        //2.Se modifica el usuario en la BD
        $consulta = $mysqli->prepare("UPDATE usuarios SET tipo='superusuario' WHERE nick=?");
        $consulta->bind_param('s',$nick);

        $consulta->execute();
        $res = $consulta->get_result();

        return $res;
    }


    //INSERTAR USUARIOS
    /*
    insertUser('raquel','123456','Raquel','Apellido1 Apellido2','raquel@correo.es','superusuario');
    insertUser('fran','123456','Fran','Apellido1 Apellido2','fran@correo.es','moderador');
    insertUser('alex','123456','Alex','Apellido1 Apellido2','alex@correo.es','gestor');
    insertUser('laura','123456','Laura','Apellido1 Apellido2','laura@correo.es','registrado');
    insertUser('ana','123456','Ana','Apellido1 Apellido2','ana@correo.es','moderador');
    insertUser('javi','123456','Javi','Apellido1 Apellido2','javi@correo.es','registrado');
    insertUser('paula','123456','Paula','Apellido1 Apellido2','paula@correo.es','gestor');
    insertUser('sara','123456','Sara','Apellido1 Apellido2','sara@correo.es','superusuario');
    */
  
?>

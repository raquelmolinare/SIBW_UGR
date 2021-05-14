//Array de palabras prohibidas
var palabrasProhibidas = [];

//---------------------------------------------------------------------
//Funcion para añadir las palabras prohibidas una vez cargado el documento
document.addEventListener('DOMContentLoaded', () => {

    //Se obtienen los elementos con clase prohibidas
    var prohibidas = document.getElementsByClassName("prohibidas");

    //Por cada elemento en prohibidas se obtiene su id y se inserta en el array  de palabras prohibidas
    for (var i = 0; i< prohibidas.length; i++){
        var palabra = prohibidas[i].id;
        palabrasProhibidas.push(palabra);
    }
});

//---------------------------------------------------------------------
//Funcion para desplegar y cerrar el panel de comentarios
function desplegarPanel(){

    var panel = document.getElementById("panelComentarios");

    if(panel.style.display == "block" ){ //Si está visible
        panel.style.display = "none";
    } 
    else{ //Si está oculto
        panel.style.display = "block";
    }
}

//---------------------------------------------------------------------
//Acción del botón de comentarios
var boton = document.getElementById("botonComentarios");
boton.addEventListener("click", desplegarPanel);

//---------------------------------------------------------------------
//Acción del botón para cerrar comentarios
var boton = document.getElementById("closeComentarios");
boton.addEventListener("click", desplegarPanel);

//---------------------------------------------------------------------
//Acción del campo de comentarios pendiente cuando se escribe
var textoComentario = document.getElementById("comentarioInput");
textoComentario.oninput = comprobacionComentario;

//---------------------------------------------------------------------
//Funcion que va comprobando el campo del comentario, si hay una palabra prohibida se cambia por asteriscos
function comprobacionComentario(){

    //Obtenemos el texto del comentario
    var texto = document.getElementById("comentarioInput").value;
    
    var palabraProhibida = "";
    var palabraCorregida = "";

    //Pasamos la cadena de texto toda a minusculas para compararlo con las palabras prohibidas que están en el array en minuscula
    texto = texto.toLowerCase();

    //Se comprueba para cada palabra en el lista de palabras prohibidas si alguna coincide
    for (var i = 0; i < palabrasProhibidas.length; i++){

        //Si la palabra del texto coincide con la palabra prohibida en la posicion i del array de palabra Prohibidas
        //( El método match() se usa para obtener todas las ocurrencias de una expresión dentro de una cadena )
        //Devuelve null si no coinciden ocurrencias
        if( texto.match(palabrasProhibidas[i]) ){
            
            //Se guarda la palabra que haya que censurar
            palabraProhibida = palabrasProhibidas[i];

            //Se crea una palabra de asteriscos de la misma longitud
            for (var j = 0; j < palabraProhibida.length; j++){
                palabraCorregida += "*";
            }

            //Se reemplaza la palabra prohibida por la palabra de asteriscos
            texto = texto.replace(palabraProhibida,palabraCorregida);

            //Se cambia en el campo del comentario
            document.getElementById("comentarioInput").value =texto;
        }
    }
}

//---------------------------------------------------------------------
//Acción del botón para enviar comentarios
var boton = document.getElementById("enviarComentario");
boton.addEventListener("click", addComentario);


//---------------------------------------------------------------------
//Funcion para añadir el comentario comprobando si es correcto, 
//y en ese caso llamar al método correspondiente para crearlo
function addComentario() {

    //-----1. Obtenemos el contenido de los campos del formulario-----
    var nombre = document.getElementById("nombreInput").value;
    var email = document.getElementById("emailInput").value;
    var texto = document.getElementById("comentarioInput").value;

    var fecha = generarFechaHora();

    //-----2. Si los campos son válidos se crea el comentario-----
    if( !hayCamposVacios(nombre,email,texto) && validarEmail(email) ){
       
        //2.1 Crear Comentario
        crearComentario(nombre,texto,fecha);

        //2.2 Limpiamos campos
        document.getElementById("nombreInput").value = "";
        document.getElementById("emailInput").value = "";
        document.getElementById("comentarioInput").value ="";
    }
}

//---------------------------------------------------------------------
//Funcion para crear el comentario una vez es correcto
function crearComentario(autor, texto, fecha) {

    //-----1. Creamos los contenedores y elementos que conforman el comentario-----
    //1.1 Creamos el div que contiene al comentario
    var nuevoComentario = document.createElement("div");
    nuevoComentario.className = "comentario";

    //1.2 Creamos la imagen del perfil
    var nuevoImgPerfil = document.createElement("div");
    nuevoImgPerfil.id = "contenedorImgProfile";

    //clonamos el objeto para asignarlo despues
    var profile = document.getElementById("imgProfile");
    var clonProfile = profile.cloneNode(true);

    //1.3 Creamos el h1 que contiene el nombre del autor
    var nuevoAutor = document.createElement("h1");

    //1.4 Creamos el div que contiene el texto del comentario
    var nuevoCommentTexto = document.createElement("div");
    nuevoCommentTexto.id = "textoComentario";

    //1.5 Creamos el parrafo del texto
    var nuevoTexto = document.createElement("p");

    //1.6 Creamos el h2 de la fecha y hora del comentario
    var nuevaFecha = document.createElement("h2");

    
    //-----2. Completamos con el texto correspondiente-----
    nuevoAutor.innerText = autor;
    nuevoTexto.innerText = texto;
    nuevaFecha.innerText = fecha;

    //-----3. Añadimos-----
    //La imagen del profile
    nuevoImgPerfil.appendChild(clonProfile);
    nuevoComentario.appendChild(nuevoImgPerfil);
    //El autor
    nuevoComentario.appendChild(nuevoAutor);
    //El texto del comentario
    nuevoCommentTexto.appendChild(nuevoTexto);
    nuevoComentario.appendChild(nuevoCommentTexto);
    //La fecha
    nuevoComentario.appendChild(nuevaFecha);

    //Lo introducimos debajo de los comentarios que ya haya
    document.getElementsByClassName("comentarios")[0].appendChild(nuevoComentario);

}


//---------------------------------------------------------------------
//Funcion para obtener la fecha y hora actual
function generarFechaHora() {

    var date = new Date();

    //Fecha
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    var mesNum= date.getMonth();

    var fecha = date.getDate()+ " de " + meses[mesNum] + " " + date.getFullYear();

    //Hora
    var horas = date.getHours();
    var minutos = date.getMinutes();

    if( horas.toString().length == 1){
        horas = "0"+horas;
    }

    if( minutos.toString().length == 1){
        minutos = "0"+minutos;
    }

    var hora = horas + ":" + minutos;
    
    //Fotmato de resultado (variable a devolver)
    var resultado = fecha + " • " + hora;

    return resultado;
   
}


//---------------------------------------------------------------------
//Funcion para comprobar si hay algún campo vacío
function hayCamposVacios(nombre,email,texto) {

    var result = false;

    //Comprobar contenido autor , email y texto
    if( nombre == "" || email == "" || texto == ""){ //Si es vacío
        alert("Todos los campos son obligatorios.\nPor favor completa el formulario.");
        result = true;
    }

    return result;
   
}

//---------------------------------------------------------------------
//Funcion para comprobar que el formato de email es correcto
function validarEmail(email) {

    var result = true;

    //Comprobar contenido email mediante expresion regular
    if( !(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(email))){ //Si no es valido
        alert("Dirección email no válida.\nPor favor intruduzca un email válido.");
        result = false;
    }

    return result;
   
}


/*
//---------------------------------------------------------------------
//Funcion para realizar la busqueda de eventos segun se va escribiendo
document.addEventListener('DOMContentLoaded', () => { $('#evento').keyup(  
    
    function(){

        var consulta = $(this).val(); //Contenido del input

        $.ajax( 
            function(){
                url: "index.php",
                method: "POST",
                data: {consulta: consulta},
                success:
            };
        );


    } )
});

*/

//---------------------------------------------------------------------
//Funcion para realizar la busqueda de eventos segun se va escribiendo
$(document).ready(function() {
    $('#eventobusqueda').keyup( hacerPeticionAjax);    
});
  
function hacerPeticionAjax() {

    var consulta = $(this).val(); //Contenido del input

    $.ajax({
        url: "search.php",
        method: "POST",
        data: {consulta},
        success: function(respuesta){
            procesaRespuestaAjax(respuesta, consulta);
        }
    });
    
}


function procesaRespuestaAjax(respuesta, cadena) {
    console.log(respuesta)
    document.getElementById("listabusqueda").innerHTML = respuesta;

    texto = respuesta;
    cadena = cadena.toUpperCase();
    console.log(cadena);
}
  
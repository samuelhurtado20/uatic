$(document).on('ready',function(){
   
    // traemos los estados al cargar la pagina
    $('#estado').load('http://www.chaima.org/proyecto/estados');


    // Creamos el evento change para detectar el elemento elegido
    $("#estado").change(function () {
        $("#estado option:selected").each(function () {
                            // capturamos el valor elegido
                elegido=$(this).val();
                            // Llamamos al archivo estado.php
                    $.post("http://www.chaima.org/proyecto/municipios", { elegido: elegido }, function(data){
                                    // Asignamos las nuevas opciones para el combo2
                        $("#municipio").html(data);
                                    // reseteamos el combo3
                        $("#parroquia").html("");
                    });        
            });
     });
     
     $("#municipio").change(function () {
        $("#municipio option:selected").each(function () {
                            // capturamos el valor elegido
                elegido=$(this).val();
                            // Llamamos al archivo estado.php
                    $.post("http://www.chaima.org/proyecto/parroquias", { elegido: elegido }, function(data){
                                    // Asignamos las nuevas opciones para el combo2
                        $("#parroquia").html(data);
                        
                    });        
            });
     });
     
   
   $(".numerico").numeric({allow:"."});

    $('#files').change(function(e){
                $('#list').empty();
    });


    $('#estado2').load('http://www.chaima.org/proyecto/estados');

    // Creamos el evento change para detectar el elemento elegido
    $("#estado2").change(function () {
        $("#estado2 option:selected").each(function () {
                            // capturamos el valor elegido
                elegido=$(this).val();
                            // Llamamos al archivo estado.php
                    $.post("http://www.chaima.org/proyecto/municipios", { elegido: elegido }, function(data){
                                    // Asignamos las nuevas opciones para el combo2
                        $("#municipio2").html(data);
                    });        
            });
     });
     
     

});

$(document).on('ready',function(){
    $('#modelo_vivienda').load('modelos');
    // traemos los estados al cargar la pagina
    $('#estado').load('estados');

    // Creamos el evento change para detectar el elemento elegido
    $("#estado").change(function () {
        $("#estado option:selected").each(function () {
                            // capturamos el valor elegido
                elegido=$(this).val();
                            // Llamamos al archivo estado.php
                    $.post("municipios", { elegido: elegido }, function(data){
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
                    $.post("parroquias", { elegido: elegido }, function(data){
                                    // Asignamos las nuevas opciones para el combo2
                        $("#parroquia").html(data);
                        
                    });

                    $.post("responsables", { elegido: elegido }, function(data){
                                    // Asignamos las nuevas opciones para el combo2
                        $("#responsable_uatic").html(data);
                        
                    });        
            });
     });
     
   $("#parroquia").change(function () {
        $("#parroquia option:selected").each(function () {
                        // capturamos el valor elegido
            elegido=$(this).val();
                        // Llamamos al archivo estado.php
                $.post("consejos", { elegido: elegido }, function(data){
                                // Asignamos las nuevas opciones para el combo2
                    $("#consejo").html(data);
                });        
        }); 
   });
   
   $("#modelo_vivienda").change(function () {
                        var id = $("#modelo_vivienda").val();
                        
                        $.post("area", { id: id },
                          function(data){
                            $("#m2").val(data);
                        });

                        $.post("cuartos", { id: id },
                          function(data){
                            $("#n_cuartos").val(data);
                        });
                        $.post("banos", { id: id },
                          function(data){
                            $("#n_banos").val(data);
                        });
    });

   $("#responsable_uatic").change(function () {
                var id = $("#responsable_uatic").val();
                        
                        $.post("telefono_uatic", { id: id },
                          function(data){
                            $("#telefono_uatic").val(data);
                        });
     });
    
    $("#uno").click(function(){
        $("#primero").css("display", "block");        
        $("#segundo").css("display", "none");
        $("#tercero").css("display", "none");
        $("#cuarto").css("display", "none");
        $("#quinto").css("display", "none"); 
        $("#uno").addClass("activo");
        $("#dos").removeClass("activo");
        $("#tres").removeClass("activo");
        $("#cuatro").removeClass("activo");
        $("#cinco").removeClass("activo");
    });
    $("#dos").click(function(){
        $("#primero").css("display", "none");        
        $("#segundo").css("display", "block");
        $("#tercero").css("display", "none");
        $("#cuarto").css("display", "none");
        $("#quinto").css("display", "none"); 
        $("#uno").removeClass("activo");
        $("#dos").addClass("activo");
        $("#tres").removeClass("activo");
        $("#cuatro").removeClass("activo");
        $("#cinco").removeClass("activo");
    });
    $("#tres").click(function(){
        $("#primero").css("display", "none");        
        $("#segundo").css("display", "none");
        $("#tercero").css("display", "block");
        $("#cuarto").css("display", "none");
        $("#quinto").css("display", "none"); 
        $("#uno").removeClass("activo");
        $("#dos").removeClass("activo");
        $("#tres").addClass("activo");
        $("#cuatro").removeClass("activo");
        $("#cinco").removeClass("activo");
    });
    $("#cuatro").click(function(){
        $("#primero").css("display", "none");        
        $("#segundo").css("display", "none");
        $("#tercero").css("display", "none");
        $("#cuarto").css("display", "block");
        $("#quinto").css("display", "none"); 
        $("#uno").removeClass("activo");
        $("#dos").removeClass("activo");
        $("#tres").removeClass("activo");
        $("#cuatro").addClass("activo");
        $("#cinco").removeClass("activo");
    });
    $("#cinco").click(function(){
        $("#primero").css("display", "none");        
        $("#segundo").css("display", "none");
        $("#tercero").css("display", "none");
        $("#cuarto").css("display", "none");
        $("#quinto").css("display", "block"); 
        $("#uno").removeClass("activo");
        $("#dos").removeClass("activo");
        $("#tres").removeClass("activo");
        $("#cuatro").removeClass("activo");
        $("#cinco").addClass("activo");
    });
    
    $("[name=fecha_inicio],[name=fecha_culminacion]").datepicker({
            autoSize: true,
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesMin: ['Dom', 'Lu', 'Ma', 'Mi', 'Je', 'Vi', 'Sa'],
            firstDay: 1,
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+0"		
    });

});


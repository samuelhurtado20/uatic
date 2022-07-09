$(document).on('ready',function(){
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
    /* funciones para cargar el autocomplete de partidas  */
    $("#descripcion").autocomplete(
    {
         source:'/uatic/partida/listar/', 
         minLength: 3,
         select: function(event, ui) {
                $("#id_partidas").val(ui.item.id_partidas);
                $("#descripcion").val(ui.item.label);
                $("#unidad").val(ui.item.unidad);
                $("#precio").val(ui.item.precio);
            }

    });
    $("#cantidad, #precio").keyup(function () {

        if (($("#cantidad").val() !=="") && ($("#precio").val() !=="")) {

            var cantidad = $("#cantidad").val();
            var precio = $("#precio").val();
            var monto = parseFloat(cantidad) * parseFloat(precio);
            var monto2 = monto.toFixed(2);
            $("#total").val(parseFloat(monto2));
        }

    });

    $(".numerico").numeric({allow:"."});

    $('.flexslider').flexslider({
        controlsContainer: '.flex-container',
        slideshow: false
    });
 
});
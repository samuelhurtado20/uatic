$(document).on('ready',function(){
    /* funciones para cargar el autocomplete de materiales  */
    $("#descripcion").autocomplete(
    {
         source:'/uatic/material/', 
         minLength: 3,
         select: function(event, ui) {
                $("#id_materiales").val(ui.item.id_materiales);
                $("#descripcion").val(ui.item.label);
                $("#unidad2").val(ui.item.unidad);
                $("#precio").val(ui.item.precio);
            }

    });
    

    $("#cantidad, #precio").keyup(function () {

        if (($("#cantidad").val() !=="") && ($("#precio").val() !=="")) {

            var cantidad = $("#cantidad").val();
            var precio = $("#precio").val();
            var monto = parseFloat(cantidad) * parseFloat(precio);
            var monto2 = monto.toFixed(2);
            $("#monto").val(parseFloat(monto2));
        }

    });
    
    /* funciones para cargar el autocomplete de EQUIPOS  */
    $("#descripcion_e").autocomplete(
    {
         source:'/uatic/equipo/', 
         minLength: 3,
         select: function(event, ui) {
                $("#id_equipo").val(ui.item.id_equipo);
                $("#descripcion_e").val(ui.item.label);
                $("#unidad_e").val(ui.item.unidad);
                $("#cop").val(ui.item.cop);
                $("#precio_e").val(ui.item.precio_e);
            }

    });

    $("#cantidad_e, #precio_e").keyup(function () {

        if (($("#cantidad_e").val() !=="") && ($("#precio_e").val() !=="")&& ($("#cop").val() !=="")) {

            var cantidad_e = $("#cantidad_e").val();
            var precio_e = $("#precio_e").val();
            var cop = $("#cop").val();
            var monto_e = parseFloat(cantidad_e) * parseFloat(precio_e)* parseFloat(cop);
            var monto2_e = monto_e.toFixed(2);
            $("#monto_e").val(parseFloat(monto2_e));
        }

    });
    
    
    /* funciones para cargar el autocomplete de MANO DE OBRA  */
    $("#descripcion_m").autocomplete(
    {
         source:'/uatic/mano/', 
         minLength: 3,
         select: function(event, ui) {
                $("#id_mano").val(ui.item.id_mano);
                $("#descripcion_m").val(ui.item.label);
                $("#unidad_m").val(ui.item.unidad);
                $("#jornal").val(ui.item.jornal);
            }

    });

    $("#cantidad_m, #jornal").keyup(function () {

        if (($("#cantidad_m").val() !=="") && ($("#jornal").val() !=="")) {

            var cantidad_m = $("#cantidad_m").val();
            var jornal = $("#jornal").val();
            var monto_m = parseFloat(cantidad_m) * parseFloat(jornal);
            var monto2_m = monto_m.toFixed(2);
            $("#monto_m").val(parseFloat(monto2_m));
        }

    });
});

$(document).on('ready',function(){
    $("#accordion").accordion();

    
    $("input[name='ejecutado']").keyup(function () {           
                var acumulado = $(this).prev('[type=hidden]').val();        
                var ejecutado = $(this).val();        
                var total = parseFloat(acumulado) + parseFloat(ejecutado);
                var monto = total.toFixed(2);
            if ($(this).val() !==""){
                $(this).next('[type=text]').val(monto);
                $("input[name='cantidad']").trigger('keyup');
            }
            else {
                $(this).next('[type=text]').val("");
                $("input[name='cantidad']").trigger('keyup');
       }
    });
    
    $("input[name='cantidad']").keyup(function () {           
                var acumulado = $(this).prev('[type=text]').val();        
                var cantidad = $(this).val();        
                var total = parseFloat(cantidad) - parseFloat(acumulado);
                var monto = total.toFixed(2);
            if ($(this).prev('[type=text]').val() !==""){
                $(this).next('[type=text]').val(monto);
                
            }
            else {
                $(this).next('[type=text]').val("");
       }
    });
    
    $("form").submit(function(){
	
		if ($(this).find("[name=resta]").val() < 0)
		{
                    alert('la cantidad ejecutada es superior a la esperada');
                    return false;
                }
	 		
    });
    
    $("[name=f_inicio],[name=f_final]").datepicker({
            autoSize: true,
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesMin: ['Dom', 'Lu', 'Ma', 'Mi', 'Je', 'Vi', 'Sa'],
            firstDay: 1,
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-90:+0"		
    });
    
});


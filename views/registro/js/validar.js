$(document).on('ready',function(){
	// Configuramos la validación de los distintos campos del formulario
	$("#clave").validate({
		// Empezamos por las reglas
		rules: {
			vieja: {  // reglas para el campo password
				required: true, // Tienes que ser requerido
				minlength: 5    // Tiene que tener un tamaño mayor o igual a cinco caracteres
			},
			nueva: {  // reglas para el campo password
				required: true, // Tienes que ser requerido
				minlength: 5    // Tiene que tener un tamaño mayor o igual a cinco caracteres
			},
			confirmar: { // reglas para el campo confirm_password
				required: true, // Tienes que ser requerido 
				minlength: 5,   // Tiene que tener un tamaño mayor o igual a cinco caracteres
				equalTo: "#nueva"  // Tiene que ser igual que el campo password y para ello indicamos su id
			}
		},
		messages: { // La segunda parte es configurar los mensajes, por lo que tengo que ir indicando para cada campo y cada regla el mensaje que quiero mostrar si no se cumple.
			
			vieja: {
				required: "Por favor, introduzca su clave actual",
				minlength: "Su clave actual debe de tener al menos 5 caracteres"
			},
			nueva: {
				required: "Por favor, introduzca su nueva clave",
				minlength: "Su nueva clave debe de tener al menos 5 caracteres"
			},
			confirmar: {
				required: "Por favor, repita su nueva clave",
				minlength: "Su nueva clave debe de tener al menos 5 caracteres",
				equalTo: "Las password introducidas no son iguales"
			}
		}
	});
});
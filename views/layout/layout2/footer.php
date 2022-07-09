            </div>
         
<div id="footer">

	        <div id="iniciar2">
                	<img id="imagen" src="<?php echo BASE_URL;?>views/registro/imagenes/<?php echo Session::get('foto'); ?>" width="80px" height="80px" align="middle">           	
            </div>
            <div id="captcha2">
                	<label>usuario:</label>
                	<br>
                	<label><?php echo Session::get('nombre').' '.Session::get('apellido') ; ?></label>
                	<br>
                	<label><?php echo Session::get('nivel'); ?></label>
                	<br>
                	<h4><a href="<?php echo BASE_URL;?>registro/editar/<?php echo Session::get('id_usuario'); ?>">Administrar cuenta</a></h4>
                	
            </div>
	        <div id="captcha2">
	        	<label>tipo de usuario:</label><br>
                	<label >
                        <?php 
                		if (Session::get('level')=="admin") {
                			echo "Tecnico De Sistema";
                        ?>
                        <h4><a href="<?php echo BASE_URL;?>registro">Agregar Usuario</a></h4>
                        <h4><a href="<?php echo BASE_URL;?>registro/listar">Mostrar Usuarios</a></h4>
                        <?php    
                		}
                		elseif (Session::get('level')=="tecnico") {
                			echo "Tecnico Residente";
                		}
                		elseif (Session::get('level')=="proyecto") {
                			echo "Tecnico De Proyecto";
                		}

                			 
                			?>
                </label>
	        		
	        </div>
	        <div id="enviar">
            	<form name="form1" method="post" action="<?php echo BASE_URL;?>login/cerrar/">
            		<input type="submit" value='SALIR ' class="btnentrar">
            	</form>            
        	</div>

</div>
    </body>
</html>


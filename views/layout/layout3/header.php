<!DOCTYPE html>

<html lang="es">
    <head>
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="shortcut icon" href="<?php echo BASE_URL;?>views/layout/layout3/img/ico.jpeg">
<script>

function confirma(miurl){

question = confirm("¿Desea Eliminar El Registro?")
if (question !="0"){
top.location = miurl; }
}
</script>


        
        <script src="<?php echo BASE_URL;?>public/js/jquery8.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery.alphanumeric.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery-ui3.js" type="text/javascript"></script>
        
        <link href="<?php echo BASE_URL;?>public/js/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $_layoutParams['ruta_css']; ?>estilos.css" rel="stylesheet" type="text/css" />
        <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
        <?php for($i=0; $i < count($_layoutParams['js']); $i++): ?>
            
        <script src="<?php echo $_layoutParams['js'][$i]?>" type="text/javascript"></script>
            
        <?php endfor; ?>        
        <?php endif;?>
        
    </head>

    
        <body>
            <div id="main">
                <header>
                    <!--<img src="<?php echo BASE_URL;?>views/layout/layout2/img/top4.png" width="1024px" heigth="80px"></img>-->
                </header>

                <nav>
                    <?php if(Session::get('level') == 'admin'):
                        include('menu_admin.phtml');
                    endif; ?>

                    <?php if(Session::get('level') == 'tecnico'):
                        include('menu_tecnico.phtml');
                    endif; ?>

                    <?php if(Session::get('level') == 'proyecto'):
                        include('menu_proyecto.phtml');
                    endif; ?>

                    <?php if(Session::get('level') == 'coordinador'):
                        include('menu_coord_uatic.phtml');
                    endif; ?>
                    <?php if (!Session::get('autenticado')):
                        echo '<div id="menu"></div>';
                    endif; ?>
                </nav>

                <div id='atras'></div>

                <section>
                    <noscript>debe tener javascript activado</noscript>
                    
                        <?php if(isset($this->_error)): ?> 
                            <div class="error">
                                <!--<?php echo $this->_error; ?>-->

                                <?php 
                                    echo "<script>alert('".$this->_error."');</script>"; 
                                 ?>
                                
                            </div>
                        <?php endif; ?>

                         

                        <?php if(isset($this->_mensaje)): ?> 
                            <div id="mensaje">
                                <?php
                                echo "<script>alert('".$this->_mensaje."');</script>"; 
                                ?>
                            </div>
                        <?php endif; ?>                    
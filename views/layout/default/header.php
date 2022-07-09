<!DOCTYPE html >

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        
        
        <script src="<?php echo BASE_URL;?>public/js/jquery8.js" type="text/javascript"></script>
        <script src="<?php echo BASE_URL;?>public/js/jquery.alphanumeric.js" type="text/javascript"></script>
<!--        <script src="<?php echo BASE_URL;?>public/js/jquery.validate.js" type="text/javascript"></script>-->
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
                <div id="header">
                    <div id="logo">
                        <img src="<?php echo BASE_URL;?>public/img/uatic2.png" width="140px">
                    </div>

                    <div id="menu">
                        <div id="top_menu">
                            <ul>
                            <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                            <?php 

                            if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
                            $_item_style = 'current2'; 
                            } else {
                            $_item_style = '';
                            }

                            ?>

                            <li><a class="<?php echo $_item_style; ?>" href="<?php echo $_layoutParams['menu'][$i]['enlace']; ?>"><?php  echo $_layoutParams['menu'][$i]['titulo']; ?></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="content">
                    <noscript>debe tener javascript activado</noscript>
                    
                        <?php if(isset($this->_error)): ?> <div class="error">
                            <?php echo $this->_error; ?></div>
                        <?php endif; ?>

                        <?php if(isset($this->_mensaje)): ?> <div id="mensaje">
                            <?php echo $this->_mensaje; ?></div>
                        <?php endif; ?>
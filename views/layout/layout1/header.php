<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="<?php echo $_layoutParams['ruta_css']; ?>style.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="dvmaincontainer">
        <!--main div container starts here-->

            <div id="dvtopcontainer">
            <!-- top container starts here-->

                <div id="dvlogocontainer">
                <!-- logo container starts here-->

                <h1><?php echo APP_NAME; ?></h1>
                <h4><?php echo APP_SLOGAN; ?></h4>

                <!-- logo container ends here-->
                </div>

                <div id="dvnavicontainer">
                <!-- navogation div starts here-->

                    <img src="<?php echo $_layoutParams['ruta_img']; ?>navi_left.jpg" alt="" />

                    <div id="tabs1" >
                        <ul>
                            <?php if(isset($_layoutParams['menu'])): ?>
                            <?php for($i = 0; $i < count($_layoutParams['menu']); $i++): ?>
                            <?php 

                            if($item && $_layoutParams['menu'][$i]['id'] == $item ){ 
                                $_item_style = 'current'; 
                            } else {
                                $_item_style = '';
                            }

                            ?>

                            <li id="<?php echo $_item_style; ?>"><a href="<?php echo $_layoutParams['menu'][$i]['enlace'] ?>"><span><?php echo $_layoutParams['menu'][$i]['titulo']; ?></span></a></li>

                            <?php endfor; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <img src="<?php echo $_layoutParams['ruta_img']; ?>navi_right.jpg" alt="" />

                <!-- navogation div ends here-->
                </div>

            <!-- top container ends here-->
            </div>

            <div id="dvbodycontainer">
            <!-- body div starts here-->

                <div id="dvbannerbgcontainer">
                <!-- banner bg div starts here-->

                    <div class="lftcontainer">
                        <div class="dvbannerleft">
                        <!-- banner left div starts here-->

                        <img src="<?php echo $_layoutParams['ruta_img']; ?>light.jpg"  alt="" title=""/>
                        <p><b>Bright Ideas</b> One of our services is our bright ideas and details.</p>

                        <!-- banner left div ends here-->
                        </div>

                        <div class="dvbannerleft">
                        <!-- banner left div starts here-->

                        <img src="<?php echo $_layoutParams['ruta_img']; ?>home_icon.jpg"  alt="" title=""/>
                        <p><b>Project Quote</b> We provide you with a detailed price quote.</p>

                        <!-- banner left div ends here-->
                        </div>

                        <div class="dvbannerleft">
                        <!-- banner left div starts here-->

                        <img src="<?php echo $_layoutParams['ruta_img']; ?>rpt.jpg"  alt="" title=""/>
                        <p><b>Environment</b> We care about the environment and our projects.</p>

                        <!-- banner left div ends here-->
                        </div>
                    </div>

                    <div id="dvbanner">                
                    <!-- banner div starts here-->

                        <img src="<?php echo $_layoutParams['ruta_img']; ?>banner.jpg"  alt="" title=""/>

                    <!-- banner div ends here-->
                    </div>

                <!-- banner bg div ends here-->
                </div>

                <div id="contenido">
                <!-- right panel div starts here-->
        
        
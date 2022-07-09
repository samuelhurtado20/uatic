<?php
$link=mysql_connect("localhost","root","18623532");
mysql_select_db("mision",$link);

# Buscamos la imagen a mostrar
$result=mysql_query("SELECT imagen FROM `modelo_imagenes` WHERE id_modelo_vivienda=".$_GET["id"],$link);
$row=mysql_fetch_array($result);
$tipo = 'gif';
# Mostramos la imagen
header("Content-type:".$tipo);
echo $row["imagen"];
?>

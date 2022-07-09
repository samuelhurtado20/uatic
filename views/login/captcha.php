<?php
session_start();
include_once ('jpgraph_antispam-digits.php');
$spam = new AntiSpam();
$_SESSION['tmptxt']= $spam->Rand(6);
$spam->Stroke();
?>

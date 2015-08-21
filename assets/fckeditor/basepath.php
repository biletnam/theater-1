<?php 
$sBasePath = explode("/",$_SERVER['PHP_SELF']);
unset( $sBasePath[count($sBasePath) - 1] );
$BasePath = implode("/",$sBasePath).'/js/fckeditor/';
?>
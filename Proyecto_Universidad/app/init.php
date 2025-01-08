<?php
session_start();

  // se cargan las librerías
  require_once 'config/config.php';

  // autoload php
  spl_autoload_register(function($className){
    require_once 'core/'.$className.'.php';
  });
?>


<?php
//­­­­­­­­­­­­­­­­­
// session.inc.php 
//­­­­­­­­­­­­­­­­­
class Session {    
// Constructeur
   function Session() {
     session_start();
   }
   
   // Support Session pour les urls
   function parseURL($url,$vars="") {
     return $url."?".session_name()."=".session_id().($vars!=""?"&".$vars:""); 
   }
   
   // Sauvegarde d'une variable
   function save($name,$value) {
     $_SESSION[$name]=$value;
   }
   
   // Charger une variable sauvegardée
   function load($name) {
     return isset($_SESSION[$name])?$_SESSION[$name]:'';
   }
   
   // Fermer la session
   function close() {
     session_destroy();
   }
 }
?>

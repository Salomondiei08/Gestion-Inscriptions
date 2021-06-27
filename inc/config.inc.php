<?php
//­­­­­­­­­­­­­­­­­
// config.inc.php 
//­­­­­­­­­­­­­­­­­
class Config {   
  var $db_host;
  var $db_name;
  var $db_user;
  var $db_pass;
  
  function Config() {
    $this->db_host="localhost";
    $this->db_name="inscription";
    $this->db_user="root";
    $this->db_pass="";
  }
  
  function getDbHost() {
    return $this->db_host;
  }

  function getDbName() {
    return $this->db_name;   
  }
  function getDbUser() {
    return $this->db_user;
  }
  function getDbPass() {
    return $this->db_pass;
  }
  
  function testConnection() {
    $dbh=mysql_connect($this->getDbHost(),$this->getDbUser(), $this->getDbPass());
    if ($dbh==false) {
      return false;
    }
    else {
      $dbh=mysql_select_db($this->getDbName());
      if ($dbh==false) {
        return false;
      }
      else {
        return true;
      }
    }
  }
}
?>

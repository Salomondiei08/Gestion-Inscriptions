<?php
//­­­­­­­­­­­­­­­­­
// user.inc.php 
//­­­­­­­­­­­­­­­­­
class User{   
  var $user_code;
  var $user_name;
  var $user_firstname;
  var $user_email;
  
  // Constructeur
  function User() {
    $user_code="";
    $user_name="";
    $user_firstname="";
    $user_email="";
  }
  
  // Verification de la session
  function isValid($session) {
    // La session est elle active
    $this->restoreData($session);
    if ($this->getId()=="") {
        return false;
    }
    else {
      // La session est active
      return true;
    }
  }
  
  function connect($cuser,$pass,$cfg,$session) {
    $this->user_code=$cuser;
    /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
    $dbh=mysql_select_db($cfg->getDbName());
    $dbr=mysql_query("SELECT id_user, name, firstname, email FROM users WHERE id_user='$cuser' AND passwd='$pass';");*/
    $connect=new PDO('mysql:host='.$cfg->getDbHost().';dbname='.$cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
    $select=$connect->prepare('SELECT id_user, name, firstname, email FROM users WHERE id_user=? AND passwd=?');
    $select->execute(array($cuser,$pass));
    //if (mysql_num_rows($dbr)>0) {
      //$enr=mysql_fetch_array($dbr);
    if($select->rowCount()>0){
      $enr=$select->fetch();
      if ($enr['id_user']==$this->user_code) {
        $this->user_name = $enr['name'];
        $this->user_firstname = $enr['firstname'];
        $this->user_email = $enr['email'];
        $this->saveData($session);
        unset($select);
        unset($connect);
        return true;
      }  
      else {
        unset($select);
        unset($connect);
        return false;
      }
    }
    else {
        unset($select);
        unset($connect);
      return false;
    }
  }
  function saveData($session) {
      $session->save("userId",$this->user_code);
      $session->save("userName",$this->user_name);
      $session->save("userFirstname",$this->user_firstname);
      $session->save("userEmail",$this->user_email);
      return true;
  }
  function restoreData($session) {
      $this->user_code=$session->load("userId");
      $this->user_name=$session->load("userName");
      $this->user_firstname=$session->load("userFirstname");
      $this->user_email=$session->load("userEmail");
      return true;
  }
  
  function getId() {
    return $this->user_code;   
  }
  function getName() {
    return $this->user_name;   
  }
  function getFirstname() {
    return $this->user_firstname;   
  }
  function getEmail() {
    return $this->user_email;
  }  
}
?>

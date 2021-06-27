<?php
//­­­­­­­­­­­­­­­­­
// inscription.php
//­­­­­­­­­­­­­­­­­
  $name=isset($_POST['name'])?$_POST['name']:'';
  $firstname=isset($_POST['firstname'])?$_POST['firstname']:'';
  $email=isset($_POST['email'])?$_POST['email']:'';
  $cuser=isset($_POST['cuser'])?$_POST['cuser']:'';
  $passwd=isset($_POST['passwd'])?$_POST['passwd']:'';
  $passwd2=isset($_POST['passwd2'])?$_POST['passwd2']:'';
  $action=isset($_POST['action'])?$_POST['action']:'';
  
  if(isset($action) && $action=="Effacer"){
    header("Location: inscrit.php");
    exit();
  }
  require("inc/config.inc.php");  
  require("inc/session.inc.php");
  require("inc/user.inc.php");
  // Fermer une session qui serait restée ouverte
  $session=new Session;
  $cfg=new Config;
  $user=new User;
  if ($user->isValid($session)) {
    $session->close();
  }
  if (!($cfg->testConnection())) {
    header("Location: inscrit.php?ERROR=Erreur%20du%20serveur%20MySQL%20!");
    exit();
  }
  // Controles
  $name=strtoupper($name);
  $firstname=strtolower($firstname);
  $cuser=strtolower($cuser);
  if ($name=="")  {     
    header("Location: inscrit.php?ERROR=Vous%20devez%20saisir%20votre%20nom.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");
    exit();
  }
  if ($firstname=="")  {     
    header("Location: inscrit.php?ERROR=Vous%20devez%20saisir%20votre%20prénom.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");
    exit();
  }
  if ($email=="") {     
    header("Location: inscrit.php?ERROR=Vous%20devez%20saisir%20votre%20email.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");
    exit();
  }
  if ($cuser=="") {
    header("Location: inscrit.php?ERROR=Vous%20devez%20choisir%20un%20code%20user.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");
    exit();
  }
  if ($passwd=="" | $passwd2=="") {
    header("Location: inscrit.php?ERROR=Vous%20devez%20choisir%20un%20mot%20de%20passe%20et%20le%20confirmer.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");
    exit();
  }
  if ($passwd!=$passwd2) {     
    header("Location: inscrit.php?ERROR=Les deux mots de passe ne sont pas identique,%20pensez%20à%20la%20confirmation.&name=$name&firstname=$firstname&email=$email&cuser=$cuser");     
    exit();
  }  

  // Verification de l'inexistence du code user
  /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(),$cfg->getDbPass());
  $dbh=mysql_select_db($cfg->getDbName());
  $dbr=mysql_query("SELECT * FROM users WHERE id_user='$cuser';");
  if (mysql_num_rows($dbr)>0) {*/

  $connect=new PDO('mysql:host='.$cfg->getDbHost().';dbname='.$cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
  $select=$connect->prepare('SELECT * FROM users WHERE id_user=?');
  $select->execute(array($cuser));
  if ($select->rowCount()>0) {
    unset($select);
    unset($connect); 
    header("Location: inscrit.php?ERROR=Code%20user%20déja%20utilisé,%20veuillez%20en%20choisir%20un%20autre.&name=$name&firstname=$firstname&email=$email&cuser=");
    exit();
  }
  // Les controles sont ok inscription de l'utilisateur
  /*$requete="INSERT INTO `users` ( `id_user` , `passwd` , `name` , `firstname` , `email` ) VALUES ('$cuser', '$passwd', '$name', '$firstname', '$email');";
  $dbr=mysql_query($requete);*/
  $select=$connect->prepare('INSERT INTO `users` ( `id_user` , `passwd` , `name` , `firstname` , `email` ) VALUES (?, ?, ?, ?, ?)');
  $select->execute(array($cuser, $passwd, $name, $firstname, $email));
  unset($select);
  unset($connect);  
  // On se connecte
  header("Location: themes.php?cuser=".$cuser."&passwd=".$passwd."&action=connexion"); 
?>

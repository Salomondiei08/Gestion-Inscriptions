<?php
  $id_filieres=isset($_GET['id_filieres'])?$_GET['id_filieres']:'';
  $id_etudiants=isset($_GET['id_etudiants'])?$_GET['id_etudiants']:'';

$name=isset($_POST['name'])?$_POST['name']:'';
$firstname=isset($_POST['firstname'])?$_POST['firstname']:'';
$habitation=isset($_POST['habitation'])?$_POST['habitation']:'';
$email=isset($_POST['email'])?$_POST['email']:'';
$seriebac=isset($_POST['seriebac'])?$_POST['seriebac']:'';
$mentionbac=isset($_POST['mentionbac'])?$_POST['mentionbac']:'';


 

  $action=isset($_POST['action'])?$_POST['action']:'';
  require("inc/config.inc.php");  
  require("inc/session.inc.php");
  require("inc/user.inc.php");
  $session=new Session;
  $cfg=new Config;
  $user=new User;
  if(isset($action) && $action=="Effacer"){
    header("Location: ".$session->parseURL("editer.php", "id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }
  if (!($user->isValid($session))) {
    header("Location: login.php?ERROR=Utilisateur%20inconnu,%20ou%20la%20session%20a%20expirée.");
    exit();
  }
  if ($name=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20nom.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&message=".$message));
    exit();
  }
  if ($firstname=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20prenom.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }
  if ($habitation=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20habitation.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }
  if ($email=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20email.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }
  if ($seriebac=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20seriebac.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }
  if ($mentionbac=="") {
    header("Location: ".$session->parseURL("editer.php", "ERROR=Vous%20devez%20saisir%20un%20mentionbac.&id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants."&name=".$name));
    exit();
  }

  $date=date("Y-m-d");
  $time=date("H:i:s");
  $connect=new PDO('mysql:host='.$cfg->getDbHost().';dbname='.$cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
  if ($id_etudiants=="") {
    /*$requete="INSERT INTO `etudiants` (`id_etudiants`, `title`, `date`, `time`, `id_user`, `id_filieres`) VALUES ('', '$name', '$date', '$time', '".$user->getId()."','$id_filieres');";
    $dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(),$cfg->getDbPass());
    $dbh=mysql_select_db($cfg->getDbName());
    $dbr=mysql_query($requete);
    $dbr=mysql_query("SELECT MAX(id_etudiants) as id_etudiants FROM etudiants WHERE id_filieres='$id_filieres';");
    $enr=mysql_fetch_array($dbr);*/
    $select=$connect->prepare('INSERT INTO etudiants (id_etudiants ,nom ,prenom, habitation, email, seriebac, mentionbac, id_user, id_filieres) VALUES (?, ?, ?, ?, ?, ?, ? ,? ,?)');
    $select->execute(array('', $name, $firstname, $habitation, $email, $seriebac, $mentionbac, $user->getId(), $id_filieres));
    $select=$connect->prepare('SELECT MAX(id_etudiants) as id_etudiants FROM etudiants WHERE id_filieres=?');
    $select->execute(array($id_filieres));
    $enr=$select->fetch();
    $id_etudiants=$enr['id_etudiants'];
  }  
  /*$requete="INSERT INTO `reponses` (`id_message`, `title`, `text`, `date`, `time`, `id_user`, `id_etudiants`) VALUES ('', '$name', '$message', '$date', '$time', '".$user->getId()."', '$id_etudiants');";
  if ($dbh=="") {
    $dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
    $dbh=mysql_select_db($cfg->getDbName());
  }  
  $dbr=mysql_query($requete);
  $requete="UPDATE `etudiants` SET `date` = '$date', `time` = '$time' WHERE `id_etudiants` = '$id_etudiants';";
  $dbr=mysql_query($requete);*/
  $select=$connect->prepare('INSERT INTO reponses (id_reponses, title, text, date, time, id_user, id_etudiants) VALUES (?, ?, ?, ?, ?, ?, ?)');
  $select->execute(array('', $name, $message, $date, $time, $user->getId(), $id_etudiants));
//  $select=$connect->prepare('UPDATE `reponses` SET `date` = ?, `time` = ? WHERE `id_etudiants` = ?');
  $select->execute(array($date, $time, $id_etudiants));
  unset($select);
  unset($connect);
  header("Location: ".$session->parseURL("sujets.php","id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants)); 
?>

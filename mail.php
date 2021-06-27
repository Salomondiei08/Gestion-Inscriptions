<?php
//­­­­­­­­­­­­­­­­­
// mail.php
//­­­­­­­­­­­­­­­­­
require("inc/config.inc.php");
require("inc/session.inc.php");
require("inc/user.inc.php");
$session = new Session;
$cfg = new Config;
$user = new User;
// Controles
if ($cuser == "") {
  header("Location: login.php?ERROR=Vous%20devez%20saisir%20votre%20code%20user.");
  exit();
}
/*$requete="SELECT passwd, email FROM users WHERE id_user='$cuser';";
  $dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
  $dbh=mysql_select_db($cfg->getDbName());
  $dbr=mysql_query($requete);
  if (mysql_num_rows($dbr)==0) {*/
$connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
$select = $connect->prepare('SELECT passwd, email FROM users WHERE id_user=?');
$select->execute(array($cuser));
if ($select->rowCount() == 0) {
  unset($select);
  unset($connect);
  header("Location: login.php?ERROR=Cet%20utilisateur%20est%20inconnu,%20veuillez%20vous%20inscrire.");
  exit();
}
//$enr=mysql_fetch_array($dbr);
$enr = $select->fetch();
unset($select);
unset($connect);
$text = utf8_decode("Bonjour vous avez demandé que l'on vous envoi votre mot de passe IIT FORUM.\n\nVotre mot de passe : " . $enr['passwd'] . "\n\nCordialement.");
if (mail($enr['email'], "mot de passe myforum", $text, "From: reinventtest01@gmail.com\nReply-To:reinventtest01@gmail.com\nX-Mailer:PHP/" . phpversion())) {
  header("Location: login.php?SUCCES=Votre%20mot%20de%20passe%20vous%20à%20été%20envoyé%20par%20email.&cuser=" . $cuser);
} else {
  header("Location: login.php?ERROR=Il%20y%20a%20eu%20un%20problème%20lors%20de%20l'envoi%20de%20mail.&cuser=" . $cuser);
}

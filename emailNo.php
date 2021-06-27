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
// if ($cuser == "") {
//   echo "Erreur";
//   exit();
// }
/*$requete="SELECT passwd, email FROM users WHERE id_user='$cuser';";
  $dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
  $dbh=mysql_select_db($cfg->getDbName());
  $dbr=mysql_query($requete);
  if (mysql_num_rows($dbr)==0) {*/
$connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
$select = $connect->prepare('SELECT nom, email FROM etudiants WHERE  id_etudiants=?');
 $select->execute(array($id_etudiants));
if ($select->rowCount() == 0) {
  unset($select);
  unset($connect);
  echo "MAYBE";
  exit();
}
//$enr=mysql_fetch_array($dbr);
$enr = $select->fetch();
unset($select);
unset($connect);
$text = utf8_decode("Bonjour ". $enr['nom']." Votre demande d'inscription à l'institut ivoirien de technologie n'a malheureusement pas été retenue\n\nCordialement.");
if (mail($enr['email'], "Reponse pour la demande d'inscription", $text, "From: reinventtest01@gmail.com\nReply-To:reinventtest01@gmail.com\nX-Mailer:PHP/" . phpversion())) {
  echo "SUCCES MESSAGE ENVOYE\n";
  echo " REPONSE : REFUSEE";
} else {
    echo "ECHEC MESSAGE NON ENVOYE";
    echo " REPONSE : REFUSEE";
}

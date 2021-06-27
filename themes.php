<?php
//­­­­­­­­­­­­­­­­­
// filieres.php
//­­­­­­­­­­­­­­­­­
$cuser = isset($_POST['cuser']) ? $_POST['cuser'] : '';
$passwd = isset($_POST['passwd']) ? $_POST['passwd'] : '';
if (isset($_GET['action']) ? $_GET['action'] : '' == "connexion") {
  $cuser = isset($_GET['cuser']) ? $_GET['cuser'] : '';
  $passwd = isset($_GET['passwd']) ? $_GET['passwd'] : '';
}
$action = isset($_POST['action']) ? $_POST['action'] : '';
if (isset($action) && $action == "J'ai perdu mon mot de passe") {
  require("mail.php");
  exit();
}
require("inc/config.inc.php");
require("inc/session.inc.php");
require("inc/user.inc.php");
$session = new Session;
$cfg = new Config;
$user = new User;
if (!($cfg->testConnection())) {
  header("Location: login.php?ERROR=Erreur%20du%20serveur%20MySQL%20!");
  exit();
}
if (!($user->isValid($session)) && !($user->connect($cuser, $passwd, $cfg, $session))) {
  header("Location: login.php?ERROR=Mot%20de%20passe%20incorrect,%20ou%20utilisateur%20inconnu.&cuser=" . $cuser);
  exit();
}
?>
<?php echo '<?xml version="1.0" encoding="ISO8859­1"?>' ?>
<!DOCTYPE html PUBLIC "­//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1­strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>Inscription en Ligne IIT</title>
  <meta http­equiv="content­type" content="text/html" charset="ISO8859­1" />
  <meta name="keywords" lang="fr" content="forum, discussion, logiciel, libre, php, mysql, xhtml, css" />
  <meta name="author" lang="fr" content="DIEI Salmon" />
  <meta name="copyright" content="&copy; 2004 DIEI Salmon." />
  <meta name="license" content="GNU General Public License." />
  <link rel="stylesheet" href="default.css" type="text/css" />
</head>

<body>
  <!--Entete de site-->
  <div class="header">
    <img class="icon" src="imgs/linux.png" alt="Salomon" />
    <h1>Inscription en Ligne IIT</h1>
    <hr />
  </div>
  <!--La partie principale-->
  <div class="main">
    <div class="pwd">
      <?php echo $user->getId(); ?> &gt;&gt;
      <?php echo "<a href=\"" . $session->parseURL("login.php") . "\" title=\"quitter\">"; ?>Quitter</a>
    </div>
    <!--La liste des filieres-->
    <table>
      <?php echo '<caption>GESTION IIT : ' . utf8_decode('Liste des filières') . ' </caption><thead><tr class="title"><th>' . utf8_decode('Filière') . '</th>'; ?>
      <th>Description</th>
      <th>Inscrits </th>
      <th>Date</th>
      </tr>
      </thead>
      <tbody>
        <?php
        /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
            $dbh=mysql_select_db($cfg->getDbName());
            $dbr=mysql_query("SELECT id_filieres, name, description FROM  filieres;");
            while ($enr=mysql_fetch_array($dbr))  {*/
        $connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
        $select = $connect->query('SELECT id_filieres, name, description FROM  filieres');
        while ($enr = $select->fetch()) {
          echo '<tr>';
          echo "<td class=\"left\"><a href=\"" . $session->parseURL("sujets.php", "id_filieres=" . $enr['id_filieres'] . "&cuser=" . $cuser ) . "\">" . $enr['name'] . "</a></td>";
          echo "<td class=\"left\"><a href=\"" . $session->parseURL("sujets.php", "id_filieres=" . $enr['id_filieres'] . "&cuser=" . $cuser ) . "\">" . $enr['description'] .  "</a></td>";
          /*$dbr2=mysql_query("SELECT COUNT(*) as nb_sujets, MAX(date) as date FROM etudiants WHERE id_filieres='".$enr['id_filieres']."';");
              $enr2=array();
              if (mysql_num_rows($dbr2)>0)      {
                $enr2=mysql_fetch_array($dbr2);*/
          //$sel=$connect->prepare('SELECT COUNT(*) as nb_sujets, MAX(date) as date FROM etudiants WHERE id_filieres=?');
          $sel = $connect->prepare('SELECT COUNT(*) as nb_sujets FROM etudiants WHERE id_filieres=?');
          $sel->execute(array($enr['id_filieres']));
          $enr3 = array();
          if ($sel->rowCount() > 0) {
            $enr2 = $sel->fetch();
            if ($enr2['nb_sujets'] > 0) {
              # code...
              $sel = $connect->prepare('SELECT date, MAX(time) as time FROM etudiants WHERE date=(SELECT MAX(date) as date FROM etudiants WHERE id_filieres=?) AND id_filieres=?');
              $sel->execute(array($enr['id_filieres'], $enr['id_filieres']));
              $enr3 = $sel->fetch();
            } else {
              $enr2['nb_sujets'] = '0';
              $enr3['date'] = "0000-00-00";
              $enr3['time'] = "00:00:00";
            }
          }
          echo "<td class=\"right\">" . $enr2['nb_sujets'] . "</td>";
          echo "<td class=\"right\">" . $enr3['date'] . ' ' . $enr3['time'] . "</td>";
          echo '</tr>';
        }
        unset($select);
        unset($sel);
        unset($connect);
        ?>
      </tbody>
    </table>
  </div>
  <!--Le pied de page-->
  <div class="footer">
    <hr />
    Copyright &copy; 2021 DIEI Salmon<br />
    Ce logiciel est sous licence Gnu Genral Public License
  </div>
</body>

</html>
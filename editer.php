<?php
//­­­­­­­­­­­­­­­­­
// editer.php
//­­­­­­­­­­­­­­­­­
$cuser = isset($_POST['cuser']) ? $_POST['cuser'] : '';
// $id_filieres = isset($_POST['id_filieres']) ? $_POST['id_filieres'] : '';
// $id_etudiants = isset($_POST['id_etudiants']) ? $_POST['id_etudiants'] : '';

// if (isset($_GET['action']) ? $_GET['action'] : '' == ''); {
  $id_filieres = isset($_GET['id_filieres']) ? $_GET['id_filieres'] : '';
  $id_etudiants = isset($_GET['id_etudiants']) ? $_GET['id_etudiants'] : '';
// }

$ERROR = utf8_decode(isset($_GET['ERROR']) ? $_GET['ERROR'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : '';

if (isset($action) && $action == 'Accepter la Demande') {
  require("email.php");
  exit();
}

if (isset($action) && $action == 'Refuser la Demande') {
  require("emailNo.php");
  exit();
}

require("inc/config.inc.php");
require("inc/session.inc.php");
require("inc/user.inc.php");
$session = new Session;
$cfg = new Config;
$user = new User;
if (!($user->isValid($session))) {
  header("Location: login.php?ERROR=Utilisateur%20inconnu,%20ou%20la%20session%20a%20expirée.");
  exit();
}
?>
<?php echo '<?xml version="1.0" encoding="ISO8859­1"?>' ?>
<!DOCTYPE html PUBLIC "­//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1­strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>GESTION IIT v0.1</title>
  <meta http­equiv="content­type" content="text/html" charset="ISO8859­1" />
  <meta name="keywords" lang="fr" content="forum, discussion, logiciel, libre, php, mysql, xhtml, css" />
  <meta name="author" lang="fr" content="Salomon Diei" />
  <meta name="copyright" content="&copy; 2021 Salomon Diei." />
  <meta name="license" content="GNU General Public License." />
  <link rel="stylesheet" href="default.css" type="text/css" />
</head>

<body>
  <!--Entete de site-->
  <div class="header">
    <img class="icon" src="imgs/linux.png" alt="Salomon DIEI" />
    <h1>GESTION v0.1</h1>
    <hr />
  </div>
  <!--La partie principale-->
  <div class="main">
    <div class="pwd">
      <?php echo $user->getId(); ?> &gt;&gt;
      <?php echo "<a href=\"" . $session->parseURL("login.php") . "\" title=\"quitter\">"; ?>Quitter</a> ::
      <?php echo "<a href=\"" . $session->parseURL("themes.php") . "\" title=\"retour aux " . utf8_decode('Filières') . "\">" . utf8_decode('Filières'); ?></a> ::
      <a href="<?php echo $session->parseURL('sujets.php', 'id_filieres=' . $id_filieres); ?>" title="retour aux Inscrits">Inscrits</a>
      <?php
      if ($id_etudiants != '') {
        echo ':: <a href="' . $session->parseURL("messages.php", "id_filieres=" . $id_filieres . "&id_etudiants=" . $id_etudiants) . '" title="retour sur les Reponses">Reponses</a>';
      }
      ?>
    </div>
    <!--Message d'erreur-->
    <div class="err">
      <?php
      if (isset($ERROR) && $ERROR != "") {
        echo "ERREUR : $ERROR";
      }
      ?>
    </div>
    <!--Répondre au message-->
    <div class="box">
      <?php
      $name = isset($_GET['name']) ? $_GET['name'] : '';
      $firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
      $habitation = isset($_GET['habitation']) ? $_GET['habitation'] : '';
      $email = isset($_GET['email']) ? $_GET['email'] : '';
      $seriebac = isset($_GET['seriebac']) ? $_GET['seriebac'] : '';
      $mentionbac = isset($_GET['mentionbac']) ? $_GET['mentionbac'] : '';
      if ($id_etudiants != "") {
        /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
             $dbh=mysql_select_db($cfg->getDbName());
             $dbr=mysql_query("SELECT name FROM subjects WHERE  id_etudiants='$id_etudiants';");
             $enr=mysql_fetch_array($dbr);*/
        $connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
        $select = $connect->prepare('SELECT nom FROM etudiants WHERE  id_etudiants=?');
        $select->execute(array($id_etudiants));
        $enr = $select->fetch();
        unset($select);
        unset($connect);
        $name = "RE: " . $enr['nom'];
      }
      ?>
      <?php echo "<h1>" . utf8_decode('Inscription à IIT') . "</h1>"; ?>
      <?php echo '<form action="' . $session->parseURL("savemessage.php", "id_filieres=" . $id_filieres . "&id_etudiants=" . $id_etudiants) . '" method="post">'; ?>
      <form action="inscription.php" method="post">
        <div class="field">
          <label for="name">Name :</label>
          <?php echo '<input type="text" id="name" name="name" value="' . $name . '" />'; ?>
        </div>
        <div class="field">
          <label for="firstname"><?php echo utf8_decode("Préname") . '  :</label> <input type="text" id="first" name="firstname" value="' . $firstname . '" />'; ?>
        </div>
        <div class="field">
          <label for="habitation">Habitation :</label>
          <?php echo '<input type="text" id="habitation" name="habitation" value="' . $habitation . '" />'; ?>
        </div>
        <div class="field">
          <label for="email">Email :</label>
          <?php echo '<input type="email" id="email" name="email" value="' . $email . '" />'; ?>
        </div>
        <div class="field">
          <label for="seriebac">Serie au Bac :</label>
          <?php echo '<input type="text" id="seriebac" name="seriebac" value="' . $seriebac . '" />'; ?>
        </div>
        <div class="field">
          <label for="mentionbac">Mention au Bac :</label>
          <?php echo '<input type="text" id="mentionbac" name="mentionbac" value="' . $mentionbac . '" />'; ?>
        </div>
        <div class="buttons">
          <input class="button" type="submit" name="action" value="Faire sa demande" />
          &nbsp;<input class="button" type="submit" name="action" value="Effacer" />
        </div>
      </form>
    </div>
    </form>
  </div>

  <!--La liste des themes-->
  <?php
  if ($id_etudiants != "") {
    echo '<table class="old" summary="Devel : Comment réaliser un forum en PHP ?">';
    echo '<caption>Devel : Comment réaliser un forum en PHP ?</caption>';
    echo '<tbody>';
    /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
          $dbh=mysql_select_db($cfg->getDbName());
          $dbr=mysql_query("SELECT id_user,name,text, date, id_user FROM reponses WHERE id_etudiants='$id_etudiants' ORDER BY date DESC, id_message DESC;");       
          while ($enr=mysql_fetch_array($dbr)) {*/
    $connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
    $select = $connect->prepare('SELECT id_user, name, text, date, time, id_user FROM reponses WHERE id_etudiants=? ORDER BY date DESC, time DESC, id_reponses DESC');
    $select->execute(array($id_etudiants));
    while ($enr = $select->fetch()) {
      echo '<tr class="row">';
      echo '<th class="left">' . $enr['id_user'] . '</th>';
      echo '<th class="left">' . $enr['name'] . '</th>';
      echo '<th class="right">' . $enr['date'] . ' ' . $enr['time'] . '</th>';
      echo '</tr>' . "\n";
      echo '<tr class="row">';
      echo '<td colspan="3" class="left"><pre>' . $enr['text'] . '</pre></td>';
      echo '</tr>' . "\n";
    }
    unset($select);
    unset($connect);
    echo '</tbody>';
    echo '</table>';
  }
  ?>
  </div>
  <!--Le pied de page-->
  <div class="footer">
    <hr />
    Copyright &copy; 2021 Salomon Diei<br />
    Ce logiciel est sous licence Gnu Genral Public License
  </div>
</body>

</html>
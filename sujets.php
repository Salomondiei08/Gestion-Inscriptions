<?php
//­­­­­­­­­­­­­­­­­
// sujets.php
$id_filieres = isset($_GET['id_filieres']) ? $_GET['id_filieres'] : '';
$cuser = isset($_GET['cuser']) ? $_GET['cuser'] : '';
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
if (!($cfg->testConnection())) {
  header("Location: login.php?ERROR=Erreur%20du%20serveur%20MySQL%20!");
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
  <meta name="copyright" content="&copy; 2021 DIEI Salmon." />
  <meta name="license" content="GNU General Public License." />
  <link rel="stylesheet" href="default.css" type="text/css" />
</head>

<body>
  <!--Entete de site-->
  <div class="header">
    <img class="icon" src="imgs/linux.png" alt="ABUL" />
    <h1>Inscription en Ligne IIT</h1>
    <hr />
  </div>
  <!--La partie principale-->
  <div class="main">
    <div class="pwd">
      <?php echo $user->getId(); ?> &gt;&gt;
      <?php echo "<a href=\"" . $session->parseURL("login.php") . "\" title=\"quitter\">"; ?>Quitter</a> ::
      <?php echo "<a href=\"" . $session->parseURL("themes.php") . "\" title=\"retour aux " . utf8_decode('Filières') . "\">" . utf8_decode('Filières'); ?></a>
    </div>
    <!--La liste des filieres-->
    <table>
      <caption>
        <?php
        $connect = new PDO('mysql:host=' . $cfg->getDbHost() . ';dbname=' . $cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
        $select = $connect->prepare('SELECT name FROM filieres WHERE id_filieres=?');
        $select->execute(array($id_filieres));
        $enr = $select->fetch();
        echo $enr['name'];
        ?>
        &nbsp;: Liste des Inscrits
      </caption>
      <thead>
        <tr class="title">
          <th>Nom</th>
          <th>Habitation</th>
          <th>Serie Bac</th>
          <th>Mention Bac</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($cuser == "admin") {
          $select = $connect->prepare('SELECT id_etudiants, nom, seriebac, mentionbac, habitation, id_user FROM etudiants WHERE id_filieres=?');
          $select->execute(array($id_filieres));
          while ($enr = $select->fetch()) {
            echo '<tr>';
            echo "<td class=\"left\"> <a href=\"" . $session->parseURL("messages.php", "id_filieres=" . $id_filieres . "&id_etudiants=" . $enr['id_etudiants']) . "\">" . $enr['nom'] . "</a></td>";
            echo "<td class=\"left\">" . $enr['habitation'] . "</td>";
            echo "<td class=\"left\">" . $enr['mentionbac'] . "</td>";
            echo "<td class=\"left\">" . $enr['seriebac'] . "</td>";
            echo "</tr>\n";
          }
          unset($select);
          unset($sel);
          unset($connect);
      
        } else {
          $select = $connect->prepare('SELECT id_etudiants, nom, seriebac, mentionbac, habitation, id_user FROM etudiants WHERE id_filieres=?');
          $select->execute(array($id_filieres));
          while ($enr = $select->fetch()) {
            echo '<tr>';
            echo "<td class=\"left\">" . $enr['nom'] . "</a></td>";
            echo "<td class=\"left\">" . $enr['habitation'] . "</td>";
            echo "<td class=\"left\">" . $enr['seriebac'] . "</td>";
            echo "<td class=\"left\">" . $enr['mentionbac'] . "</td>";
            echo "</tr>\n";
          }
          unset($select);
          unset($sel);
          unset($connect);

          echo "<tr class=\"row\">";
          echo  "<td colspan=\"4\" class=\"center\">";
          echo  "<form action=\"" . $session->parseURL("editer.php", "id_filieres=" . $id_filieres) . "\" method=\"post\">";
          echo  "<input class=\"button\" type=\"submit\" name=\"action\" value=\"Faire une demande\"/>";
          echo  "</form>";
          echo "</td>";
          echo "</tr>";
        }
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
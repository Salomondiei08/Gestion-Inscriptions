<?php
//­­­­­­­­­­­­­­­­­
// login.php
//­­­­­­­­­­­­­­­­­
$cuser = isset($_GET['cuser']) ? $_GET['cuser'] : '';
require("inc/config.inc.php");
require("inc/session.inc.php");
require("inc/user.inc.php");
// Fermer une session qui serait restée ouverte
$session = new Session;
$user = new User;
$ERROR = utf8_decode(isset($_GET['ERROR']) ? $_GET['ERROR'] : '');
if ($user->isValid($session)) {
  $session->close();
}
?>
<?php echo "<? xml version=\"1.0\" encoding=\"ISO8859­1\"?>" ?>
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
    <h1 class="text">Inscription en Ligne IIT</h1>
    <hr />
  </div>
  <!--La partie principale-->
  <div class="main">
    <!--Message d'erreur-->
    <div class="err">
      <?php
      if (isset($ERROR) && $ERROR != "") {
        echo "ERREUR : $ERROR";
      }
      ?>
    </div>
    <!--La boite de connection-->
    <div class="box">
      <h1>Identifiez vous</h1>
      <?php echo "<form action=\"" . $session->parseURL("themes.php") . "\" method=\"post\">"; ?>
      <div class="field">
        <label for="cuser">Code user : </label>
        <input type="text" id="cuser" name="cuser" value="<?php echo $cuser; ?>" />
      </div>
      <div class="field">
        <label for="passwd">Mot de passe : </label>
        <input type="password" id="passwd" name="passwd" value="" />
      </div>
      <div class="buttons">
        <input class="button" type="submit" name="action" value="Je me connecte" /><br />
        <input class="button" type="submit" name="action" value="J'ai perdu mon mot de passe" />
      </div>
      </form>
    </div>
    <div class="center">
      <?php echo utf8_decode("Si vous n'êtes pas encore inscrit veuillez cliquer"); ?> <a href="inscrit.php">Ici</a>.
    </div>
  </div>
  <!--Le pied de page-->
  <div class="footer">
    <hr />
    Copyright &copy; 2021 DIEI Salmon<br />
    Ce logiciel est sous licence Gnu Genral Public License
  </div>
</body>

</html>
<?php
//­­­­­­­­­­­­­­­­­
// inscrit.php
//­­­­­­­­­­­­­­­­­
$name = isset($_GET['name']) ? $_GET['name'] : '';
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$cuser = isset($_GET['cuser']) ? $_GET['cuser'] : '';
$ERROR = utf8_decode(isset($_GET['ERROR']) ? $_GET['ERROR'] : '');
require("inc/config.inc.php");
require("inc/session.inc.php");
require("inc/user.inc.php");
// Fermer une session qui serait restée ouverte
$session = new Session;
$user = new User;
if ($user->isValid($session)) {
  $session->close();
}
?>
<?php echo "<?xml version=\"1.0\" encoding=\"ISO8859­1\"?>" ?>
<!DOCTYPE html PUBLIC "­//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1­strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>Inscription en Ligne IIT </title>
      <meta http­equiv="content­type" content="text/html" charset="ISO8859­1" />
      <meta name="keywords" lang="fr" content="forum, discussion, logiciel, libre, php, mysql, xhtml, css" />
      <meta name="author" lang="fr" content="DIEI Salomon" />
      <meta name="copyright" content="&copy; 2021 DIEI Salomon." />
      <meta name="license" content="GNU General Public License." />
      <link rel="stylesheet" href="default.css" type="text/css" />
</head>

<body>
  <!-- Entete de site-->
  <div class="header">
    <img class="icon" src="imgs/linux.png" alt="ABUL" />
    <h1>Inscription en Ligne IIT</h1>
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
    <!--La boite d'inscription-->
    <div class="box">
      <h1>Inscription</h1>
      <form action="inscription.php" method="post">
        <div class="field">
          <label for="name">Nom :</label>
          <?php echo '<input type="text" id="name" name="name" value="' . $name . '" />'; ?>
        </div>
        <div class="field">
          <label for="first"><?php echo utf8_decode("Prénom") . '  :</label> <input type="text" id="first" name="firstname" value="' . $firstname . '" />'; ?>
        </div>
        <div class="field">
          <label for="email">Email :</label>
          <?php echo '<input type="email" id="email" name="email" value="' . $email . '" />'; ?>
        </div>
        <div class="field">
          <label for="cuser">Code user :</label>
          <?php echo '<input type="text" id="cuser" name="cuser" value="' . $cuser . '" />'; ?>
        </div>
        <div class="field">
          <label for="passwd">Password :</label>
          <input type="password" id="passwd" name="passwd" value="" />
        </div>
        <div class="field">
          <label for="passwd2">Confirmation :</label>
          <input type="password" id="passwd2" name="passwd2" value="" />
        </div>
        <div class="buttons">
          <input class="button" type="submit" name="action" value="S'inscrire" />
          &nbsp;<input class="button" type="submit" name="action" value="Effacer" />
        </div>
      </form>
    </div>
  </div>
  <!--Le pied de page-->
  <div class="footer">
    <hr />
    Copyright &copy; 2021 DIEI Salomon<br />
    Ce logiciel est sous licence Gnu Genral Public License
  </div>
</body>

</html>
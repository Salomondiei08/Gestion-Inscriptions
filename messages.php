<?php
//­­­­­­­­­­­­­­­­­
// messages.php
//­­­­­­­­­­­­­­­­­
  $id_filieres=isset($_GET['id_filieres'])?$_GET['id_filieres']:'';
  $id_etudiants=isset($_GET['id_etudiants'])?$_GET['id_etudiants']:'';
  require("inc/config.inc.php");  
  require("inc/session.inc.php");
  require("inc/user.inc.php");
  $session=new Session;
  $cfg=new Config;
  $user=new User;
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
<!DOCTYPE html PUBLIC "­//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1­strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>Inscription en Ligne IIT</title>
    <meta http­equiv="content­type" content="text/html;" charset="ISO8859­1"/>
    <meta name="keywords" lang="fr" content="forum, discussion, logiciel, libre, php, mysql, xhtml, css" />
    <meta name="author" lang="fr" content="DIEI Salomon" />
    <meta name="copyright" content="&copy; 2021 DIEI Salmon." />
    <meta name="license" content="GNU General Public License." />
    <link rel="stylesheet" href="default.css" type="text/css" />
  </head>
  <body>
    <!--Entete de site-->
    <div class="header">
      <img class="icon" src="imgs/linux.png" alt="Salomon" />
      <h1>Inscription en Ligne IIT</h1>
      <hr/>
    </div>
    <!--La partie principale-->
    <div class="main">
      <div class="pwd">
        <?php echo $user->getId(); ?> &gt;&gt; 
        <?php echo "<a href=\"".$session->parseURL("login.php"). "\" title=\"quitter\">"; ?>Quitter</a> :: 
        <?php echo "<a href=\"".$session->parseURL("themes.php")."\" title=\"retour aux ".utf8_decode('Filières')."\">".utf8_decode('Filières'); ?></a> :: 
        <a href="<?php echo $session->parseURL('sujets.php','id_filieres='.$id_filieres);?>" title="retour aux Inscrits">Inscrits</a>
      </div>
      <!--La liste des filieres-->
      <table>
        <caption>
          <?php 
            /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(),$cfg->getDbPass());
            $dbh=mysql_select_db($cfg->getDbName());
            $dbr=mysql_query("SELECT name FROM filieres WHERE  id_filieres='$id_filieres';");
            $enr=mysql_fetch_array($dbr);*/
            $connect=new PDO('mysql:host='.$cfg->getDbHost().';dbname='.$cfg->getDbName(), $cfg->getDbUser(), $cfg->getDbPass());
            $select=$connect->prepare('SELECT name FROM filieres WHERE  id_filieres=?');
            $select->execute(array($id_filieres));
            $enr=$select->fetch();
            echo $enr['name'];
            if(isset($id_etudiants)){
              echo " : ";
            }
            /*$dbr=mysql_query("SELECT nom FROM etudiants WHERE  id_etudiants='$id_etudiants';");
            $enr=mysql_fetch_array($dbr);*/
            $select=$connect->prepare('SELECT nom FROM etudiants WHERE  id_etudiants=?');
            $select->execute(array($id_etudiants));
            $enr=$select->fetch();
            echo $enr['nom']; 

          ?>
        </caption>
        <tbody>
        <?php  
          /*$dbh=mysql_connect($cfg->getDbHost(),$cfg->getDbUser(), $cfg->getDbPass());
          $dbh=mysql_select_db($cfg->getDbName());
          $dbr=mysql_query("SELECT id_user,title, `text` , `date`, id_user FROM reponses WHERE id_etudiants='$id_etudiants' ORDER BY `date`, id_message;");
          while ($enr=mysql_fetch_array($dbr)) {*/
          $select=$connect->prepare('SELECT id_user, title, `text` , `date`,time, id_user FROM reponses WHERE id_etudiants=? ORDER BY `date`, time, id_reponses');
          $select->execute(array($id_etudiants));
          while($enr=$select->fetch()){
            echo '<tr class="row">';
            echo '<th class="left">'.$enr['id_user'].'</th>';
            echo '<th class="left">'.$enr['title'].'</th>';
            echo '<th class="right">'.$enr['date'].' '.$enr['time'].'</th>';
            echo '</tr>'."\n";
            echo '<tr class="row">';
            echo '<td colspan="3" class="left"><pre>'.$enr['text'].'</pre></td>';
            echo '</tr>'."\n";
          }
          unset($select);
          unset($connect);
        ?>        
          <!--Le boutton répondre-->
          <tr class="row">
            <td colspan="3" class="center">
              <?php echo  '<form action="'.$session->parseURL("editer.php","id_filieres=".$id_filieres."&id_etudiants=".$id_etudiants).'" method="post">'; ?>
                <?php echo '<input class="button" type="submit" name="action" value="'.utf8_decode('Accepter la Demande').'" />'; ?>             
                <?php echo '<input class="button" type="submit" name="action" value="'.utf8_decode('Refuser la Demande').'" />'; ?>             
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--Le pied de page-->
    <div class="footer">
      <hr/>
      Copyright &copy; 2021 DIEI Salmon<br />
      Ce logiciel est sous licence Gnu Genral Public License
    </div>    
  </body>
</html>

<?php
/// #############################################################################################
/// cette ligne est incoherante avec le fonctionne ment autonome de ce module, car cette ligne ne fonctionnera pas si on lance ce fichier index.php directement.
require_once 'resources/php/page.phpc'; // $workingFolder.'../resources/php/page.phpc';
/// a mettre plus bas...
/// #############################################################################################


$workingFolder = dirname(__FILE__).DIRECTORY_SEPARATOR;
$page = new page();

// webAdmin
// define ('CRYPT_BLOWFISH', true);
$salt = '$2a$07$WsWds.0cEzRZZaN/PX8M0w';

$spath = session_save_path();
if (strpos ($spath, ";") !== FALSE) {
    $spath = substr ($spath, strpos($spath, ";")+1);
}
if (!is_dir($spath) && !empty($spath)) {
	echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
	if (!is_dir(mkdirs(str_replace(realpath('./'), '.', $spath), 0700, true))) {
		echo __FILE__."\n".'Problem on line '.(__LINE__ - 2)."\n";
		echo ' ("'.session_save_path().'").<br>';
	}
}
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '0');
session_cache_limiter ('nocache');
session_cache_expire (60);            // set cache time out

	if (is_file($workingFolder.'../stations.conf')) {
		$WsWdsConfig = eval('return '.file_get_contents($workingFolder.'../WsWds.conf').';');
	}
	elseif (is_file($workingFolder.'../stations.conf')) {
		$WsWdsConfig = eval('return '.file_get_contents($workingFolder.'../WsWds.default.conf').';');
	}
	else {
		$WsWdsConfig = array ();
		echo 'erreur sur le fichier de config';
	}

var_export ($WsWdsConfig);
if (session_start()) {
	if (isset($_GET['stop'])) { // sur une demande de fermeture
		$_SESSION['WsWds'] = array(0);		// on vide bien la variable de session
		unset($_SESSION['WsWds']);			// et on detruit le contenue de session ki nous conserne
		if (empty($_SESSION)) {				// si après ca la session est vide on peut en deduire que personne d'autre ne l'utilise
			setcookie(session_name(), '', time()-100000, '/');	// on force le cookie de session a etre périmé
			session_destroy();						// on detruit la session sur le serveur
		}
		$page->setPage('logout');
/*
 remplacer le exit par une redirection
*/
//		exit();
// 		echo '0 : '.$_GET['username'].' : '.$_GET['password']; // UNKOWN variable
	} elseif (isset($_GET['username'])
            && empty($WsWdsConfig['AdminInterface']['Username'])
            && empty($WsWdsConfig['AdminInterface']['Password'])
            && strlen($_GET['username'])>2
            && $_GET['password']==$_GET['confirm']
    ) { // No admin yet, we let user create one
		$_SESSION['WsWds']['login'] = $WsWdsConfig['AdminInterface']['Username'] = $_GET['username'];
		$WsWdsConfig['AdminInterface']['Password'] = crypt($_GET['password'], $salt);
		$page->setPage('admin');
// 		include ($GLOBALS['workingFolder'].'admin.php');
		echo '1 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (isset($_GET['username'])
            && ($_GET['username']==$WsWdsConfig['AdminInterface']['Username']
            && crypt($_GET['password'], $salt)==$WsWdsConfig['AdminInterface']['Password'])
    ) { // password is correct/valid
		$_SESSION['WsWds']['login'] = $_GET['username'];
		$page->setPage('admin');
// 		include ($GLOBALS['workingFolder'].'admin.php');
		echo '2 : '.$_GET['username'].' : '.$_GET['password'];
	} elseif (!empty($_SESSION['WsWds']['login'])) { // authentification has been successful
		if (isset($_POST['query'])) {
            echo sprintf(_('a "query" has been submitted'));
            include ($GLOBALS['workingFolder'].'AJAX.php');
        } else {
            echo sprintf(_('no "query", shall we show the default UI here ?'));
            $page->setPage('admin');
    }
  }
	else { // on invite l´utiliseteur a s´identifier
// 		include ($GLOBALS['workingFolder'].'login.php');
		$page->setPage('login');
		// on quitte directement le scripte
// 		echo '4 : '.$_GET['username'].' : '.$_GET['password'];
	}

	if (!file_put_contents ($workingFolder.'../WsWds.conf', var_export($WsWdsConfig, true ))) {
		sprintf("%s%s", _('Fail to save modifications.'), _('Please check your rights are corrects.'));
	}
//     	echo _('Impossible d´enregistrer les changements, Merci de verifier les droits.');
}

// <p>
//  Pour continuer, <a href="nextpage.php?<?php echo htmlspecialchars(SID); ? >">cliquez ici</a>.
// </p>

require_once './themes/head.php';
    $page->View();
require_once './themes/footer.php';
require_once './themes/js-libs.html';

?>

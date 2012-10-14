<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| Configuration for the Probe application.
*/

$config['mainDb'] = 'probe';
// $config['probe:username'] = 'edouard.lopez';
$config['probe:username'] = '';
// $config['probe:password'] = 'edouard.lopez';
$config['probe:password'] = '';
/**
	include(APPPATH.'libraries/WS_rev_crypt.php');
	$crypt = new WS_rev_crypt('database_root');
//	$crypt->write('P@$$w0rd');
	$config['probe:password'] = $crypt->read();
	unset($crypt);
**/

// Locale/language to use for the interface
$config['probe:locale'] = 'fr';

/*
*redirection URLs for the admin area
*/
// landing page after user is successfully authentified
$config['admin_dashboard']	= "/admin/admin/";
// Login page, un-authentified users will land on this page to provide their credentials
$config['admin_connexion']	= "/admin/admin/connexion";


$config['require_directories']	= array("entity", "exceptions");
$config['require_blacklist'] = array( "Address");







//###################################### REQUIRES ######################################
$absoluteAppPath = str_replace(
        end(explode('/', $_SERVER['SCRIPT_FILENAME'])),
        '',
        $_SERVER['SCRIPT_FILENAME']
    )
    .''.APPPATH;
// echo $absoluteAppPath."<br/>";


foreach($config['require_directories'] as $unDossier) {
	require_once_file_autoload($absoluteAppPath."".$unDossier , $config['require_blacklist']);
}


function require_once_file_autoload($chemin , $exclude = array() ) {

	$contenuDossier = scandir($chemin);
	foreach ($contenuDossier as $unElt) {
		$unEltComplet = "$chemin/$unElt";

		if (  $unElt != "."
		&& $unElt != ".."
		&& !in_array($unElt.".php", $exclude) ) {
			if(is_dir($unEltComplet)) {
				a($unEltComplet);
			}
			else {
				require_once $unEltComplet;
			}
		}
	}
}
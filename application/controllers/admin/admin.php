<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/controllers/authentification.php";
class Admin extends Authentification {

	/**
	 * Url sur laquelle l'user sera redirigé une fois connecté
	 * Les classes filles peuvent la redéfinir. Par défaut, la redirection se fait sur "base_url"
	 * @var String
	 */
	protected $urlConnecte= NULL;

	public function __construct() {
		parent::__construct();

		$this->i18n->setLocaleEnv($this->config->item('ws:locale'), 'global'); // set language
		$this->encrypt->set_cipher(MCRYPT_BLOWFISH);

		//Modèles
		$this->load->model('service/ServiceUser');

		//Redéfinition de l'url de redirection si pas connecté
		$this->urlConnexion = $this->config->item('admin_connexion');
		$this->urlConnecte 	= $this->config->item('admin_accueil');
		$this->verificationConnexion();
	}

	public function index(){
		$this->lang->load('admin', 'french');

		echo "PAGE ACCUEIL ADMIN : ".$this->lang->line('admin.bienvenue');
	}

	public function connexion() {
		$data = array(
				'msg' => $this->session->userdata("msg")
		);
		$this->session->set_userdata("msg", NULL);
		$this->load->view('admin_login', $data);
	}

	/*
	 * Redirect user depending on its credentials validation
	 */
	public function connecter() {
		$login 	=  	$this->input->get('login');
		$mdp 	=  	$this->input->get('mdp');

		try {
			//Chercher l'user correspondant au couple login/mdp
		  $user = $this->ServiceUser->authentifier($login, $mdp);
			$this->session->set_userdata("user", serialize($user));
		}
		catch(BusinessException $be) {
			//Message d'erreur dans la variable "msg" de la session. Impossible d'utiliser flashdata car il y a 2 redirections en cas d'erreur de login
			$this->session->set_userdata("msg", $be->getMessage());
		}

		redirect($this->urlConnecte);
	}
}
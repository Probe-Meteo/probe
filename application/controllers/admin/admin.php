<?php
/**
* Administrative back-end controller
*
* @category Admin
* @package  Probe
* @author   Édouard Lopez <dev+probe@edouard-lopez.com>
* @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
* @link     http://probe.com/doc
 */
// namespace Probe\Admin;

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/controllers/authentification.php";
require_once APPPATH."/controllers/pages.php";

class admin extends Authentification
{
    /**
    * Url sur laquelle l'user sera redirigé une fois connecté
    * Les classes filles peuvent la redéfinir. Par défaut, la redirection se fait sur "base_url"
    * @var String
    */
    protected $urlWhenLogged = null; // when user is authentified go to this URL

    /**
     * entry point
     */
    public function __construct()
    {
        parent::__construct();
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());

        $this->i18n->setLocaleEnv($this->config->item('probe:locale'), 'global'); // set language
        // $this->encrypt->set_cipher(MCRYPT_BLOWFISH);

        // Modèles
        $this->load->model('service/Service_User');

        // set URL to login page, i.e. not yet authentified (cf. config/probe.php)
        $this->urlConnexion = $this->config->item('page-login');
        // set URL to redirect to when user is authentified (cf. config/probe.php)
        $this->urlWhenLogged    = $this->config->item('page-station-list');
        $this->checkConnexionStatus();
    }

    /**
     * CI entry point
     *
     * @return void direct to the correct view
     */
    public function index()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $this->connexion();
    }

    /**
    * Login interface for unknown/authentified user
    *
    * @link ./authentification.php for the abstract class
    * @return view login form
    */
    public function connexion()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        // requirements
        $this->load->helper('pages');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        // build view data
        $data = pageFetchConfig('login'); // fetch information to build the HTML header
        $data['msg'] = $this->session->userdata("msg"); // message to display in the page
        $data['userName'] = null;

        $this->session->set_userdata("msg", null); // reset session message

        // form control
        $this->form_validation->set_rules('username', i18n('Username'), 'required');
        $this->form_validation->set_rules('password', i18n('Password'), 'required');
        $this->form_validation->set_rules('confirm', i18n('Password Confirmation'), 'required');

        // display the view
        $pages = new Pages();
        $pages->view('login', $data);
    }

    /**
    * Redirect user depending on its credentials validation
    *
    * @link ./authentification.php for the abstract class
    * @return void
    */
    public function connect()
    {
        where_I_Am(__FILE__, __CLASS__, __FUNCTION__, __LINE__, func_get_args());
        $userName =	$this->input->post('login-username');
        $userPassword	=	$this->input->post('login-password');
        try {
            //Chercher l'user correspondant au couple login/pwd
            $user = $this->Service_User->authentify($userName, $userPassword);
            // var_dump($user);
            // exit;
            $this->session->set_userdata("user", serialize($user));
            redirect($this->urlWhenLogged);
        } catch (BusinessException $be) {
            //Message d'erreur dans la variable "msg" de la session. Impossible d'utiliser flashdata car il y a 2 redirections en cas d'erreur de login
            $this->session->set_userdata("msg", $be->getMessage());
            // the password is wrong, retry.
            redirect($this->urlConnexion);
        }
    }
}

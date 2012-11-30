<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// clear;php5 -f /var/www/Probe/cli.php 'cmd'
class cmd extends CI_Controller {

	function __construct() {
		// if (isset($_SERVER['REMOTE_ADDR'])) { // n'est pas definie en php5-cli
		// 	log_message('warning',  'CLI script access allowed only');
		// 	die();
		// }

	parent::__construct();
	where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		include_once(BASEPATH.'core/Model.php'); // need for load models manualy
		include_once(APPPATH.'models/station.php');

		$this->station = new Station();
	}


	// la fonction qui ce lancera par defaut dans cette classe 
	// clear;php5 -f /var/www/Probe/cli.php 'cmd'
	function index($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->index($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->station->stationsList)) {
			// on rapelle cette meme fonction mais avec de vrai parametre : Toutes les stations
			$this->index (array_keys ($this->station->stationsList));
			return false;
		}

		try {
			// on recupere les confs de $station
			$conf = end($this->station->config($station)); // $station est le ID ou le nom
			// on lance la recup des Archives de cette station
			$this->station->AllCollector ($conf);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}


	// clear;php5 -f /var/www/Probe/cli.php 'cmd/hilowCollectors'
	function hilowsCollectors($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			$item_ID = is_numeric($station) ? array_search($station, $this->station->stationsList) : $station;
			if (isset($item_ID)) {
				// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
				// on recupere les confs de $station
				$itemConf = end($this->station->config($item_ID)); // $station est le ID ou le nom
				$this->station->HilowsCollector ($itemConf);
				return false;
			}
			else return false;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
	

	// clear;php5 -f /var/www/Probe/cli.php 'cmd/curentCollectors'
	function curentCollectors($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		try {
			$item_ID = is_numeric($station) ? array_search($station, $this->station->stationsList) : $station;
			// on rapelle cette meme fonction mais avec de vrai paarametre : Toutes les stations
			// on recupere les confs de $station
			$itemConf = end($this->station->config($item_ID)); // $station est le ID ou le nom
			$this->station->LpsCollector ($itemConf);
			return true;
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}


	// clear;php5 -f /var/www/Probe/cli.php 'cmd/dataCollectors'
	function dataCollectors($station = null) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->dataCollectors($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->station->stationsList)) {
			// on rapelle cette meme fonction mais avec de vrai parametre : Toutes les stations
			$this->dataCollectors (array_keys ($this->station->stationsList));
			return false;
		}
		try {
			// on recupere les confs de $station
			$conf = end($this->station->config($station)); // $station est le ID ou le nom
			
			// on lance la recup des Archives de cette station
			$this->station->ArchCollector ($conf);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}
	
	
	// clear;php5 -f /var/www/Probe/cli.php 'cmd/configCollectors'
	function configCollectors($station = null, $force = false) {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());
		if (is_array($station)) {
			foreach ($station as $item) {
				// on rapelle cette meme fonction mais individuellement pour chaque station
				$this->configCollectors($item);
			}
			return false;
		}
		elseif ($station===null && !empty($this->station->stationsList)) {
			// on rapelle cette meme fonction mais avec de vrai parametre : les ID de toutes les stations
			$this->configCollectors (array_keys ($this->station->stationsList));
			return false;
		}
		try {
			$conf = end($this->station->config($station));

			if (count($conf)<30 or $force==true) {
				$readconf = $this->station->ConfCollector($conf);
				foreach ($readconf as $key => $val) {
					if (strpos($key, 'TR:Config:')!==FALSE)
						$ToStoreConfig[str_replace('TR:Config:', '', $key)] = $val;
				}
				$this->station->arrays2dbconfs($conf['_id'], $ToStoreConfig);
			}
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
	}


	// clear;php5 -f /var/www/Probe/cli.php 'cmd/makeNewStation'
	function makeNewStation() {
		where_I_Am(__FILE__,__CLASS__,__FUNCTION__,__LINE__,func_get_args());

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$formFields = $this->config->item('add-station-form');
		foreach ($formFields as $section => $fields) {
			foreach ($fields as $field => $value) {
				if ($field != 'port') {
					$this->form_validation->set_rules(
						$field, i18n(sprintf("install.%s.%s", $section, $field)), 'trim|required');
				}
			}
		}
		$this->form_validation->set_rules('dbms-password', i18n('install.dbms.password'), 'minlength[8]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('configuration/add-station');
		} else {
			$this->load->view('configuration/add-station/success');
		}

		try {
			include_once(APPPATH.'models/db_builder.php');
			$newID = current ($this->station->availableID()); // prend le 1er ID vide parmis ceux disponible

//			$dbb = new db_builder('mysql','nbv4023','root','localhost',3306,'');
//			$workingDb = ??? ; // this should be dynamic
			$dbb = new db_builder(
				$workingDb['dbdriver']='mysql',
				$workingDb['password']='*****',
				$workingDb['username']='root',
				$workingDb['hostname']='localhost',
				$workingDb['port']=3306,
				$workingDb['database']=NULL);
			$dbb->createAppDb($newID);
			$dsn = $dbb->getDsn();

			$this->station->arrays2dbconfs(
				$newID, 
				array_merge(
					array(
						'_ip'=>'192.168.0.xxx', 
						'_port'=>22222, 
						'_name'=>'NewVP2-'.$newID, 
						'_type'=>'vp2'
						), 
					$dsn
					)
				);
			return true; // after, you can read : $this->station->config($newID);
		}
		catch (Exception $e) {
			log_message('warning',  $e->getMessage());
		}
		return false;
	}
}
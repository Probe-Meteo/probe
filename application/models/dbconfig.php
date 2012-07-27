<?php
// http://fmaz.developpez.com/tutoriels/php/comprendre-pdo/
class dbconfig extends CI_Model {
	protected $DBConf = NULL;
	public $lst = NULL;

	function __construct()
	{
		parent::__construct();
		$this->list_stations();
	}

	/**
	 * retourne un tableau de tous les noms et db_ID de toute les stations
	 * @return	array (db_ID => Name)
	 */
	function list_stations()
	{// on demande la liste des NOM des stations meteo et les ID associé
// 		$lst = $this->db->query( 
// 			'SELECT `CFG_STATION_ID`, `CFG_VALUE` 
// 			FROM `TR_CONFIG` 
// 			WHERE `CFG_CODE`=1 
// 			LIMIT 16');
		$this->db->select('CFG_STATION_ID, CFG_VALUE')->from('TR_CONFIG')->where('CFG_CODE',1)->limit(16);
		$lst = $this->db->get();
		 // on met en forme les resultat sous forme de tableau
		foreach($lst->result() as $item)
			$this->lst[$item->CFG_STATION_ID] = $item->CFG_VALUE;

		return $this->lst;
	}

	/**
	 * recupere sous forme de table l'ensemble des configs d'une ou de toutes les station
	 * @var item
		item peut etre le Numero db_ID ou le nom de la station dont on veut les confs
		si item est homis alors toutes les conf de toutes les stations sont retourné
	 * @return array ('name' => array (configs))
	 */
	function dbconfs2arrays($item = null)
	{
		if (!empty($item)) {
			if (is_numeric($item) && array_key_exists($item, $this->lst))
				$lst[$item]=$this->lst[$item];
			elseif (in_array($item, $this->lst))
				$lst[array_search($item, $this->lst)]=$item;
		}
		else {
			$lst=$this->lst;
		}
		
		$query = 'SELECT * FROM `TR_CONFIG` WHERE `CFG_STATION_ID`=? LIMIT 0 , 100';
		
		foreach($lst as $id => $item)
		{ // pour chaque station meteo on dresse la liste des configs
			$CurentStation = $this->db->query($query, $id);
			foreach($CurentStation->result() as $val)
			{ // on integre chacune des configs dans un tableau a 2 dimensions qui sera utilisé par la suite
				$confs[$item][strtolower($val->CFG_LABEL)]=$val->CFG_VALUE;
			}
			print_r($confs[$item]);
		}
		return $confs;
	}
	
	function arrays2dbconfs($id, $conf)
	{
		$query = 'INSERT INTO `TR_CONFIG` (CFG_STATION_ID, CFG_CODE, CFG_LABEL, CFG_VALUE, CFG_LAST_WRITE) VALUES (?, ?, ?, ?, ?);';
		$prep = $this->db->prepare($query);

		//Associer des valeurs aux place holders
		$prep->bindValue($id, 1, 'name', , );
		$prep->bindValue($id, 2, 'ip', , );
		$prep->bindValue($id, 3, 'port', , );
		$prep->bindValue($id, 4, 'type', , );
		$prep->bindValue($id, 5, 'db', , );
		$prep->bindValue($id, , , , );

		//Compiler et exécuter la requête
		$prep->execute();

//Clore la requête préparée
$prep->closeCursor();
$prep = NULL;
	}
}
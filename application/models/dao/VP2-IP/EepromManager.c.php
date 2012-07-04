<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################

class dataFetcher extends ConnexionManager
{
	function __construct($name, $myConfig)	{
		parent::__construct($name, $myConfig);
	}
	/*
	@description: functionDescription
	@return: functionReturn
	@param: returnValue
	*/
	function RawConverter($DataModele, $RawStr) { //
		$x = array();
		foreach($DataModele as $key=>$val) {
			if (is_int($val['pos'])) {
				$StrValue = substr ($RawStr, $val['pos'], $val['len']);
			}
			else {
				$StrValue = Tools::getBits(
					substr ($RawStr, (int)$val['pos'],1),
					($val['pos']-(int)$val['pos']-0.1)*10,
					$val['len']);
			}

			if ($val['fn']) {
				$x[$key] = call_user_func($val['fn'], $StrValue);
				
// I benchmarked the comparison in speed between variable functions, call_user_func, and eval.  My results are below:
// 
// Variable functions took 0.125958204269 seconds.
// call_user_func took 0.485446929932 seconds.
// eval took 2.78526711464 seconds.
// 
// This was run on a Compaq Proliant server, 180MHz Pentium Pro 256MB RAM.  Code is as follows:
// 
// <?php
// 
// function fa () { return 1; }
// function fb () { return 1; }
// function fc () { return 1; }
// 
// $calla = 'fa';
// $callb = 'fb';
// $callc = 'fc';
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     $x += $calla();
//     $x += $callb();
//     $x += $callc();
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "Variable functions took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     $x += call_user_func('fa', '');
//     $x += call_user_func('fb', '');
//     $x += call_user_func('fc', '');
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "call_user_func took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// $time = microtime( true );
// for( $i = 5000; $i--; ) {
//     $x = 0;
//     eval( '$x += ' . $calla . '();' );
//     eval( '$x += ' . $callb . '();' );
//     eval( '$x += ' . $callc . '();' );
//     if( $x != 3 ) die( 'Bad numbers' );
// }
// echo( "eval took " . (microtime( true ) - $time) . " seconds.<br />" );
// 
// ? >
				
			}
			else {
				$x[$key] = $StrValue;
			}
		}
		return $x;
	}
	/*
	@description: Lis les config courante disponible sur la station
	@return: retourne un tableau de la forme :
		array ('Date Heure' => array ( Conf1, Conf2, ... ));
	@param: none
	*/
	function GetConfig() { //
		$CONFS = false;
		 try {
			Tools::Waiting (0,'[EEBRD] : Download the current Config');
			
// 			$P=str_pad(strtoupper(dechex(0)),3,'0',STR_PAD_LEFT);
// 			$L=str_pad(strtoupper(dechex(177)),2,'0',STR_PAD_LEFT);
			self::RequestCmd("EEBRD 000 B1\n");
			$data = fread($this->fp, 177+2);
			self::VerifAnswersAndCRC($data, 177+2);
			
// 			$P=str_pad(strtoupper(dechex(4092)),3,'0',STR_PAD_LEFT);
// 			$L=str_pad(strtoupper(dechex(1)),2,'0',STR_PAD_LEFT);
			self::RequestCmd("EEBRD FFC 01\n");
			$data2 = fread($this->fp, 1+2);
			self::VerifAnswersAndCRC($data2, 1+2);
				$v = end($this->EEPROM);
				$v['pos'] = 1;
				$k = key($this->EEPROM);
			$CONFS[date('Y/m/d H:i:s')] = array_merge (
				self::RawConverter($this->EEPROM, $data),
				self::RawConverter(array($k => $v), $data2));
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $CONFS;
	}
	/*
	@description: Lis les valeur courante de tous les capteur disponible sur la station
	@return: retourne un tableau de tableau de la forme :
		array (
			'Date Heure_0' => array ( Data1, Data2, ... ),
			'Date Heure_0 + 2.5sec ' => array ( Data1, Data2, ... ),
			... );
	@param: Nombre de cycle CURRENT a relever (Par defaut 1 seul).
	*/
	function GetLoop ($nbr=1) {
		$_NBR = $nbr;
		$LOOPS = false;
		try {
			self::RequestCmd("LOOP $nbr\n");
			while ($nbr-- > 0) {
				$data = fread($this->fp, 99);
				self::VerifAnswersAndCRC($data, 99);
				Tools::Waiting (0,'[LOOP] : Download the current Values');
				$LOOPS[date('Y/m/d H:i:s')] = self::RawConverter($this->Loop, $data);
				echo implode("\t",$LOOPS[0])."\n";
			}
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $LOOPS;
	}
	/*
	@description: Lis les valeur d´archive a partir d´une date
	@return: retourne un tableau de la forme :
		array (
			'Date Heure_0' => array ( Arch1, Arch2, ... ),
			'Date Heure_1' => array ( Arch1, Arch2, ... ),
			... );
	@param: Date de la 1ere archive a lire (par defaut : 2012/01/01 00:00:00)
	*/
	function GetDmpAft($last='2012/01/01 00:00:00') { //
		$DATAS=false;
		try {
			$firstDate2Get=Tools::is_date($last);
			self::RequestCmd("DMPAFT\n");
			$RawDate = Tools::DMPAFT_SetVP2Date($firstDate2Get);
			fwrite($this->fp, $RawDate);				// Send this date (parametre #1)
			$crc = Tools::CalculateCRC($RawDate);			// define the CRC of my date
			self::RequestCmd($crc);					// Send the CRC (parametre #2)
			$data = fread($this->fp, 6);				// we read the properties : item count and first item position
			self::VerifAnswersAndCRC($data, 6);
// 			$nbrArch=0;
			$LastArchDate = 0;
// 			$retry = $this->retry-1;
			$nbrPages = Tools::hexToDec (strrev(substr($data,0,2)));	// Split Bytes in revers order : Nbr of page
			$firstArch = Tools::hexToDec (strrev(substr($data,2,2)));	// Split Bytes in revers order : # of first archived
				Tools::Waiting (0,'There are '.$nbrPages.'p. in queue, from archive '.$firstArch.' on first page since '.$last.'.');
			fwrite($this->fp, Tools::ACK);				// Send ACK to start
			for ($j=0; $j<$nbrPages; $j++) {
				if ( !((time()+10)%300) ) {
				// la recuperation des archives bloque la lecture des capteurs donc on le fait par petit bout
					throw new Exception(_('Please retry later to finish, Data sensors must be checked in few second.'));
				}
				$Page = fread($this->fp, 267);
				Tools::Waiting (0,'Download Archive PAGE #'.$j.' since : '.Tools::DMPAFT_GetVP2Date(substr($Page,1+52*($firstArch),4)));
				self::VerifAnswersAndCRC($Page, 267);
				fwrite ($this->fp, Tools::ACK);
				for ($k=$firstArch; $k<=4; $k++) {			// ignore les 1er valeur hors champ.
					$ArchiveStrRaw = substr ($Page, 1+52*$k, 52);
					$ArchDate = Tools::DMPAFT_GetVP2Date(substr($ArchiveStrRaw,0,4));
					if (strtotime($ArchDate) > strtotime($LastArchDate)) {
					// ignore les derniere valeur hors champ, car on parcoure une liste circulaire
					// donc la deniere valeur a extraire precede la plus vielle valleur de cette liste
						$DATAS[$ArchDate] = self::RawConverter($this->DumpAfter, $ArchiveStrRaw);
						Tools::Waiting (0,'Page #'.$j.'-'.$k.' of '.$ArchDate.' archived Ok.');
						$LastArchDate = $ArchDate;
					}
					else {
						throw new Exception(sprintf(_('Page #%d-%d of %s Ignored (Out of Range).'),$j, $k, $ArchDate));
					}
					$firstArch=0;
				}
			}
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $DATAS;
	}
	/*
	@description: Lis l'heure de la station
	@return: retourne l'heure de la station ou FALSE en cas d'echec
	@param: none
	*/
	function fetchStationTime() {// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		$TIME = False;
		try {
			self::RequestCmd("GETTIME\n");
			$TIME = fread($this->fp, 8);
			self::VerifAnswersAndCRC($TIME, 8);
			$TIME = (ord($TIME[5])+1900)
				.'/'.str_pad(ord($TIME[4]),2,'0',STR_PAD_LEFT)
				.'/'.str_pad(ord($TIME[3]),2,'0',STR_PAD_LEFT)
				.' '.str_pad(ord($TIME[2]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[1]),2,'0',STR_PAD_LEFT)
				.':'.str_pad(ord($TIME[0]),2,'0',STR_PAD_LEFT);
			Tools::Waiting (0, 'Real : '.date('Y/m/d H:i:s').' vs VP2 : '.$TIME);
			return $TIME;
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return $TIME;
	}
	/*
	@description: compare l'heure de la station a celle du serveur web et lance la synchro si besoin
	@return: renvoi TRUE si deja a l'heure , renvoi l'heure en cas de Synchro reuci et FALSE en cas d'echec
	@param: maxLag est la valeur maxi toleré pour le decalage, force==TRUE ignorera le decalage.
	*/
	function clockSync($maxLag, $force=false) {
		$TIME = False;
		$realLag = abs(strtotime($this->fetchStationTime()) - strtotime(date('Y/m/d H:i:s')));
		if ($realLag > $maxLag || $force) {
			Tools::Waiting( 0, sprintf( _('[Infos] Default Clock synchronize : %ssec'), $realLag) );
			if ($realLag < 3600-$maxLag || $realLag > 3600*12 || $force) {	// OK
				if ($TIME = $this->updateStationTime()) {							// OK
					Tools::Waiting (0,_('[Infos] Clock synchronizing.'));					// OK
				}
				else Tools::Waiting( 0, _( '[Echec] Clock synch.'));
			}
			else Tools::Waiting( 0, sprintf( _('[Infos] So mutch Default : %ssec. Please change it manualy'), $realLag) );
		}
		else return true;
		return $TIME;
	}
	/*
	@description: Force l´heure de la station a la meme heure que le serveur web
	@return: renvoi la nouvelle heure ou FALSE en cas d'echec
	@param: none
	*/
	function updateStationTime() {// 0x35 16 00 1d 0c 6f  0x7c 44  ==  2011/12/29 00:22:53
		try {
			self::RequestCmd("SETTIME\n");
			list($_date, $_clock) = explode(' ', date('Y/m/d H:i:s'));
			list($y,$m,$d) = explode('/', $_date);
			list($h,$i,$s) = explode(':', $_clock);
			self::RequestCmd (chr($s).chr($i).chr($h).chr($d).chr($m).chr($y-1900) . Tools::CalculateCRC($TIME));
			Tools::Waiting (0,'[SETTIME] : '.$_date.' '.$_clock);
			return $_date.' '.$_clock;
		}
		catch (Exception $e) {
			Tools::Waiting (0, $e->getMessage());
		}
		return False;
	}
} 































?>
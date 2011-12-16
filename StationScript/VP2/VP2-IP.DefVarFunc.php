<?php
//	$ip_vp2 = "VP2";
	$ip_vp2 = "nas-alban.no-ip.org";
	$port_vp2 = 22222;

	$symbols = array (
	'CR' => chr(0x0D), // \r
	'LF' => chr(0x0A), // \n
	'LFCR' => chr(0x0A).chr(0x0D),
	'ESC' => chr(0x1b), // Echap
	'ACK' => chr(0x06), // Compris
	'NAK' => chr(0x21), // Pas Compris
	'CANCEL' => chr(0x18), // Bad CRC Code
	'_OK_' => "\n\rOK\n\r");

$crc_table = array(// CRC16-CCITT
	0x0000,  0x1021,  0x2042,  0x3063,  0x4084,  0x50a5,  0x60c6,  0x70e7,
        0x8108,  0x9129,  0xa14a,  0xb16b,  0xc18c,  0xd1ad,  0xe1ce,  0xf1ef,
        0x1231,  0x0210,  0x3273,  0x2252,  0x52b5,  0x4294,  0x72f7,  0x62d6,
        0x9339,  0x8318,  0xb37b,  0xa35a,  0xd3bd,  0xc39c,  0xf3ff,  0xe3de,
        0x2462,  0x3443,  0x0420,  0x1401,  0x64e6,  0x74c7,  0x44a4,  0x5485,
        0xa56a,  0xb54b,  0x8528,  0x9509,  0xe5ee,  0xf5cf,  0xc5ac,  0xd58d,
        0x3653,  0x2672,  0x1611,  0x0630,  0x76d7,  0x66f6,  0x5695,  0x46b4,
        0xb75b,  0xa77a,  0x9719,  0x8738,  0xf7df,  0xe7fe,  0xd79d,  0xc7bc,
        0x48c4,  0x58e5,  0x6886,  0x78a7,  0x0840,  0x1861,  0x2802,  0x3823,
        0xc9cc,  0xd9ed,  0xe98e,  0xf9af,  0x8948,  0x9969,  0xa90a,  0xb92b,
        0x5af5,  0x4ad4,  0x7ab7,  0x6a96,  0x1a71,  0x0a50,  0x3a33,  0x2a12,
        0xdbfd,  0xcbdc,  0xfbbf,  0xeb9e,  0x9b79,  0x8b58,  0xbb3b,  0xab1a,
        0x6ca6,  0x7c87,  0x4ce4,  0x5cc5,  0x2c22,  0x3c03,  0x0c60,  0x1c41,
        0xedae,  0xfd8f,  0xcdec,  0xddcd,  0xad2a,  0xbd0b,  0x8d68,  0x9d49,
        0x7e97,  0x6eb6,  0x5ed5,  0x4ef4,  0x3e13,  0x2e32,  0x1e51,  0x0e70,
        0xff9f,  0xefbe,  0xdfdd,  0xcffc,  0xbf1b,  0xaf3a,  0x9f59,  0x8f78,
        0x9188,  0x81a9,  0xb1ca,  0xa1eb,  0xd10c,  0xc12d,  0xf14e,  0xe16f,
        0x1080,  0x00a1,  0x30c2,  0x20e3,  0x5004,  0x4025,  0x7046,  0x6067,
        0x83b9,  0x9398,  0xa3fb,  0xb3da,  0xc33d,  0xd31c,  0xe37f,  0xf35e,
        0x02b1,  0x1290,  0x22f3,  0x32d2,  0x4235,  0x5214,  0x6277,  0x7256,
        0xb5ea,  0xa5cb,  0x95a8,  0x8589,  0xf56e,  0xe54f,  0xd52c,  0xc50d,
        0x34e2,  0x24c3,  0x14a0,  0x0481,  0x7466,  0x6447,  0x5424,  0x4405,
        0xa7db,  0xb7fa,  0x8799,  0x97b8,  0xe75f,  0xf77e,  0xc71d,  0xd73c,
        0x26d3,  0x36f2,  0x0691,  0x16b0,  0x6657,  0x7676,  0x4615,  0x5634,
        0xd94c,  0xc96d,  0xf90e,  0xe92f,  0x99c8,  0x89e9,  0xb98a,  0xa9ab,
        0x5844,  0x4865,  0x7806,  0x6827,  0x18c0,  0x08e1,  0x3882,  0x28a3,
        0xcb7d,  0xdb5c,  0xeb3f,  0xfb1e,  0x8bf9,  0x9bd8,  0xabbb,  0xbb9a,
        0x4a75,  0x5a54,  0x6a37,  0x7a16,  0x0af1,  0x1ad0,  0x2ab3,  0x3a92,
        0xfd2e,  0xed0f,  0xdd6c,  0xcd4d,  0xbdaa,  0xad8b,  0x9de8,  0x8dc9,
        0x7c26,  0x6c07,  0x5c64,  0x4c45,  0x3ca2,  0x2c83,  0x1ce0,  0x0cc1,
        0xef1f,  0xff3e,  0xcf5d,  0xdf7c,  0xaf9b,  0xbfba,  0x8fd9,  0x9ff8,
        0x6e17,  0x7e36,  0x4e55,  0x5e74,  0x2e93,  0x3eb2,  0x0ed1,  0x1ef0);

    	$lamp = false; // etat de la lampe

function Waiting ($s=10, $msg = 'Waiting and retry')
{
	$w = '-\|/';
	for ($j=0;$j<$s;$j++)
	{
		usleep(100000);
		echo "\r".date('Y/m/d H:i:s u')."\t".$msg.' '.$w[$j%4];
	}
	echo "\n";
}


// Convert human redable date ('2011/12/31 15:35:01') to 6 bytes of VP2 format (0x01 23 0f 1f 0c 6f)
function HumanDate_To_TIME ($StrDate)
{
	$y = substr($StrDate, 0, 4)-1900;
	$m = (substr($StrDate, 5, 2))<<8;
	$d = (substr($StrDate, 8, 2))<<16;
	$h = (substr($StrDate, -8, 2))<<24;
	$min = (substr($StrDate, -5, 2))<<32;
	$s = (substr($StrDate, -2))<<40;
	return $s+$min+$h+$d+$m+$y;
}

// Convert 6 bytes of VP2 Date (0x01 23 0f 1f 0c 6f) to human redable format ('2011/12/31 15:35:01')
function TIME_To_HumanDate ($VP2Date)
{// sur 6 Octes : sec min h  d m y
	$y = ($VP2Date & 0xff) + 1900;
	$m = str_pad(($VP2Date & 0xff00)>>8,2,'0',STR_PAD_LEFT);
	$d = str_pad(($VP2Date & 0xff0000)>>16,2,'0',STR_PAD_LEFT);
	$h = str_pad(($VP2Date & 0xff000000)>>24,2,'0',STR_PAD_LEFT);
	$min = str_pad(($VP2Date & 0xff00000000)>>32,2,'0',STR_PAD_LEFT);
	$s = str_pad(($VP2Date & 0xff0000000000)>>40,2,'0',STR_PAD_LEFT);
	return $y.'/'.$m.'/'.$d.' '.$h.':'.$min.':'.$s;
}
function DMPAFT_SetVP2Date ($StrDate)
{// 19-06-2003 9:30:00  =>  0x06D3 0x03A2
	$y = substr($StrDate, 0, 4);
	$m = substr($StrDate, 5, 2);
	$d = substr($StrDate, 8, 2);
	$h = substr($StrDate, -8, 2);
	$min = substr($StrDate, -5, 2);
	$s = substr($StrDate, -2);
	$d = ((($y-2000)*512+$m*32+$d)<<16) + ($h*100+$min);
	$d = array( chr(($d&0xff000000)>>24), chr(($d&0xff0000)>>16), chr(($d&0xff00)>>8), chr($d&0xff) );
	return $d;
}
function DMPAFT_GetVP2Date ($VP2Date)
{// 19-06-2003 9:30:00  <=  0x06D3 0x03A2
	$DateStamp = (ord($VP2Date[0])<<8)+ord($VP2Date[1]); // 0x06 0xD3
		$y = (($DateStamp & 0xFE00)>>9)+2000;
		$m = str_pad(($DateStamp & 0x01E0)>>5,2,'0',STR_PAD_LEFT);
		$d = str_pad($DateStamp & 0x1f,2,'0',STR_PAD_LEFT);
	$TimeStamp = (ord($VP2Date[2])<<8)+ord($VP2Date[3]); // 0x03 0xA2
		$h = str_pad((int)($TimeStamp/100),2,'0',STR_PAD_LEFT);
		$min = str_pad($TimeStamp-$h*100,2,'0',STR_PAD_LEFT);
	return $y.'/'.$m.'/'.$d.' '.$h.':'.$min.':00';
}
function CRC16_CCITT($ptr)
{// le CRC16 d'ųne chaine + son CRC est toujours = a 0x0000
	$crc = 0x0000;
	$crc_tb = $GLOBALS['crc_table'];
	for ($i = 0; $i < strlen($ptr); $i++)
	{
		$crc =  $crc_tb[(($crc>>8) ^ ord($ptr[$i]))] ^ (($crc<<8) & 0x00FFFF);
//		echo strlen($ptr).' > 0x'.dechex($ptr).' 0x'.dechex($crc)."\n";
	}
	return array( 'Confirm' => !$crc, 0 => chr(($crc>>8)&0xff), 1 => chr($crc&0xff), 'all' => $crc);
	// WARNING if $ptr is string with only chr(0) like 0x000000000000... 'Confirm' was True !
}
function toggleLAMP($fp)
{
	$symb = $GLOBALS['symbols'];
	fwrite ($fp,'LAMPS '.(($GLOBALS['lamp'])?'0':'1').$symb['LF']);
	Waiting (4, 'Activation/Desactivation du retroeclairage.');
	$ans = fread($fp,6);
	if ($ans==$symb['_OK_'])
	{
		$GLOBALS['lamp'] = !$GLOBALS['lamp'];
		return TRUE;
	}
//	else echo 'pas de reponce :'.$ans.' .';
	return FALSE;
}
?>

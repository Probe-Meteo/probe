<?php
// ##############################################################################################
/// IX. Data Formats (See docs on pages 28, 29)
/// 3. DMP and DMPAFT data format
/// There are two different archived data formats. Rev "A" firmware, dated before April 24, 2002
/// uses the old format. Rev "B" firmware dated on or after April 24, 2002 uses the new format. The
/// fields up to ET are identical for both formats. The only differences are in the Soil, Leaf, Extra
// ##############################################################################################
/**
Convention de nomage :
> Debut de chaine '/^'
> Type de Donnes en base :
			TA :
			TR :
			NO : valeur non stocket en DB
> 1er separeteur le ':'
> Famille de donnée (precédé du type de Table sur 2 caractere en MAJUSCULE) :
			Config = Config user (unité, reglage, ...),
			Arch = Valeur ou etat du relevé d´archive,
			Current = Valeur ou etat actuelle qui etende les données d´archive TA_Arch,
			Sensor = valeur associé a un capteur ex:etalonnage, valeur de declanchement d'alarme,
			Factory = Valeur Usine,
			Other = différente infos fournie par la station.
			Current = Valeur ou etat actuelle qui n´ont d´importance qu´au moment de la lecture ex: valeur d´alarme en cour de depassement.

> 2ieme separeteur le ':'
> Type de donnée :
			Hum = Humidité  
			Temp = Temperature (<!> il en existe 3 format)
			SoilMoisture = Soil Moisture - l’humidité superficielle du sol
			LeafWetness = Leaf wetness - l’humidité residuelle sur le feuillage
			Various = pour les autres données, vent pression, UV, ...
> 3ieme separateur le ':'
> Nom du capteur :
			sur quelques lettres ex : inside, outside, #2, #3, #4...
> 4ieme separateur ':'
> Descriptif valeur :
			infos sur la valeur relevée ex : Wind:Dir, Wind:Speed, Wind:10mSpeedAvg
>Fin de chaine '$/'
**/

	$this->DumpAfter = array (
	'TA:Arch:Various:Time:UTC'		=>	array( 'pos' => 0,	'len' => 4,	'fn'=>'Tools::DMPAFT_GetVP2Date',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Date'	),
//	'TA:Arch:none:Time'			=>	array( 'pos' => 2,	'len' => 2,	'fn'=>'Tools::Raw2Time',	'SI'=>'UTC',	'min'=>0,	'max'=>0xFFFF,	'err'=>0xFFFF,	'unit'=> 'Time'	),

	'TA:Arch:Temp:Out:Average'		=>	array( 'pos' => 4,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),
	'TA:Arch:Temp:Out:High'			=>	array( 'pos' => 6,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32768,	'unit'=> '°F'	),
	'TA:Arch:Temp:Out:Low'			=>	array( 'pos' => 8,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>-32767,	'unit'=> '°F'	),

	'TA:Arch:Rain:RainFall:Sample'		=>	array( 'pos' => 10,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic'	),
	'TA:Arch:Rain:RainRate:HighSample'	=>	array( 'pos' => 12,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'clic/h'),
	'TA:Arch:Various:Bar:Current'		=>	array( 'pos' => 14,	'len' => 2,	'fn'=>'Tools::Pressure',	'SI'=>'barSI',	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> 'in.Hg'),
	'TA:Arch:Various:Solar:Radiation'	=>	array( 'pos' => 16,	'len' => 2,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>3000,	'err'=>32767,	'unit'=> 'W/m²'	),
//	'TA:Arch:Various:Wind:Sample'		=>	array( 'pos' => 18,	'len' => 2,	'fn'=>'Tools::Samples',	'SI'=>NULL,	'min'=>0,	'max'=>0xFFFF,	'err'=>0,	'unit'=> '-'	),

	'TA:Arch:Temp:In:Average'		=>	array( 'pos' => 20,	'len' => 2,	'fn'=>'Tools::Temp',		'SI'=>'tempSI',	'min'=>0,	'max'=>150,	'err'=>32767,	'unit'=> '°F'	),

	'TA:Arch:Hum:In:Current'		=>	array( 'pos' => 22,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'TA:Arch:Hum:Out:Current'		=>	array( 'pos' => 23,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'TA:Arch:Various:Wind:SpeedAvg'		=>	array( 'pos' => 24,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'mph'	),
	'TA:Arch:Various:Wind:HighSpeed'	=>	array( 'pos' => 25,	'len' => 1,	'fn'=>'Tools::Speed',		'SI'=>'mBySec',	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mph'	),
	'TA:Arch:Various:Wind:HighSpeedDirection'=>	array( 'pos' => 26,	'len' => 1,	'fn'=>'Tools::Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),
	'TA:Arch:Various:Wind:DominantDirection'=>	array( 'pos' => 27,	'len' => 1,	'fn'=>'Tools::Angle16',	'SI'=>NULL,	'min'=>0,	'max'=>16,	'err'=>255,	'unit'=> '°'	),

	'TA:Arch:Various:UV:IndexAvg'		=>	array( 'pos' => 28,	'len' => 1,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> '-'	),
	'TA:Arch:Various:ET:Hour'		=>	array( 'pos' => 29,	'len' => 1,	'fn'=>'Tools::ET_h',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>0,	'unit'=> 'mm'	),
	'TA:Arch:Various:Solar:HighRadiation'	=>	array( 'pos' => 30,	'len' => 2,	'fn'=>'Tools::Radiation',	'SI'=>NULL,	'min'=>0,	'max'=>2000,	'err'=>0,	'unit'=> 'W/m²'	),
	'TA:Arch:Various:UV:HighIndex'		=>	array( 'pos' => 32,	'len' => 1,	'fn'=>'Tools::UV',		'SI'=>NULL,	'min'=>0,	'max'=>25,	'err'=>255,	'unit'=> 'W/m²'	),
	'TA:Arch:Various::ForecastRule'		=>	array( 'pos' => 33,	'len' => 1,	'fn'=>'Tools::Forecast',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>193,	'unit'=> '-'	),

	'TA:Arch:Temp:Leaf#1:Current'		=>	array( 'pos' => 34,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Leaf#2:Current'		=>	array( 'pos' => 35,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>-90,	'max'=>164,	'err'=>255,	'unit'=> '°F'	),

	'TA:Arch:LeafWetnesses:Leaf#1:Current'	=>	array( 'pos' => 36,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),
	'TA:Arch:LeafWetnesses:Leaf#2:Current'	=>	array( 'pos' => 37,	'len' => 1,	'fn'=>'Tools::Wetnesses',	'SI'=>NULL,	'min'=>0,	'max'=>15,	'err'=>255,	'unit'=> '-'	),

	'TA:Arch:Temp:Soil#1:Current'		=>	array( 'pos' => 38,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#2:Current'		=>	array( 'pos' => 39,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#3:Current'		=>	array( 'pos' => 40,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:Soil#4:Current'		=>	array( 'pos' => 41,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

// 	'Other:DownloadRecordType'	=>	array( 'pos' => 42,	'len' => 1,	'fn'=>'Tools::SpRev',		'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>null,	'unit'=> 'Rev'	),
	'TA:Arch:Hum:#2:Current'		=>	array( 'pos' => 43,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),
	'TA:Arch:Hum:#3:Current'		=>	array( 'pos' => 44,	'len' => 1,	'fn'=>'Tools::Rate',		'SI'=>NULL,	'min'=>0,	'max'=>100,	'err'=>255,	'unit'=> '%'	),

	'TA:Arch:Temp:#2:Current'		=>	array( 'pos' => 45,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:#3:Current'		=>	array( 'pos' => 46,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),
	'TA:Arch:Temp:#4:Current'		=>	array( 'pos' => 47,	'len' => 1,	'fn'=>'Tools::SmallTemp',	'SI'=>'tempSI',	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> '°F'	),

	'TA:Arch:SoilMoisture:Soil#1:Current'	=>	array( 'pos' => 48,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'TA:Arch:SoilMoisture:Soil#2:Current'	=>	array( 'pos' => 49,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'TA:Arch:SoilMoisture:Soil#3:Current'	=>	array( 'pos' => 50,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	'TA:Arch:SoilMoisture:Soil#4:Current'	=>	array( 'pos' => 51,	'len' => 1,	'fn'=>'Tools::Moistures',	'SI'=>NULL,	'min'=>0,	'max'=>0xFF,	'err'=>255,	'unit'=> 'cb'	),
	);

?>
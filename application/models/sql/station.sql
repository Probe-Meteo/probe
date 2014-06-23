-- devrait être fixé avant l'exécution de la requête
-- voir aussi http://ellislab.com/codeigniter/user-guide/database/connecting.html
USE %s ;


CREATE TABLE IF NOT EXISTS TR_SENSOR (
    `SEN_ID` SMALLINT(6) NOT NULL AUTO_INCREMENT,
    `SEN_NAME` VARCHAR(64) NOT NULL COMMENT 'Engine Sensor name',
    `SEN_HUMAN_NAME` VARCHAR(64) NULL DEFAULT NULL COMMENT 'Human readable sensor name',
    `SEN_MAGNITUDE` VARCHAR(32) NULL DEFAULT NULL COMMENT 'Egine aspect messurment',
    `SEN_ENGINE_UNIT` VARCHAR(16) NULL DEFAULT NULL COMMENT 'Default Engine unit (Internationnal System)',
    `SEN_USER_UNIT` VARCHAR(16) NULL DEFAULT NULL COMMENT 'Display unit choised',
    `SEN_DISPLAY_LEVEL` TINYINT(4) NULL DEFAULT NULL COMMENT 'Where Display this Sensor (dashboard...)',
    `SEN_SORT` TINYINT(4) NULL DEFAULT NULL COMMENT 'Sort when listing sensor',
    `SEN_FUNCTION` TEXT NULL DEFAULT NULL COMMENT 'Function to compute data for this sensor',
    `SEN_DEPENDENCY_JSON` TEXT NULL DEFAULT NULL COMMENT 'List of sensors value are requierd',
    `SEN_QUERY_GRP_MODE` varchar(32) NOT NULL DEFAULT 'agregate mode',
    `SEN_DESCRIPTIF` TEXT NULL DEFAULT NULL COMMENT 'Descriptif of this sensor',
    `SEN_MIN_REALISTIC` FLOAT(11) NULL DEFAULT NULL COMMENT 'Minimum realistic value in real context',
    `SEN_MAX_REALISTIC` FLOAT(11) NULL DEFAULT NULL COMMENT 'Maximum realistic value in real context',
    `SEN_DEF_PLOT` VARCHAR(64) NULL DEFAULT NULL COMMENT 'Default Chart for display this Sensor',
    `SEN_MAX_ALARM` FLOAT(11) NULL DEFAULT NULL COMMENT 'max value of alarm for this sensor',
    `SEN_MIN_ALARM` FLOAT(11) NULL DEFAULT NULL COMMENT 'min value of alarm for this sensor',
    `SEN_LAST_CALIBRATE` DATE NULL DEFAULT NULL COMMENT 'Last date of calibrate this sensor',
    `SEN_CALIBRATE_PERIOD` VARCHAR(32) NULL DEFAULT NULL COMMENT 'available period of calibration',

    PRIMARY KEY (`SEN_ID`),
    UNIQUE INDEX `SEN_NAME_UNIQUE` (`SEN_NAME` ASC),
    UNIQUE INDEX `SEN_ID_UNIQUE` (`SEN_ID` ASC)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Description of sensors available to the station';

--
-- Dumping data for table `TR_SENSOR`
--

INSERT INTO `TR_SENSOR` (`SEN_ID`, `SEN_NAME`, `SEN_MAGNITUDE`, `SEN_ENGINE_UNIT`, `SEN_USER_UNIT`, `SEN_HUMAN_NAME`, `SEN_DESCRIPTIF`, `SEN_SORT`, `SEN_FUNCTION`, `SEN_DEPENDENCY_JSON`, `SEN_QUERY_GRP_MODE`, `SEN_DISPLAY_LEVEL`, `SEN_MIN_REALISTIC`, `SEN_MAX_REALISTIC`, `SEN_DEF_PLOT`, `SEN_MAX_ALARM`, `SEN_MIN_ALARM`, `SEN_LAST_CALIBRATE`, `SEN_CALIBRATE_PERIOD`) VALUES
(-6, 'TV:Arch:Temp:Out:Full', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TV:Arch:Temp:Out:Full', 'Coube de temperature', 1, 'val = function (d)\r\n{\r\nreturn toHumanUnit(+d.val);\r\n};\r\nvalUp = function (d)\r\n{\r\nreturn toHumanUnit(+d.valUp+1);\r\n};\r\nvalDown = function (d)\r\n{\r\nreturn toHumanUnit(+d.valDown-1);\r\n}', '{"val":"TA:Arch:Temp:Out:Average","valUp":"TA:Arch:Temp:Out:High","valDown":"TA:Arch:Temp:Out:Low"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(-5, 'TV:Arch:Sun:Out:Phase', 'Percent', '', '%', 'HUMAN NAME is more than TV:Arch:Sun:Out:Phase', 'Position du soleil par rapport a l''orizon', 1, 'val = function (d)\r\n{\r\nvar sunPos = SunCalc.getPosition(dateParser(d), dataheader.ISS.lat, dataheader.ISS.lon);\r\n\r\n    return sunPos.altitude;\r\n\r\nreturn toHumanUnit(-50*Math.cos(sunPos.azimuth)+50);\r\n}', '{"null":"TA:Arch:Temp:Out:Average"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(-4, 'TV:Arch:Temp:Out:THSW', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TV:Arch:Temp:Out:THSW', 'Like Heat Index, the THSW Index uses humidity and temperature to calculate an apparent\r\ntemperature. In addition, THSW incorporates the heating effects of solar radiation and the\r\ncooling effects of wind (like wind chill) on our perception of temperature.\r\n', 1, 'val=function(d){\r\nreturn toHumanUnit(d.T0);\r\n}', '{"T0":"TA:Arch:Temp:Out:Average","W0":"TA:Arch:Various:Wind:SpeedAvg","S0":"TA:Arch:Various:Solar:Radiation","H0":"TA:Arch:Hum:Out:Current"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(-3, 'TV:Arch:Moon:Out:Phase', 'Percent', '', '%', 'HUMAN NAME is more than TV:Arch:Moon:Out:Phase', 'Phase de la lune', 1, 'val = function (d)\r\n{\r\n    var moonPos = SunCalc.getMoonPosition(dateParser(d), dataheader.ISS.lat, dataheader.ISS.lon);\r\n   return moonPos.altitude;\r\n}', '{"null":"TA:Arch:Temp:Out:Average"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(-2, 'TV:Arch:Temp:Out:DEWPOINT', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TV:Arch:Temp:Out:DEWPOINT', 'DESCRIPT', 1, '/*\r\n * Saturation Vapor Pressure formula for range -100..0 Deg. C.\r\n * This is taken from\r\n *   ITS-90 Formulations for Vapor Pressure, Frostpoint Temperature,\r\n *   Dewpoint Temperature, and Enhancement Factors in the Range 100 to +100 C\r\n * by Bob Hardy\r\n * as published in "The Proceedings of the Third International Symposium on Humidity & Moisture",\r\n * Teddington, London, England, April 1998\r\n*/\r\nvar k0 = -5.8666426e3, k1 = 2.232870244e1, k2 = 1.39387003e-2, k3 = -3.4262402e-5, k4 = 2.7040955e-8, k5 = 6.7063522e-1;\r\nfunction pvsIce(T) {\r\n lnP = k0/T + k1 + (k2 + (k3 + (k4*T))*T)*T + k5*Math.log(T);\r\n    return Math.exp(lnP);\r\n}\r\n\r\n/**\r\n * Saturation Vapor Pressure formula for range 273..678 Deg. K.\r\n * This is taken from the\r\n *   Release on the IAPWS Industrial Formulation 1997\r\n *   for the Thermodynamic Properties of Water and Steam\r\n * by IAPWS (International Association for the Properties of Water and Steam),\r\n * Erlangen, Germany, September 1997.\r\n *\r\n * This is Equation (30) in Section 8.1 "The Saturation-Pressure Equation (Basic Equation)"\r\n*/\r\nvar n1 = 0.11670521452767e4, n6 = 0.14915108613530e2, n2 = -0.72421316703206e6, n7 = -0.48232657361591e4, n3 = -0.17073846940092e2, n8 = 0.40511340542057e6, n4 = 0.12020824702470e5, n9 = -0.23855557567849, n5 = -0.32325550322333e7, n10 = 0.65017534844798e3;\r\nfunction pvsWater(T) {\r\n var th = T+n9/(T-n10);\r\n  var A = (th+n1)*th+n2;\r\n  var B = (n3*th+n4)*th+n5;\r\n   var C = (n6*th+n7)*th+n8;\r\n   var p = 2*C/(-B+Math.sqrt(B*B-4*A*C));\r\n  p *= p;\r\n p *= p;\r\n return p*1e6;\r\n}\r\n\r\n// Compute Saturation Vapor Pressure for minT<T[Deg.K]<maxT.\r\nfunction PVS(T) {\r\n if (T<173 || T>678)\r\n     return NaN;\r\n else if (T<273.15) // 273.15\r\n        return pvsIce(T);\r\n   else\r\n        return pvsWater(T);\r\n}\r\n\r\n/**\r\nCompute dewPoint\r\n * @param RH : relative humidity RH[%]\r\n   * @param T: temperature T[Deg.K] en kelvin\r\n  */\r\nfunction dewPoint(RH,T) { return solve(PVS, RH/100*PVS(T), T);}\r\n\r\n// Newton''s Method to solve f(x)=y for x with an initial guess of x0.\r\nfunction solve(f,y,x0) {\r\n var x = x0;\r\n var maxCount = 10;\r\n  var count = 0;\r\n  do {\r\n        var xNew;\r\n       var dx = x/1000; \r\n       var z=f(x);\r\n     xNew = x + dx*(y-z)/(f(x+dx)-z);\r\n        if (Math.abs((xNew-x)/xNew)<0.0001) \r\n            return xNew;\r\n        else if (count>maxCount) {\r\n          xnew=NaN; \r\n          throw new Error(1, "Solver does not converge.");\r\n            break; \r\n     }\r\n       x = xNew;\r\n       count ++;\r\n   } while (true);\r\n}\r\n\r\nval = function (d){ return toHumanUnit(dewPoint ( +d.RH, +d.T)); }', '{"T":"TA:Arch:Temp:Out:Average",\r\n"RH":"TA:Arch:Hum:Out:Current"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(-1, 'TV:Arch:Temp:Hum:Solar', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TV:Arch:Temp:Hum:Solar', 'DESCRIPT', 1, 'val=function(d){\r\nreturn toHumanUnit(+d.val1 +(+d.val2) + (+d.val3) - (+d.val4));\r\n}', '{"val1":"TA:Arch:Temp:Out:Average",\r\n"val2":"TA:Arch:Various:RainFall:Sample",\r\n"val3":"TA:Arch:Various:Solar:Radiation",\r\n"val4":"TA:Arch:Various:Bar:Current"}', 'AVG', 1, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(1, 'TA:Arch:none:Time:UTC', 'strDate', 'ISO', 'ISO', 'HUMAN NAME is more than TA:Arch:none:Time:UTC', 'DESCRIPT', 1, '', '', 'AVG', 0, NULL, NULL, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(2, 'TA:Arch:Temp:Out:Average', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TA:Arch:Temp:Out:Average', 'DESCRIPT', 1, '', '', 'AVG', 1, -50, 80, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(3, 'TA:Arch:Temp:Out:High', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TA:Arch:Temp:Out:High', 'DESCRIPT', 1, '', '', 'AVG', 1, -50, 80, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(4, 'TA:Arch:Temp:Out:Low', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TA:Arch:Temp:Out:Low', 'DESCRIPT', 1, '', '', 'AVG', 1, -50, 80, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(5, 'TA:Arch:Various:RainFall:Sample', 'Rain', 'clic', 'mm', 'HUMAN NAME is more than TA:Arch:Various:RainFall:Sample', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'barChart', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(6, 'TA:Arch:Various:RainRate:HighSample', 'RainSpeed', 'clic/h', 'mm/h', 'HUMAN NAME is more than TA:Arch:Various:RainRate:HighSample', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(7, 'TA:Arch:Various:Bar:Current', 'Pressure', 'Pa', 'hPa', 'HUMAN NAME is more than TA:Arch:Various:Bar:Current', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(8, 'TA:Arch:Various:Solar:Radiation', 'Solar', 'w/m²', 'w/m²', 'HUMAN NAME is more than TA:Arch:Various:Solar:Radiation', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(9, 'TA:Arch:Temp:In:Average', 'Temperature', 'K', '°C', 'HUMAN NAME is more than TA:Arch:Temp:In:Average', 'DESCRIPT', 1, '', '', 'AVG', 1, -50, 80, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(10, 'TA:Arch:Hum:In:Current', 'Percent', '%', '%', 'HUMAN NAME is more than TA:Arch:Hum:In:Current', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 100, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(11, 'TA:Arch:Hum:Out:Current', 'Percent', '%', '%', 'HUMAN NAME is more than TA:Arch:Hum:Out:Current', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 100, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(12, 'TA:Arch:Various:Wind:SpeedAvg', 'WindSpeed', 'm/s', 'km/h', 'HUMAN NAME is more than TA:Arch:Various:Wind:SpeedAvg', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(13, 'TA:Arch:Various:Wind:HighSpeed', 'WindSpeed', 'm/s', 'km/h', 'HUMAN NAME is more than TA:Arch:Various:Wind:HighSpeed', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(14, 'TA:Arch:Various:Wind:HighSpeedDirection', 'angle', '', '°', 'HUMAN NAME is more than TA:Arch:Various:Wind:HighSpeedDirection', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(15, 'TA:Arch:Various:Wind:DominantDirection', 'angle', '', '°', 'HUMAN NAME is more than TA:Arch:Various:Wind:DominantDirection', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(16, 'TA:Arch:Various:UV:IndexAvg', 'UV', 'Idx', 'Idx', 'HUMAN NAME is more than TA:Arch:Various:UV:IndexAvg', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(17, 'TA:Arch:Various:ET:Hour', 'Evapotranspiration', 'mm', 'mm', 'HUMAN NAME is more than TA:Arch:Various:ET:Hour', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'barChart', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(18, 'TA:Arch:Various:Solar:HighRadiation', 'Solar', 'w/m²', 'w/m²', 'HUMAN NAME is more than TA:Arch:Various:Solar:HighRadiation', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(19, 'TA:Arch:Various:UV:HighIndex', 'UV', 'Idx', 'Idx', 'HUMAN NAME is more than TA:Arch:Various:UV:HighIndex', 'DESCRIPT', 1, '', '', 'AVG', 3, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S'),
(20, 'TA:Arch:Various::ForecastRule', '', '', '', 'HUMAN NAME is more than TA:Arch:Various::ForecastRule', 'DESCRIPT', 1, '', '', 'AVG', 0, 0, 65000, 'curve', 32000, 0, '2013-05-09', 'P0Y6M0DT0H0M0S');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




CREATE TABLE IF NOT EXISTS TA_VARIOUS (
    UTC TIMESTAMP NOT NULL COMMENT '',
    SEN_ID SMALLINT(6) NOT NULL COMMENT '',
    VALUE FLOAT(11) NULL DEFAULT NULL COMMENT '',

    PRIMARY KEY (UTC, SEN_ID),
    INDEX VARIOUS (SEN_ID ASC),
    CONSTRAINT SENSOR000 
        FOREIGN KEY (SEN_ID) REFERENCES TR_SENSOR (SEN_ID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Relevés de tous les autres type de capteurs';


CREATE TABLE IF NOT EXISTS TA_TEMPERATURE (
    UTC TIMESTAMP NOT NULL COMMENT '',
    SEN_ID SMALLINT(6) NOT NULL COMMENT '',
    VALUE FLOAT(11) NULL DEFAULT NULL COMMENT '',
    INDEX TEMP (SEN_ID ASC),
    PRIMARY KEY (UTC, SEN_ID),
    CONSTRAINT SENSOR 
        FOREIGN KEY (SEN_ID) REFERENCES TR_SENSOR (SEN_ID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Relevés de tous les capteurs de température';


CREATE TABLE IF NOT EXISTS TA_WETNESSES (
    UTC TIMESTAMP NOT NULL COMMENT '',
    SEN_ID SMALLINT(6) NOT NULL COMMENT '',
    VALUE TINYINT(4) NULL DEFAULT NULL COMMENT '',
    INDEX WETNESSES (SEN_ID ASC),
    PRIMARY KEY (UTC, SEN_ID),
    CONSTRAINT SENSOR0
        FOREIGN KEY (SEN_ID) REFERENCES TR_SENSOR (SEN_ID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Relevés des capteurs d''humidité du feuillage';


CREATE TABLE IF NOT EXISTS TA_MOISTURE (
    UTC TIMESTAMP NOT NULL COMMENT '',
    SEN_ID SMALLINT(6) NOT NULL COMMENT '',
    VALUE TINYINT(4) NULL DEFAULT NULL COMMENT '',
    INDEX MOISTURE (SEN_ID ASC),
    PRIMARY KEY (SEN_ID, UTC),
    CONSTRAINT SENSOR00 
        FOREIGN KEY (SEN_ID) REFERENCES TR_SENSOR (SEN_ID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Relevés des capteurs d''humidité du sol';


CREATE TABLE IF NOT EXISTS TA_HUMIDITY (
    UTC TIMESTAMP NOT NULL COMMENT '',
    SEN_ID SMALLINT(6) NOT NULL COMMENT '',
    VALUE TINYINT(4) NULL DEFAULT NULL COMMENT '',
    INDEX HUM (SEN_ID ASC),
    PRIMARY KEY (SEN_ID, UTC),
    CONSTRAINT SENSOR1
        FOREIGN KEY (SEN_ID) REFERENCES TR_SENSOR (SEN_ID)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci
COMMENT = 'Reléves des capteurs d''humidité de l''air';

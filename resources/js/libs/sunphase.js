val = function (d)
{	// https://github.com/mourner/suncalc
	// donne la position cardinale du soleil
	var sunPos = SunCalc.getPosition(dateParser(d), dataheader.ISS.lat, dataheader.ISS.lon);
	return toHumanUnit(-50*Math.cos(sunPos.azimuth)+50);
}
val = function (d)
{	// https://github.com/mourner/suncalc
	// donne la hauteur du soleil dans le ciel
	// 0 pour l'horizon (sunrise et sunset)
	var sunPos = SunCalc.getPosition(dateParser(d), dataheader.ISS.lat, dataheader.ISS.lon);
	return sunPos.altitude;
}
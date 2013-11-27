val = function (d)
{	// http://www.ben-daglish.net/moon.shtml
	// modele dequation pour une orbite parfaitement circulaire
	var moonPeriod = 29.530588853, lp = 2551443;
	var now = dateParser(d);
	var new_moon = new Date(1970, 0, 7, 20, 35, 0);
	var phase = ((now.getTime() - new_moon.getTime())/1000) % lp;
	// on retourve la position dans la periode
	return toHumanUnit(-50*Math.cos(phase /(24*3600)/moonPeriod*2*Math.PI)+50);
}
val = function (d)
{	// https://github.com/mourner/suncalc
	// donne la hauteur du soleil dans le ciel
	// 0 pour l'horizon (Moonrise et Moonset)
	var moonPos = SunCalc.getMoonPosition(dateParser(d), dataheader.ISS.lat, dataheader.ISS.lon);
	return moonPos.altitude;
}
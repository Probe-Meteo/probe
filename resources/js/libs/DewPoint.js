/*
 * Saturation Vapor Pressure formula for range -100..0 Deg. C.
 * This is taken from
 *   ITS-90 Formulations for Vapor Pressure, Frostpoint Temperature,
 *   Dewpoint Temperature, and Enhancement Factors in the Range 100 to +100 C
 * by Bob Hardy
 * as published in "The Proceedings of the Third International Symposium on Humidity & Moisture",
 * Teddington, London, England, April 1998
*/
var k0 = -5.8666426e3, k1 = 2.232870244e1, k2 = 1.39387003e-2, k3 = -3.4262402e-5, k4 = 2.7040955e-8, k5 = 6.7063522e-1;
function pvsIce(T) {
	lnP = k0/T + k1 + (k2 + (k3 + (k4*T))*T)*T + k5*Math.log(T);
	return Math.exp(lnP);
}

/**
 * Saturation Vapor Pressure formula for range 273..678 Deg. K.
 * This is taken from the
 *   Release on the IAPWS Industrial Formulation 1997
 *   for the Thermodynamic Properties of Water and Steam
 * by IAPWS (International Association for the Properties of Water and Steam),
 * Erlangen, Germany, September 1997.
 *
 * This is Equation (30) in Section 8.1 "The Saturation-Pressure Equation (Basic Equation)"
*/
var n1 = 0.11670521452767e4, n6 = 0.14915108613530e2, n2 = -0.72421316703206e6, n7 = -0.48232657361591e4, n3 = -0.17073846940092e2, n8 = 0.40511340542057e6, n4 = 0.12020824702470e5, n9 = -0.23855557567849, n5 = -0.32325550322333e7, n10 = 0.65017534844798e3;
function pvsWater(T) {
	var th = T+n9/(T-n10);
	var A = (th+n1)*th+n2;
	var B = (n3*th+n4)*th+n5;
	var C = (n6*th+n7)*th+n8;
	var p = 2*C/(-B+Math.sqrt(B*B-4*A*C));
	p *= p;
	p *= p;
	return p*1e6;
}

// Compute Saturation Vapor Pressure for minT<T[Deg.K]<maxT.
function PVS(T) {
	if (T<173 || T>678)
		return NaN;
	else if (T<273.15) // 273.15
		return pvsIce(T);
	else
		return pvsWater(T); 
}

/**
Compute dewPoint
	* @param RH : relative humidity RH[%]
	* @param T: temperature T[Deg.K] en kelvin
	*/
function dewPoint(RH,T) { return solve(PVS, RH/100*PVS(T), T);}

// Newton's Method to solve f(x)=y for x with an initial guess of x0.
function solve(f,y,x0) {
	var x = x0;
	var maxCount = 10;
	var count = 0;
	do {
		var xNew;
		var dx = x/1000; 
		var z=f(x);
		xNew = x + dx*(y-z)/(f(x+dx)-z);
		if (Math.abs((xNew-x)/xNew)<0.0001) 
			return xNew;
		else if (count>maxCount) {
			xnew=NaN; 
			throw new Error(1, "Solver does not converge.");
			break; 
		}
		x = xNew;
		count ++;
	} while (true);
}

val = function (d){ console.log('dewPoint', d);
	return toHumanUnit(dewPoint (+d.RH,+d.T)); }
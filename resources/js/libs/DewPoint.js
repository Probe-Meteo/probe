/**
 * File dew.js
 * Copyright 2011 Wolfgang Kuehn
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *       http://www.apache.org/licenses/LICENSE-2.0
 */

var KELVIN = 0;
var CELSIUS = 1;
var FAHRENHEIT = 2;

var C_OFFSET = 273.15;
var F_C = 9.0/5.0;

var RELATIVE = 1;
var ABSOLUTE = 2;

function Temperatures() {
  this.array = new Array();
}

Temperatures.prototype.add = function(t) {
  if (t.value!=null)
    this.array[this.array.length] = t;
}

var temps = new Temperatures();

Temperatures.prototype.syncronize = function() {
  for (var e in this.array) {
    var t = this.array[e];
    if (t.value!=null)
      t.onChange();
  }
}

Temperatures.prototype.setScale = function(scale) {
  for (var e in this.array)
    this.array[e].setScale(scale);
}

function Temperature(value, scale, elem) {
  this.value;
  this.scale = scale;
  this.element = elem;
  this.set(value);
  temps.add(this);
}

Temperature.prototype.onChange = function() {
  var v = stringToFloat(this.element.value);
  this.set(v);
}

Temperature.prototype.update = function() {
  if (this.element!=null)
    this.element.value = truncate(this.get(),2,ABSOLUTE);
}

Temperature.prototype.setScale = function(scale) {
  this.scale = scale;
  this.update(); 
}

Temperature.prototype.getScale = function() {
  return this.scale;
}

Temperature.prototype.getKelvin = function() {
  return this.value;
}

Temperature.prototype.setKelvin = function(value) {
  this.value = value;
  this.update();
}

Temperature.prototype.get = function() {
  var v = this.value;
  if (this.scale==CELSIUS)
    v -= C_OFFSET;
  else if (this.scale==FAHRENHEIT)
    v = 32+(v-C_OFFSET)*F_C;
  return v;
}

Temperature.prototype.set = function(value) {
  this.value = value;
  if (this.scale==CELSIUS)
    this.value += C_OFFSET;
  else if (this.scale==FAHRENHEIT)
    this.value = (this.value-32)/F_C+C_OFFSET;
  this.update();
}

Temperature.prototype.setElement = function(element) {
  this.element = element;
  this.update();
}

function TemperatureChange(value, scale, element) {
  this.scale = scale;
  this.element = element;
  this.set(value);
  temps.add(this);
}

TemperatureChange.prototype = new Temperature();

TemperatureChange.prototype.get = function() {
  var v = this.value;
  if (this.scale==FAHRENHEIT)
    v = v*F_C;
  return v;
}

TemperatureChange.prototype.set = function(value) {
  this.value = value;
  if (this.scale==FAHRENHEIT)
    this.value = this.value/F_C;
  this.update();
}


var minT = 173; // -100 Deg. C.
var maxT = 678;

/*
 * Saturation Vapor Pressure formula for range -100..0 Deg. C.
 * This is taken from
 *   ITS-90 Formulations for Vapor Pressure, Frostpoint Temperature,
 *   Dewpoint Temperature, and Enhancement Factors in the Range 100 to +100 C
 * by Bob Hardy
 * as published in "The Proceedings of the Third International Symposium on Humidity & Moisture",
 * Teddington, London, England, April 1998
*/
var k0 = -5.8666426e3;
var k1 = 2.232870244e1;
var k2 = 1.39387003e-2;
var k3 = -3.4262402e-5;
var k4 = 2.7040955e-8;
var k5 = 6.7063522e-1;

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

var n1 = 0.11670521452767e4;
var n6 = 0.14915108613530e2;
var n2 = -0.72421316703206e6;
var n7 = -0.48232657361591e4;
var n3 = -0.17073846940092e2;
var n8 = 0.40511340542057e6;
var n4 = 0.12020824702470e5;
var n9 = -0.23855557567849;
var n5 = -0.32325550322333e7;
var n10 = 0.65017534844798e3;

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

/**
 * Compute Saturation Vapor Pressure for minT<T[Deg.K]<maxT.
 */
function PVS(T) {
  if (T<minT || T>maxT) return NaN;
  else if (T<C_OFFSET)
    return pvsIce(T);
  else
    return pvsWater(T);
}

/**
 * Compute dewPoint for given relative humidity RH[%] and temperature T[Deg.K].
 */
function dewPoint(RH,T) {
  return solve(PVS, RH/100*PVS(T), T);
}

/**
 * Newton's Method to solve f(x)=y for x with an initial guess of x0.
 */
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

function truncate(x, precision, mode) {
  if (x==0)
    return 0;
  var magnitude;
  if (mode==RELATIVE)
    magnitude = Math.round(Math.log(Math.abs(x))/Math.LN10);
  else
    magnitude = 0;
  var scale = Math.pow(10,precision-magnitude);
  return Math.round(x*scale)/scale;
}

function stringToFloat(s) {
  if (s.search(/^\s*(\+|\-)?\d*(\.\d*)?\s*$/)==-1)
    throw new Error("'"+s+"' is not a valid number", "'"+s+"' is not a valid number");
  return parseFloat(s);
}

function convert () {
  var scale;
  if (document.getElementById('Celsius').checked)
    scale = CELSIUS;
  else if (document.getElementById('Fahrenheit').checked)
    scale = FAHRENHEIT;
  else
    scale = KELVIN;

  this.temps.setScale(scale);
}
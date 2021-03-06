
var myCanvas = document.getElementById("myCanvas");
var U = 10;
var KRYSSLANGD = 8;
var ALPHA = 20/180*Math.PI; //Radians
var ORIGO_X = myCanvas.width / 4; //Centering on canvas
var ORIGO_Y = myCanvas.height / 2;
var XAXIS_LENGTH = 200;
var YAXIS_LENGTH = 80;
var TICK_LENGTH = 8;

//Draws an arrow, i.e. for a coordinate system.
function drawArrow(origin_x, origin_y, end_x, end_y) {
  var beta = Math.abs( Math.atan( Math.abs(origin_y-end_y) / Math.abs(end_x-origin_x)) ); //Radians
  var alphaBigger = ALPHA > beta;

  var u_x = U * Math.cos( Math.abs(beta-ALPHA) );
  var u_y = U * Math.sin( Math.abs(beta-ALPHA) );
  var w_x = U * Math.cos(beta+ALPHA);
  var w_y = U * Math.sin(beta+ALPHA);

  ctx.beginPath();
  ctx.moveTo(origin_x,origin_y);
  ctx.lineTo(end_x,end_y);

  if (end_x >= origin_x && end_y >= origin_y) { //4:e kvadranten
    if (alphaBigger)
      ctx.moveTo(end_x-u_x,end_y+u_y);
    else
      ctx.moveTo(end_x-u_x,end_y-u_y);
    ctx.lineTo(end_x,end_y);
    ctx.moveTo(end_x-w_x,end_y-w_y);
    ctx.lineTo(end_x,end_y);
  } else if (end_x >= origin_x && end_y < origin_y) {   //1:a kvadranten
    if (alphaBigger)
      ctx.moveTo(end_x-u_x,end_y-u_y);
    else
      ctx.moveTo(end_x-u_x,end_y+u_y);
    ctx.lineTo(end_x,end_y);
    ctx.moveTo(end_x-w_x,end_y+w_y);
    ctx.lineTo(end_x,end_y);
  } else if (end_x < origin_x && end_y > origin_y) {   //3:e kvadranten
    if (alphaBigger)
      ctx.moveTo(end_x+u_x,end_y+u_y);
    else
      ctx.moveTo(end_x+u_x,end_y-u_y);
    ctx.lineTo(end_x,end_y);
    ctx.moveTo(end_x+w_x,end_y-w_y);
    ctx.lineTo(end_x,end_y);
  } else {                          //2:a kvadranten
    if (alphaBigger)
      ctx.moveTo(end_x+u_x,end_y-u_y);
    else
      ctx.moveTo(end_x+u_x,end_y+u_y);
    ctx.lineTo(end_x,end_y);
    ctx.moveTo(end_x+w_x,end_y+w_y);
    ctx.lineTo(end_x,end_y);
  }

  ctx.stroke();
}
//Makes a mark in the coordinate system. Marker type can be specified.
function drawMark(x,y,marker,scaleF) {
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  var _x = ORIGO_X+x;
  var _y = ORIGO_Y-scaleF*y;

  ctx.beginPath();

  if (marker == 'x' || marker == 'X') {
    var kvot = KRYSSLANGD/2/Math.sqrt(2);
    ctx.moveTo(_x+kvot,_y-kvot);
    ctx.lineTo(_x-kvot,_y+kvot);
    ctx.moveTo(_x-kvot,_y-kvot);
    ctx.lineTo(_x+kvot,_y+kvot);
  } else if (marker == 'o' || marker == 'O') {
    var _radius = 2
    ctx.arc(_x,_y,_radius,0,2*Math.PI);
  } else if (marker == '.') {
    var _radius = 0.5
    ctx.arc(_x,_y,_radius,0,2*Math.PI);
  } else {}


  ctx.stroke();
}


function drawXTicks(_xspace) {
  ctx.beginPath();

  var i = 1
  while((i*_xspace)<=(XAXIS_LENGTH-1.2*U)) {
    ctx.moveTo(ORIGO_X+i*_xspace,ORIGO_Y+TICK_LENGTH/2)
    ctx.lineTo(ORIGO_X+i*_xspace,ORIGO_Y-TICK_LENGTH/2)
    i++
  }

  ctx.stroke();
}


var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

//Draws coordinate system
drawArrow(ORIGO_X,ORIGO_Y,ORIGO_X+XAXIS_LENGTH,ORIGO_Y)  //x-axeln
drawArrow(ORIGO_X,ORIGO_Y+YAXIS_LENGTH,ORIGO_X,ORIGO_Y-YAXIS_LENGTH)  //y-axeln
ctx.font = 'italic 10pt Calibri';
ctx.fillText('Tid[h]', ORIGO_X+XAXIS_LENGTH+5, ORIGO_Y);
ctx.fillText('Temp[C]', ORIGO_X, ORIGO_Y-YAXIS_LENGTH-5);
drawXTicks(XAXIS_LENGTH/24)



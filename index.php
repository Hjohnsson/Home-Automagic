<!DOCTYPE html>
<html>
<head><meta http-equiv="refresh" content="2"></head>
<head><link rel="stylesheet" type="text/css" href="stylesheet.css"></head>

<h3>Temperatur logg</h3>

<body>
<?php
function temp($TABLE) {
    $con=mysqli_connect("localhost","root","hj","temp");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $TEMP = $con->query("SELECT Temperatur FROM $TABLE ORDER BY LastUpdate DESC LIMIT 10")->fetch_row()[0];

    //echo "Temperatur :";
    //echo $TEMP;

    mysqli_close($con);
    return $TEMP;
   exit;
}

//TODO-Ta in hela kolumnen från mysql som en array. Verkar vara fel med namnet 'TEMP_ARRAY' som får allt att flippa
function temp_array() {
    $con=mysqli_connect("localhost","root","hj","temp");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $q =mysql_query("SELECT Temperatur FROM temperatur");
    //$TEMP_ARRAY = array();
    //while ($row = mysql_fetch_array($q,MYSQL_ASSOC)) {
        //$TEMP_ARRAY[] = $row['Temperatur'];
    //}

    echo $TEMP_ARRAY; 
    mysqli_close($con);
    return $TEMP_ARRAY;
   exit;
}

?>
	<div class="CurrentTemp">
		<p> Nuvarande Temperatur : </p>
	</div>
	<div class="CurrentTempValue">
		<p><?php echo temp("tblCurrentTemp")?></p>
	</div>
	<div style="clear:both;"></div>

<canvas class ="Canvas" id="myCanvas" width="400" height="200" style="border:1px solid #000000;">
Your browser does not support the HTML5 canvas tag.
</canvas>

<script type="text/javascript">
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
function drawMark(x,y,marker) {
  var _x = ORIGO_X+x;
  var _y = ORIGO_Y-y;

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


var s = <?php echo temp("temperatur")?>;
drawMark(60,s,'x')

var t = <?php echo json_encode(temp_array())?>;
var temp_array = JSON.parse(t);

drawMark(80,temp_array[0],'x')

</script>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="30">
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<h3>Temperatur logg</h3>

<body>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

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

    mysql_connect("localhost","root","hj");
    mysql_select_db("temp");
    $SQLCommand = "SELECT Temperatur FROM temperatur ORDER BY LastUpdate DESC LIMIT 10";
    $TEMP_ARRAY = array();
    $q = mysql_query($SQLCommand) or die (mysql_error());

    while($row = mysql_fetch_assoc($q)) {
	$TEMP_ARRAY[] = $row['Temperatur'];
    }

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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="kalleCanvas.js" type="text/javascript"></script>
<script type="text/javascript">
var main = function() {
  //var s = <?php echo temp("tblCurrentTemp")?>;
  //$.getScript("kalleCanvas.js",function() {
    //drawMark(60,s,'x');
  //});

  var t = <?php echo json_encode(temp_array())?>;
  var arrayLength = t.length;
  var x_led = 10;
  var arrowLength = 80;
  var scaleFactor = arrowLength / Math.max.apply(null,t.map(Math.abs));
  for (i = 0;i < arrayLength-1; i= i +1) {
    var value = t[i];
    $.getScript("kalleCanvas.js",function() {
    drawMark(x_led,value,'.',scaleFactor);
    x_led = x_led + 15;
    });
  }
}
$(document).ready(main);
</script>

</body>
</html>

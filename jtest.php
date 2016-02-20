<!doctype html>
<html>
	<head>
	<meta http-equiv="refresh" content="30">	
		<title>Home-Automagic</title>
		<link href="stylesheet.css" type="text/css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="Chart.js/Chart.js"></script>
		<script src="app.js"></script>
	</head>
	<body>
		<div class="CurrentTemp">
			<p> Nuvarande Temperatur : </p>
		</div>
		<div class="CurrentTempValue">
			<p><?php echo temp("tblCurrentTemp")?></p>
		</div>
		<div style="clear:both;"></div>


	
		<canvas id="myChart" class="myChart"></canvas>

<?php
function temp($TABLE) {
    $con=mysqli_connect("localhost","root","hj","temp");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $TEMP = $con->query("SELECT Temperatur FROM $TABLE ORDER BY LastUpdate DESC LIMIT 10")->fetch_row()[0];

    mysqli_close($con);
    return $TEMP;
    exit;
}


function temp_array($COLUMN,$TABLE) {
    $con=mysqli_connect("localhost","root","hj","temp");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    mysql_connect("localhost","root","hj");
    mysql_select_db("temp");
    $SQLCommand = "SELECT $COLUMN FROM $TABLE ORDER BY LastUpdate DESC LIMIT 24";
    $TEMP_ARRAY = array();
    $q = mysql_query($SQLCommand) or die (mysql_error());

    while($row = mysql_fetch_assoc($q)) {
        $TEMP_ARRAY[] = $row[$COLUMN];
    }

    mysqli_close($con);
    return $TEMP_ARRAY;
    exit;
}


?>
<script>

function ritaGraf(){ 
	var array = <?php echo json_encode(temp_array('Temperatur','tblHTemp'))?>;
	var lastUpdateArray = <?php echo json_encode(temp_array('LastUpdate','tblHTemp'))?>;
	var labelar = []
	for (i=0;i<lastUpdateArray.length;i++) {
		var textSlice = lastUpdateArray[i];
		textSlice = textSlice.slice(11,13)
		labelar[i] = textSlice;	
	}
	var data = {
                labels: labelar.reverse(),
		//labels: lastUpdateArray,
                datasets: [
                        	{
                                	label: "My First dataset",
                                	fillColor: "rgba(220,220,220,0.2)",
                                	strokeColor: "rgba(0,0,0,1)",
                                	pointColor: "rgba(220,220,220,1)",
                                	pointStrokeColor: "#195",
                                	pointHighlightFill: "#fff",
                                	pointHighlightStroke: "rgba(220,220,220,1)",
                                	data: array.reverse()
                        	}
                	]
        	};
        	var ctx = document.getElementById("myChart").getContext("2d");
        	var myLineChart = new Chart(ctx).Line(data,{
			scaleShowGridLines: true,
			scaleShowVerticalLines: true,
			bezierCurveTension : 0.2,
			pointHitDetectionRadius:1,
		});
}
$(document).ready(ritaGraf);

</script>

	</body>
</html>

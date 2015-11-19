<!doctype html>
<html>
	<head>
		<title>Home-Automagic</title>
		<link href="stylesheet.css" type="text/css" rel="stylesheet">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="Chart.js/Chart.js"></script>
		<script src="app.js"></script>
	</head>
	<body>
		<div class="lampor">
			<div class="lampa-1">
				<p> Lampa-1 </p>
			</div>
			<div class="lampa-2">
				<p> Lampa-2 </p>
			</div>
		</div>
	
		<canvas id="myChart" class="myChart"></canvas>


<?php
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
<script>
$('#myChart').click(function(){
	ritaGraf();
});

function ritaGraf(){ 
	var array = <?php echo json_encode(temp_array())?>;
	var labelar = []
	for (i=0;i<array.length;i++) {
		labelar[i] = i+1;	
	}
	var data = {
                labels: labelar,
                datasets: [
                        	{
                                	label: "My First dataset",
                                	fillColor: "rgba(220,220,220,0.2)",
                                	strokeColor: "rgba(0,0,0,1)",
                                	pointColor: "rgba(220,220,220,1)",
                                	pointStrokeColor: "#195",
                                	pointHighlightFill: "#fff",
                                	pointHighlightStroke: "rgba(220,220,220,1)",
                                	data: array
                        	}
                	]
        	};
        	var ctx = document.getElementById("myChart").getContext("2d");
        	var myLineChart = new Chart(ctx).Line(data,{
			scaleShowGridLines: true,
			scaleShowVerticalLines: true,
			bezierCurveTension : 0,
		});
}
$(document).ready(ritaGraf);

</script>


		
	</body>
</html>

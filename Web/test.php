<!DOCTYPE html>
<html>
<head>
	<title>Home-Automagic</title>
        <meta http-equiv="refresh" content="30">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet'>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="Chart.js/Chart.js"></script>
        <script src="app.js"></script>

</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#home">
					<img src="https://www.raspberrypi.org/wp-content/uploads/2015/08/raspberry-pi-logo.png" width="27px">
					<!--<img src="http://advancedgraphics.com/wp-content/uploads/2013/08/1591_Hulk_AvengersAssemble_50.jpg" width="27px">-->
				</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="#home">Home</a></li>
				<li><a href="#">Temperatur</a></li>
				<li><a href="#">Belysning</a></li>
				<li><a href="#">Händelselista</a></li>
				<li><a href="https://github.com/Hjohnsson/Home-Automagic">Github repository</a></li>
			</ul>
		</div>
	</nav>

	<div class="rubrik">
		<h3>Temperatur</h3>
	</div>

	<div class="CurrentTemp">
                        <p> Nuvarande Temperatur : </p>
        </div>
        <div class="CurrentTempValue">
        	<p><?php echo temp("tblCurrentTemp")?></p>
        </div>
        <div style="clear:both;"></div>


	<div class="row">
        	<div class="col-sm-1">
			<div class="btn-group-vertical" role="group">
				<button type="button" class="btn btn-default btn-sm">TIMME</button>
				<button type="button" class="btn btn-default btn-sm">DYGN</button>
				<button type="button" class="btn btn-default btn-sm">MÅNAD</button>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="graf">
        	                <canvas id="myChart" class="myChart"></canvas>
			</div>
		</div>
	</div>
	
	<div class="rubrik">
		<h3>Belysning</h3>
	</div>

	<div class="row">

        	<div class="col-sm-2">
			<div class="rum1">
    	   		 	<h3>RUM 1</h3>
				<div class="btn-group-vertical" role="group">
					<button type="button" class="btn btn-success">PÅ</button>
					<button type="button" class="btn btn-danger">AV</button>
					<p>Fönster</p>
				</div>
				<div class="btn-group-vertical" role="group">
					<button type="button" class="btn btn-success">PÅ</button>
					<button type="button" class="btn btn-danger">AV</button>
					<p>Skrivbord</p>
				</div>
			</div>
        	</div>
        	<div class="col-sm-2">
       		 	<h3>RUM 2</h3>
			<div class="btn-group-vertical" role="group">
				<button type="button" class="btn btn-success">PÅ</button>
				<button type="button" class="btn btn-danger">AV</button>
			</div>
        	</div>
        	<div class="col-sm-2">
       		 	<h3>RUM 3</h3>
			<div class="btn-group-vertical" role="group">
				<button type="button" class="btn btn-success">PÅ</button>
				<button type="button" class="btn btn-danger">AV</button>
			</div>
        	</div>
        	<div class="col-sm-2">
       		 	<h3>ALLA</h3>
			<div class="btn-group-vertical" role="group">
				<button type="button" class="btn btn-success">PÅ</button>
				<button type="button" class="btn btn-danger">AV</button>
			</div>
        	</div>
	</div>

	<div class="rubrik">
		<h3>Händelselista</h3>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<div class="hlogg">
				<?php	
					$data = array_slice(file('/tmp/hlogg.txt'), -5);
					foreach ($data as $line) {
						echo $line;
						echo "<br>";
					}
				?>
			</div>
		</div>
	</div>


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


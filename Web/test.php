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
					foreach ($data as $lin) {
						echo $lin;
						echo "<br>";
					}
				?>
			</div>
		</div>
	</div>


</body>


</html>


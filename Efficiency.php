<html>
<head>
</head>
<body>
	<?php
	# Store the empId to $empId
	$empId = $_GET['empId'];
	
	# Check if the $empId is empty
	if ($empId == " " or $empId == "") {
		echo "Text field should not be empty!";
		exit;
	}
	# Set a connection to the sql and the database
	$connection = mysqli_connect('localhost', 'root', '', 'kawasaki');
	
	# Check if the connection is bad
	if(!$connection) {
		echo "Error connecting to database!".mysqli_error();
		exit;
	}
	
	# Find the values giving from the $empId
	$query = "SELECT First, Last, AVG(Efficiency) as Average FROM RUNNING, EMPLOYEE WHERE (empId1 =".$empId." OR empId2 =".$empId.") AND empId = ".$empId.";";
	$results = mysqli_query($connection, $query);
	$results_in_rows = mysqli_num_rows($results);
	
	# If the employee does not exist
	if($results_in_rows == 0) {
		echo "The employee does not exist!";
		exit;
	}
	
	# Set the results into an array
	$row = mysqli_fetch_array($results);
	
	# Show the results in a table
	echo 
	"<h1 style='color:red; margin-bottom:-25px; font-family: Impact, Charcoal, sans-serif;'>".$row['First']." ".$row['Last']."</h1>
	<h2  style='color:red; margin-bottom:-25px; font-family: Impact, Charcoal, sans-serif;'>".$empId."</h2>";

	
	# Show the results of information
	# This will be the piechart
	# I subtract the inefficiency number here because it wont let me subtract in the echo.
	$inefficiency = 100 - $row['Average'];
		echo "	<div id='piechart' style='position:absolute; top:2%; right:50%; border: 5px solid red; border-radius:10px;'></div>
			<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
			<script type='text/javascript'>
			// Load google charts
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			// Draw the chart and set the chart values
			function drawChart() {
			  var data = google.visualization.arrayToDataTable([
			  ['', ''],
			  ['Working Efficieny(%)',".$row['Average']."],
			  ['Inefficient(%)', ".$inefficiency."],
			]);

			  // Optional; add a title and set the width and height of the chart
			  var options = {'title':'Performance', 'width':200, 'height':200, 'legend':'none'};

			  // Display the chart inside the <div> element with id='piechart'
			  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
			  chart.draw(data, options);
			}
			</script>
			";

	$query = "SELECT DISTINCT(DepartmentLineNumber) FROM RUNNING WHERE empId1 =".$empId." OR empId2 = ".$empId.";";
	$results = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_array($results)) {
		echo "<br>".$row['DepartmentLineNumber']." ";
		$query = "SELECT AVG(Efficiency) as Average FROM RUNNING WHERE (empId1 =".$empId." OR empId2 =".$empId.") AND DepartmentLineNumber = '".$row['DepartmentLineNumber']."'";
		$res = mysqli_query($connection, $query);
		$r = mysqli_fetch_array($res);
		echo $r['Average'];
		echo "<progress style = 'border: none; background: crimson;' value='".$r['Average']."' max = '100'></progress>";
		echo"<br><br>";
	}	

	?>
</body>
</html>
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
	
	echo "<body style='background-color: gainsboro'></body>";
	
	# Show the results in a table
	echo 
	"<h1 style='color:red; margin-bottom:-25px; font-family: Impact, Charcoal, sans-serif;'>".$row['First']." ".$row['Last']."</h1>
	<h2  style='color:red; margin-bottom:-25px; font-family: Impact, Charcoal, sans-serif;'>".$empId."</h2>
	<br>";

	
	# Show the results of information
	# This will be the piechart
	# I subtract the inefficiency number here because it wont let me subtract in the echo.
	$inefficiency = 100 - $row['Average'];
		echo "<div id='piechart' style='position:absolute; top:2%; right:55%; border: 5px solid gray; border-radius:10px; background-color: silver;'></div>
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

	# The empId info
	echo "<div style='margin-left: 0%; background-color: silver; margin-right: 70%; margin-top: 2%; border-radius: 5px;'>";
	$query = "SELECT DISTINCT(DepartmentLineNumber) FROM RUNNING WHERE empId1 =".$empId." OR empId2 = ".$empId.";";
	$results = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_array($results)) {
		echo "<br>".$row['DepartmentLineNumber'].": ";
		$query = "SELECT AVG(Efficiency) as Average FROM RUNNING WHERE (empId1 =".$empId." OR empId2 =".$empId.") AND DepartmentLineNumber = '".$row['DepartmentLineNumber']."'";
		$res = mysqli_query($connection, $query);
		$r = mysqli_fetch_array($res);
		echo number_format($r['Average'], 2, '.', ',')." ";
		echo "<progress style = 'border: none; background: crimson;' value='".$r['Average']."' max = '100'></progress>";
		echo "<br>";
	}
	echo "</div>";
	# The whole database info for all employees
	$query = "SELECT empId FROM EMPLOYEE WHERE position='operator';";
	$results = mysqli_query($connection, $query);
	echo "<style>
			table, tr, th {
				padding: 20px; 
				border: 1px solid black;
				border-collapse: collapse;
				width: 50%;
				margin-left: 50%;
				margin-top: 0%;
				margin-right: 2%;
				border-radius: 5px;
				background-color: silver;
			
			}
			table {
				position:absolute;
				top:2%;
				right:2%;
			}
			</style>";
	echo "<table>
			<tr><th>First</th><th>Last</th><th>Employee ID</th></tr>";
	while ($row = mysqli_fetch_array($results)) {
			$query = "SELECT FIRST as F, LAST as L, AVG(EFFICIENCY) as Average
						FROM EMPLOYEE, RUNNING
						WHERE empId = ".$row['empId']." AND (empId1 = ".$row['empId']." OR empId2 = ".$row['empId'].");";
			$res = mysqli_query($connection, $query);
			$r = mysqli_fetch_array($res);
			echo "<tr> 
				<th>".$r['F']."</th><th>".$r['L']."</th><th>".number_format($r['Average'], 2, '.', ',')."%</th>
				</tr>";
			echo "<br>";
	}
	echo "</table>";
	?>
</body>
</html>
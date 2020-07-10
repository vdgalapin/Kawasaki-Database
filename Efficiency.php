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
	"<table border='1'>
		<tr>
			<td><b>First Name</b></td>
			<td><b>Last Name</b></td>
			<td><b>Employee ID Number</b></td>
			<td><b>Average</b></td>
		</tr>
		<tr>
			<td>".$row['First']."</td>
			<td>".$row['Last']."</td>
			<td>".$empId."</td>
			<td>".$row['Average']."</td>
		</tr>
	</table>";
	
	# Show the results of information
	echo "</br>Performance Percentage </br><progress style = 'border: none; width: 400px; height: 60px; background: crimson;' value='".$row['Average']."' max = '100'></progress>";
	$query = "SELECT DISTINCT(DepartmentLineNumber) FROM RUNNING WHERE empId1 =".$empId." OR empId2 = ".$empId.";";
	$results = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_array($results)) {
		echo "<br>".$row['DepartmentLineNumber'].": ";
		$query = "SELECT AVG(Efficiency) as Average FROM RUNNING WHERE (empId1 =".$empId." OR empId2 =".$empId.") AND DepartmentLineNumber = '".$row['DepartmentLineNumber']."'";
		$res = mysqli_query($connection, $query);
		$r = mysqli_fetch_array($res);
		echo $r['Average'];
		echo "<progress style = 'border: none; background: crimson;' value='".$r['Average']."' max = '100'></progress>";
	}	?>
</body>
</html>
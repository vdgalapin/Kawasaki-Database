<html>
<head>
</head>
<body>
	<?php
	$empId = $_GET['empId'];
	if ($empId == " ") {
		echo "Text field should not be empty!";
		exit;
	}
	$connection = mysqli_connect('localhost', 'root', '', 'kawasaki');
	if(!$connection) {
		echo "Error connecting to database!".mysqli_error();
		exit;
	}
	
	$query = "SELECT First, Last, AVG(Efficiency) as Average FROM RUNNING, EMPLOYEE WHERE (empId1 =".$empId." OR empId2 =".$empId.") AND empId = ".$empId.";";
	$results = mysqli_query($connection, $query);
	$results_in_rows = mysqli_num_rows($results);
	if($results_in_rows == 0) {
		echo "The employee does not exist!";
		exit;
	}
	
	$row = mysqli_fetch_array($results);
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
	}
	
	?>
</body>
</html>
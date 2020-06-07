<html>
<head>
</head>
<body>
<p><b>Kawasaki Department</b></p>
<?php
	//This is the information about the employee id number.
	$empId = $_GET['empId'];
	//This is the information about the employee first name.
	$First = $_GET['First'];
	//This is the information about the employee last name.
	$Last = $_GET['Last'];
	//This is the information about the employee shift.
	$Shift = $_GET['Shift'];
	//This is the information about the employee position.
	$Position = $_GET['Position'];
	//This is the information about the employee department.
	$DepartmentName = $_GET['DepartmentName'];
	//This is the information about the employee supervisor id number.
	$SempId = $_GET['SempId'];
	
	
	//This checks if the employee id number is empty
	if($empId == "") {
		//It will print this text and then exit
		echo "Employee should have an ID!";
		exit;
	}
	//Establish a connection between the sql and the php
	$connection = mysqli_connect('localhost', 'root', '', 'kawasaki');
	//This checks if there is no connection
	if (!$connection) {
		//It will print this text
		echo "Error connecting to database!".mysqli_error();
		exit;
	}
	//This is the command for the sql
	$query = "INSERT INTO EMPLOYEE VALUES ('".$empId."', '".$First."', '".$Last."', '".$Shift."', '".$Position."', '".$DepartmentName."', '".$SempId."')";
	//This will send it to the sql and get the results.
	if (mysqli_query($connection, $query)) {

		echo "Employee ".$First." ".$Last." inserted successfully.";
	}
	else {
		echo "ERROR: Could not be able to execute.".mysqli_error($connection);
	}
?>
</body>
</html>
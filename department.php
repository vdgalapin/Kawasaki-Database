<html>
<head>
</head>
<body>
<p><b>Kawasaki Department</b></p>
<?php
	echo "hello";
	//This is the information about the department name.
	$DepartmentName = $_GET['DepartmentName'];
	//This is the information about the department building location.
	$BuildingLocation = $_GET['BuildingLocation'];
	
	//This checks if the Department Name is empty
	if($DepartmentName = " ") {
		//It will print this text and then exit
		echo "Erro! Text field cannot be blank";
		exit;
	}
	//Establish a connection between the sql and the php
	$connection = mysqli_connect('localhost', 'root', '', 'kawasaki');
	//This checks if there is no connection
	if(!connection) {
		//It will print this text
		echo "Error connecting to database!".mysqli_error();
		exit;
	}
	//This is the command for the sql
	$query = "INSERT INTO DEPARTMENT VALUES('".$DepartmentName."' ,'".$BuildingLocation."');";
	//This will send it to the sql and get the results.

	if (mysqli_query($connection, $query) {
		echo "Department inserted successfully.";
	}
	else {
		echo "ERROR: Could not be able to execute $query. ".mysqli_error();
	}
?>
</body>
</html>
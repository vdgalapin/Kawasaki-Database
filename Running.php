<html>
<head>
</head>
<body>
<?php
	//This is the information about the first runner
	$empId1 = $_GET['empId1'];
	//This is the information about the  second runner
	$empId2 = $_GET['empId2'];
	//This is the information about the Team leader 
	$TempId = $_GET['TempId'];
	//This is the information about the Model of the part currently runned
	$Model = $_GET['Model'];
	//This is the information about the performance of the line 
	$Efficiency = $_GET['Efficiency'];
	//This is the information about the date they were running
	$RunningDate = $_GET['RunningDate'];
	//This is the information about the line they were running
	$DepartmentLineNumber = $_GET['DepartmentLineNumber'];
	
	//Check the field if its empty
	if($empId1 == " " or $TempId == " " or $Model == " " or $Efficiency == " " or $RunningDate == " " or $DepartmentLineNumber == " ") {
			echo "One of the fields is empty";
			exit;
	}
	
	//Establish a connection between the sql and the php
	$connection = mysqli_connect('localhost', 'root', '', 'kawasaki');

	//This checks if there is no connection
	if(!$connection) {
		//It will print this textdomain
		echo "Error connecting to database!".mysqli_error();
		exit;
	}
	
	//This is the command for the sql
	$query = "INSERT INTO RUNNING VALUES (".$empId1.", ".$empId2.", ".$TempId.", '".$Model."', ".$Efficiency.", '".$RunningDate."', '".$DepartmentLineNumber."');";
	
	//This will send it to the sql and get succesfully
	if(mysqli_query($connection, $query)) {
		echo "Information is succesfully!";
	}
	else {
		echo "Error: Could not be able to execute $query.".mysqli_error($connection);
	}	
?>
</body>
</html>
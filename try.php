<?php
	//parameter u gonna insert in function
	$userInfo = array("username"=>"juyan524","message"=>"Hello Everyone");

	//call function
	displayMessage($userInfo);

	//function to display message
	function displayMessage($myArray){
		echo $myArray["username"] . "<br>";
		echo $myArray["message"];
	}

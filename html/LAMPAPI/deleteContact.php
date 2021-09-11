<?php
	
	$inData = getRequestInfo();

	$userId = $inData["UserId"];
	$firstname = $inData["firstname"];
	$lastname = $inData["lastname"];
	$email = $inData["email"];

	// Create connection
	$conn = new mysqli("localhost", "contactsadmin", 
		"sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf", "pcm");

	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$stmt = $conn->prepare("SELECT FROM Contacts (UserId,NameFirst,NameLast,Email) VALUES(?,?,?,?)");
		$stmt->bind_param("isss", $userId, $firstname, $lastname, $email);
		$stmt->execute();

		$result = $stmt->get_result();

		if ($result->num_rows == 0)
		{
			returnWithError("Contact doesn't exist.");
			$stmt->close();
		}

		else
		{
			$stmt->close();

			$stmt = $conn->prepare("DELETE FROM Contacts (UserId,FirstName,Lastname,Email) VALUES(?,?,?,?)");
			$stmt->bind_param("isss", $userId, $firstname, $lastname, $email);
			$stmt->execute();
			$stmt->close();
			$conn->close();
			returnWithError("");
		}

	}

	function getRequestInfo()
	{
		// Decode JSON object into PHP object
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson($obj)
	{
		header('Content-type: applicatiojson');
		echo $obj;
	}

	function returnWithError($err)
	{
		$retValue = '{error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}


?>

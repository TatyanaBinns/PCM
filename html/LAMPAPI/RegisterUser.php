<?php

	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$firstName = $inData["firstname"];
	$lastName = $inData["lastname"];
	$email = $inData["email"];
	$password = $inData["password"];


	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}

	else
	{
		$stmt = $conn->prepare("SELECT FirstName, LastName, Email FROM Users WHERE (FirstName=? AND LastName=?) OR Email=?");
		$stmt->bind_param("sss", $firstName, $lastName, $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc() )
		{
			returnWithError("User already exists.");
			$stmt->close();
		}
		else
		{
			$stmt->close();

			$stmt = $conn->prepare("INSERT into Users (UserId, FirstName, LastName, Email, PasswordHash) VALUES(?,?,?,?,?)");
			$stmt->bind_param("issss", $userId, $firstName, $lastName, $email, password_hash($password, PASSWORD_DEFAULT));
			$stmt->execute();
			$stmt->close();
			$conn->close();
			returnWithError("");
		}
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson($obj)
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
?>

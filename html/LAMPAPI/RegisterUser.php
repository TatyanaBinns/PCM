<?php
	
	$inData = getRequestInfo();

	$firstName = $inData["firstname"];
	$lastName = $inData["lastname"];
	$email = $inData["email"];
	$userId = $inData["userid"];
	$password = $["password"];


	$conn = new mysqli("localhost", "contactsadmin", "sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf", "pcm");
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}

	else
	{
		$stmt = $conn->prepare("INSERT into Users (FirstName, LastName, Email, UserId, PasswordHash) VALUES(?,?,?,?,?)");
		$stmt->bind_param("sssss", $firstName, $lastName, $email, $userId, password_hash($password, PASSWORD_DEFAULT));
		$stmt->execute();
		$stmt->close();
		$stmt->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultsInfoAsJson($obj)
	{
		header('Content-type: application/json');
	}

	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
?>
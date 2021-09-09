<?php
	$inData = getRequestInfo();

	$firstname = $inData["firstname"];
	$lastname = $inData["lastname"];
	$email = $inData["email"];
	$phonenum = $inData["phonenumber"];
	$userId = $inData["userId"];

	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("INSERT INTO Contacts (UserId,NameFirst,NameLast,Email,PhoneNumber) VALUES(?,?,?,?,?)");
		$stmt->bind_param("ssssi", $userId, $firstname, $lastname, $email, $phonenum);
		$stmt->execute();
		$stmt->close();

		$conn->close();
		returnWithError("");
	}

	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
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

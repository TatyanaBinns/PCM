<?php
	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$contactId = $inData["contactId"];
	$firstname = $inData["firstname"];
	$lastname = $inData["lastname"];
	$email = $inData["email"];
	$phonenum = $inData["phonenumber"];

	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$stmt = $conn->prepare("UPDATE Contacts SET NameFirst=?, NameLast=?, Email=?, PhoneNumber=? WHERE UserId=? AND ContactsId=?");
		$stmt->bind_param("ssssii", $firstname, $lastname, $email, $phonenum, $userId, $contactId);
		$stmt->execute();

		if ($conn->affected_rows > 0)
		{
			returnWithError("");
		}
		else {
			returnWithError("Contact doesn't exist.");
		}
		$stmt->close();
		$conn->close();
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

	function returnWithError($err)
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}

?>

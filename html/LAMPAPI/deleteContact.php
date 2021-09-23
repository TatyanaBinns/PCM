<?php

	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$contactId = $inData["contactId"];

	// Create connection
	$conn = new mysqli("localhost", "contactsadmin",
		'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");

	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE ContactsId=?");
		$stmt->bind_param("i", $contactId);
		$stmt->execute();

		if ($conn->affected_rows > 0)
		{
			returnWithError("");
		}
		else
		{
			returnWithError("Contact wasn't deleted.");
		}
		$stmt->close();
		$conn->close();
	}

	function getRequestInfo()
	{
		// Decode JSON object into PHP object
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

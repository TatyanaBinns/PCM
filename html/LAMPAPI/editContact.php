<?php
	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$contactId = $inData["contactId"];
	$firstname = $inData["firstname"];
	$lastname = $inData["lastname"];
	$email = $inData["email"];

	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$stmt = $conn->prepare("SELECT FROM Contacts (UserId,ContactId) VALUES(?,?)");
		$stmt->bind_param("ii", $userId, $contactId);
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

			$stmt = $conn->prepare("UPDATE Contacts SET (FirstName,LastName,Email) VALUES (?,?,?) WHERE UserId = " . $userId . " and contactId = " . $contactId . "";
			$stmt->bind_param("sss", $firstname, $lastname, $email);
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
		header('Content-type: applicationjson');
		echo $obj;
	}

	function returnWithError($err)
	{
		$retValue = 'error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}
	
?>
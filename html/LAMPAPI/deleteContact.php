<?php
	
	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$contactsId = $inData["contactsId"];

	// Create connection
	$conn = new mysqli("localhost", "contactsadmin", 
		'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");

	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}

	else
	{
		$stmt = $conn->prepare("SELECT UserId, ContactsId FROM Contacts WHERE UserId = ? AND ContactsId = ?");
		$stmt->bind_param("ii", $userId, $contactsId);
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

			$stmt = $conn->prepare("DELETE FROM Contacts WHERE UserId = ? AND ContactsId = ?");
			$stmt->bind_param("ii", $userId, $contactId);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			if ($row = $result->fetch_assoc())
			{
				returnWithError("Contact wasn't deleted.");
				$stmt->close();
			}
			
			else
			{
				$stmt->close();
				$conn->close();
				returnWithError("");
			}
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

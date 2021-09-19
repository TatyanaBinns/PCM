<?php
	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$contactsId = $inData["contactsId"];
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
		$stmt = $conn->prepare("SELECT UserId, ContactsId FROM Contacts WHERE UserId = ? AND ContactsId = ?");
		$stmt->bind_param("ii", $userId, $contactsId);
		$stmt->execute();

		$result = $stmt->get_result();

		else
		{
			$stmt->close();

			$stmt = $conn->prepare("UPDATE Contacts SET (FirstName,LastName,Email) VALUES (?,?,?) WHERE UserId = " . $userId . " and contactId = " . $contactsId . "";
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
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError($err)
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>

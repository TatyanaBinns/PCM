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
		if (strlen($phonenum) != 10 OR strpos($phonenum, "(") !== false OR strpos($phonenum, ")") !== false OR strpos($phonenum, "-") !== false)
		{
			returnWithError("Phone number format is not correct");
		}
		else {
			$stmt = $conn->prepare("SELECT UserId, Email, ContactsId FROM Contacts WHERE UserId=? AND Email=?");
			$stmt->bind_param("is", $userId, $email);
			$stmt->execute();
			$result = $stmt->get_result();

			if( $row = $result->fetch_assoc() AND $row["ContactsId"] != $contactId )
			{
				returnWithError("Email already in use");
				$stmt->close();
			}
			else {
				$stmt->close();
				$stmt = $conn->prepare("UPDATE Contacts SET NameFirst=?, NameLast=?, Email=?, PhoneNumber=? WHERE UserId=? AND ContactsId=?");
				$stmt->bind_param("ssssii", $firstname, $lastname, $email, $phonenum, $userId, $contactId);
				$stmt->execute();

				returnWithError("");
				$stmt->close();
			}
			$conn->close();
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
		sendResultInfoAsJson($retValue);
	}

?>

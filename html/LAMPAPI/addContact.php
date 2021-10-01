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
		$stmt = $conn->prepare("SELECT UserId, Email FROM Contacts WHERE UserId=? AND Email=?");
		$stmt->bind_param("is", $userId, $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc() )
		{
			returnWithError("Email already in use");
			$stmt->close();
		}
		else {
			if (strlen($phonenum) != 10 OR strpos($phonenum, "(") !== false OR strpos($phonenum, ")") !== false OR strpos($phonenum, "-") !== false)
			{
				$stmt->close();
				returnWithError("Phone number format is not correct");
			}
			else
			{
				$stmt->close();
				$stmt = $conn->prepare("INSERT INTO Contacts (UserId,NameFirst,NameLast,Email,PhoneNumber) VALUES(?,?,?,?,?)");
				$stmt->bind_param("issss", $userId, $firstname, $lastname, $email, $phonenum);
				$stmt->execute();
				$stmt->close();
				returnWithError("");
			}
		}
		$conn->close();
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

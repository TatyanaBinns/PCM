<?php

	$inData = getRequestInfo();

	$userId = $inData["userId"];
	$firstName = $inData["firstname"];
	$lastName = $inData["lastname"];
	$email = $inData["email"];
	$password = $inData["password"];
	$confirmpassword = $inData["confirmpassword"];


	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}

	else
	{
		$stmt = $conn->prepare("SELECT FirstName, LastName, Email FROM Users WHERE Email=?");
		$stmt->bind_param("s", $email);
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

			if (strcmp($password, $confirmpassword) != 0)
			{
				returnWithError("Passwords do not match");
			}
			else if (strlen($password) < 8)
			{
				returnWithError("Password length is not at least 8 characters long");
			}
			else if (!preg_match('/[A-Z]/', $password))
			{
				returnWithError("Does not contain at least one upper case letter");
			}
			else if (!preg_match('/[0-9]/', $password))
			{
				returnWithError("Does not contain at least one integer");
			}
			else if (!preg_match('/\W/', $password))
			{
				returnWithError("Does not contain at least one special character");
			}
			else {
				$stmt = $conn->prepare("INSERT into Users (UserId, FirstName, LastName, Email, PasswordHash) VALUES(?,?,?,?,?)");
				$stmt->bind_param("issss", $userId, $firstName, $lastName, $email, password_hash($password, PASSWORD_DEFAULT));
				$stmt->execute();
				$stmt->close();
				$conn->close();
				returnWithError("");
			}
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

<?php

	$inData = getRequestInfo();

	//$userId = $inData["userId"];
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
			$error = 0;
			if (strcmp($password, $confirmpassword) != 0)
		  {
		    if ($error == 0)
		    {
		      $results .= '"Passwords need to match"';
		    }
		    else {
		      $results .= ", " . '"Passwords need to match"';
		    }
		    $error = 2;
		  }
		  else if (strlen($password) < 8)
		  {
		    if ($error == 0)
		    {
		      $results .= '"Password length needs to be at least 8 characters long"';
		    }
		    else {
		      $results .= ", " . '"Password length needs to be at least 8 characters long"';
		    }
		    $error = 1;
		  }
		  else if (!preg_match('/[A-Z]/', $password))
		  {
		    if ($error == 0)
		    {
		      $results .= '"Needs to contain at least one upper case letter"';
		    }
		    else {
		      $results .= ", " . '"Needs to contain at least one upper case letter"';
		    }
		    $error = 1;
		  }
		  else if (!preg_match('/[0-9]/', $password))
		  {
		    if ($error == 0)
		    {
		      $results .= '"Needs to contain at least one integer"';
		    }
		    else {
		      $results .= ", " . '"Needs to contain at least one integer"';
		    }
		    $error = 1;
		  }
		  else if (!preg_match('/\W/', $password))
		  {
		    if ($error == 0)
		    {
		      $results .= '"Needs to contain at least one special character"';
		    }
		    else {
		      $results .= ", " . '"Needs to contain at least one special character"';
		    }
		    $error = 1;
		  }
			if ($error == 0) {
				$stmt = $conn->prepare("INSERT into Users (FirstName, LastName, Email, PasswordHash) VALUES(?,?,?,?)");
				$stmt->bind_param("ssss", $firstName, $lastName, $email, password_hash($password, PASSWORD_DEFAULT));
				$stmt->execute();
				$stmt->close();
				returnWithError("");
			}
			else if ($error == 1){
				$err = "Password format is incorrect";
				returnWithError($err);
			}
			else {
				$err = "Passwords need to match";
				returnWithError($err);
			}
		}
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

	function returnWithError( $err )
	{
		$retvalue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retvalue );
	}

	function returnWithError2( $err )
	{
		$retValue = '{"error":[' . $err . ']}';
		sendResultInfoAsJson( $retValue );
	}
?>

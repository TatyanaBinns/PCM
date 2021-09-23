<?php

	$inData = getRequestInfo();

	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$stmt = $conn->prepare("SELECT ContactsId, NameFirst, NameLast, Email, PhoneNumber, DateCreated FROM Contacts WHERE UserId = ? AND NameFirst LIKE ? AND NameLast LIKE ? AND Email LIKE ? AND PhoneNumber LIKE ?");
		$firstname = "%" . $inData["firstname"] . "%";
		$lastname = "%" . $inData["lastname"] . "%";
		$email = "%" . $inData["email"] . "%";
		$phonenum = "%" . $inData["phonenumber"] . "%";
		$stmt->bind_param("issss", $inData["userId"], $firstname, $lastname, $email, $phonenum);
		$stmt->execute();

		$result = $stmt->get_result();

		while($row = $result->fetch_assoc())
		{
			if( $searchCount > 0 )
			{
				$searchResults .= ",";
			}
			$searchCount++;
			$searchResults .= '"' . $row["ContactsId"] . " : " . $row["NameFirst"] . " : " . $row["NameLast"] . " : " . $row["Email"] . " : " . $row["PhoneNumber"] . " : " . $row["DateCreated"] . '"';
		}

		if( $searchCount == 0 )
		{
			returnWithError( "No Records Found" );
		}
		else
		{
			returnWithInfo( $searchResults );
		}

		$stmt->close();
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}

?>

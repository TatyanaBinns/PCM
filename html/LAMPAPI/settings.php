<?php

  $inData = getRequestInfo();

  $userId = $inData["userId"];
  $firstname = $inData["firstname"];
  $lastname = $inData["lastname"];
  $email = $inData["email"];
  $currentpassword = $inData["currentpassword"];
  $newpassword = $inData["newpassword"];
  $confirmpassword = $inData["confirmpassword"];

$conn = new mysqli("localhost", "contactsadmin", 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf', "pcm");
if( $conn->connect_error )
{
  returnWithError( $conn->connect_error );
}
else
{
  $stmt = $conn->prepare("SELECT Email, UserId FROM Users WHERE Email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $searchCount = 0;
  while ($row = $result->fetch_assoc())
  {
    if ($row['UserId'] != $userId)
    {
      returnWithError("Email already being used in another account");
      $stmt->close();
      $conn->close();
      exit;
    }
  }

  $stmt->close();

  $stmt = $conn->prepare("SELECT PasswordHash FROM Users WHERE UserId = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc() and !password_verify($currentpassword, $row['PasswordHash']))
  {
    returnWithError("Current password is incorrect");
    $stmt->close();
    $conn->close();
    exit;
  }

  $stmt->close();

  $error = 0;
  if (strcmp($newpassword, $confirmpassword) != 0)
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
  else if (strlen($newpassword) < 8)
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
  else if (!preg_match('/[A-Z]/', $newpassword))
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
  else if (!preg_match('/[0-9]/', $newpassword))
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
  else if (!preg_match('/\W/', $newpassword))
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
    $stmt = $conn->prepare("UPDATE Users SET FirstName=?, LastName=?, Email=?, PasswordHash=? WHERE UserId=?");
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, password_hash($newpassword, PASSWORD_DEFAULT), $userId);
    $stmt->execute();
    returnWithError("");

    $stmt->close();
    $conn->close();
  }
  else if ($error == 1) {
    $err = "Password format is incorrect";
  returnWithError($err/*$results*/);
  }
  else {
    $err = "Passwords need to match";
    returnWithError($err);
  }
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
  $retvalue = '{"error":"' . $err . '"}';
  sendResultInfoAsJson( $retvalue );
}

function returnWithError2( $err )
{
  $retValue = '{"error":[' . $err . ']}';
  sendResultInfoAsJson( $retValue );
}

?>

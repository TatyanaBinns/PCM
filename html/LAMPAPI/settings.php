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

  if (strcmp($newpassword, $confirmpassword) != 0)
  {
    returnWithError("Passwords do not match");
  }
  else if (strlen($newpassword) < 8)
  {
    returnWithError("New password length is not at least 8 characters long");
  }
  else if (!preg_match('/[A-Z]/', $newpassword))
  {
    returnWithError("New password does not contain at least one upper case letter");
  }
  else if (!preg_match('/[0-9]/', $newpassword))
  {
    returnWithError("New password does not contain at least one integer");
  }
  else if (!preg_match('/\W/', $newpassword))
  {
    returnWithError("New password does not contain at least one special character");
  }
  else {
    $stmt = $conn->prepare("UPDATE Users SET FirstName=?, LastName=?, Email=?, PasswordHash=? WHERE UserId=?");
    $stmt->bind_param("ssssi", $firstname, $lastname, $email, password_hash($newpassword, PASSWORD_DEFAULT), $userId);
    $stmt->execute();
    returnWithError("");

    $stmt->close();
    $conn->close();
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
  $retValue = '{"error":"' . $err . '"}';
  sendResultInfoAsJson( $retValue );
}

?>

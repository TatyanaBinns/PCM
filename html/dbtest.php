<?php
$servername = "localhost";
$username = 'contactsadmin';
$password = 'sdf1GFDG@$g2g2GSDhgfhDehsdgh4thFGSDFshdf';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

//Example mostly courtesy of https://www.php.net/manual/en/mysqli-stmt.fetch.php

/* Prepare an insert statement */

if ($stmt = $conn->prepare("SELECT UserId, FirstName, LastName, Email FROM pcm.Users;")) {

    /* execute statement */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($id, $fname, $lname, $email);

    /* fetch values */
    while ($stmt->fetch()) {
        printf ("<p>[%s]User (%s %s) Contactable via: %s</p>\n",$id, $fname, $lname, $email);
    }

    /* close statement */
    $stmt->close();
}

?>

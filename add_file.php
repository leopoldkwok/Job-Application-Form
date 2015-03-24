<?php

$firstname = ""; // Sender Name
$lastname = ""; // Lastname
$email = ""; 

$firstnameError = "";
$lastnameError = "";
$emailError = "";
// $errors = 0;

$successMessage = "";  // On submitting form below function will execute.

// Check if a file has been uploaded


// if(isset($_FILES['uploaded_file'])) {

if(isset($_POST['submit'])) {

        if(!$_FILES['uploaded_file']['name']) {
        $fileError = "File is required";
        $errors = 1;
    }

    // Make sure the file was sent without errors
    if($_FILES['uploaded_file']['error'] == 0) {
        // Connect to the database
        $dbLink = new mysqli('localhost', 'root', '', 'forms1'); 
        // if connection fails it will throw up an error
        if(mysqli_connect_errno()) {
            die("MySQL connection failed: ". mysqli_connect_error());
        }
 
        // Gather all required data
        $firstname = $_POST['firstname']; // Sender firstname
        $lastname = $_POST['lastname']; // Sender Lastname
		$email = $_POST['email']; //Sender email address
		$phone_number = $_POST['phone_number'];
		$message = $_POST['message'];
        $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
        $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
        $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
        $size = intval($_FILES['uploaded_file']['size']);
 
        // Create the SQL query
        $query = "
            INSERT INTO `file` (
                `firstname`, `lastname`, `email`, `phone_number`, `message`, `name`, `mime`, `size`, `data`, `created`
            )
            VALUES (
                '{$firstname}', '{$lastname}', '{$email}', '{$phone_number}','{$message}', '{$name}', '{$mime}', {$size}, '{$data}',  NOW()

            )";
 
        // Execute the query
        $result = $dbLink->query($query);
 
        // Check if it was successfull
        if($result) {
            echo 'Success! Your details was successfully added! Thank you for sending your details.';
        }

        else {
            echo 'Error! Failed to insert the file'. "<pre>{$dbLink->error}</pre>";
        }
    }

    // else {
    //     echo 'An error accured while the file was being uploaded. '
    //        . 'Error code: '. intval($_FILES['uploaded_file']['error']);
    // }
 
    // Close the mysql connection
    // $dbLink->close();
}
else {
    echo 'Error! A file was not sent!';
}
 
// Echo a link back to the main page
echo '<p>Click <a href="index.php">here</a> to go back</p>';
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <title>MySQL file upload example</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet'>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">

    <p>Firstname:<br> <input type="text" name="firstname" value = ""/></p>


    <p>Last Name:<br><input type="text" name="lastname" /></p>
    <p>Email:<br><input type="text" name="email" /></p>
    <p>Phone Number: <br> <input type="text" name="phone_number" /></p>
    Message: <br><textarea name="message" rows="5" cols="40"></textarea><br><br>

<!--  <p>Message: <input type="text" name="message" /></p>  -->


        Resume: <input type="file" name="uploaded_file"><br><br>
         <!--    <div class="error"><?php echo $fileError;?></div> -->
        <input class="submit" type="submit" name="submit" value="Submit">
        
    </form>
    <p>

       <!--  <a href="list_files.php">See all files</a> -->
    </p>
</body>
</html>
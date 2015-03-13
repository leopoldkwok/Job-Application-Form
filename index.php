<!DOCTYPE html>
<html>
<head>
    <title>PHP Job Application Form</title>
</head>
<body>

<?php

    $firstname = ""; // Sender Name
    $lastname = ""; // Lastname
    $email = ""; 
    $phone_number = '';
    $message = '';

    $firstnameError = "";
    $lastnameError = "";
    $emailError = "";
    $phone_numberError="";
    $fileError ="";
    $errors = 0;

    $successMessage = "";  // On submitting form below function will execute.

    //validation

    //we first confirm whether the form has been submitted by checking if submit has been set. 
    //isset function in php checks if a variable is set and is not null.

    if(isset($_POST['submit'])) {

        if(!$_FILES['uploaded_file']['name']) {
            $fileError = "File is required";
            $errors = 1;
        }

        if(!isset($_POST['firstname']) || $_POST['firstname'] === '') {
            $errors = 1;
            $firstnameError = "First Name is required";

        } elseif (!preg_match("/^[a-zA-Z]*$/",$_POST['firstname'])) {
            $errors = 1;
            $firstnameError = "Only letters and white space not allowed";
        
        } else {
            $firstname = $_POST['firstname'];
        }

        if(!isset($_POST['lastname']) || $_POST['lastname'] === '') {
            $errors = 1;
            $lastnameError="Last name is required";

        } elseif (!preg_match("/^[a-zA-Z]*$/",$_POST['lastname'])) {
            $errors = 1;
            $lastnameError = "Only letters and white space not allowed";

        } else {
            $lastname = $_POST['lastname'];
        }

        if(!isset($_POST['email']) || $_POST['email'] === '') {
            $errors = 1;
            $emailError = "Email is required";

        }   elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors = 1;
            $emailError = "Email is not valid";

        }   else {
            $email = $_POST['email'];
        }


        if(!isset($_POST['phone_number']) || $_POST['phone_number'] === '') {
            $errors = 1;
            $phone_numberError = "Phone number is required";

        }   else {
            $phone_number = $_POST['phone_number'];
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
                echo '<p>Click <a href="index_hack.php">here</a> to go enter more details</p>';
            }

            else {
        echo 'Error! A file was not sent!';
    }
      

            // else {
            //     echo 'Error! Failed to insert the file'. "<pre>{$dbLink->error}</pre>";
            // }
        }

        // else {
        //     echo 'An error accured while the file was being uploaded. '
        //        . 'Error code: '. intval($_FILES['uploaded_file']['error']);
        // }
     
        // Close the mysql connection
        // $dbLink->close();
    }

    // Echo a link back to the main page

    ?>





<!DOCTYPE html>
<head>
    <title>MySQL file upload example</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">

    First Name:<br><input type="text" name="firstname" value="<?php
        echo htmlspecialchars($firstname); // prefilled the form fields
    ?>"><br>
    <div class="error"><?php echo $firstnameError;?></div><br>

    Last Name:<br><input type="text" name="lastname" value="<?php
        echo htmlspecialchars($lastname); // prefilled the form fields
    ?>"><br>
    <div class="error"><?php echo $lastnameError;?></div><br>

    Email:<br><input type="text" name="email" value="<?php
        echo htmlspecialchars($email); // prefilled the form fields
    ?>"><br>
    <div class="error"><?php echo $emailError;?></div><br>

    Phone Number:<br><input type="text" name="phone_number" value="<?php
        echo htmlspecialchars($phone_number); // prefilled the form fields
    ?>"><br>
    <div class="error"><?php echo $phone_numberError;?></div><br>

    Message: <br><textarea name="message" val="" rows="5" cols="40" "<?php
        echo htmlspecialchars($message); // prefilled the form fields
    ?>"></textarea><br><br>


    Resume: <input type="file" name="uploaded_file"><br>
        <div class="error"><?php echo $fileError;?></div>
        <br><input class="submit" type="submit" name="submit" value="Submit">
        
    </form>
    <p>

       <!--  <a href="list_files.php">See all files</a> -->
    </p>
</body>
</html>
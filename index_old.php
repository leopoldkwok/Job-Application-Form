<!DOCTYPE html>
<head>
    <title>MySQL file upload example</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
    <form action="add_file.php" method="post" enctype="multipart/form-data">

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
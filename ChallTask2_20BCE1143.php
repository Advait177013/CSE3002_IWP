<head>
    <title>CT2 - 20BCE1143</title>
    <link rel="stylesheet" type="text/css" href="projectstyles.css"> 
</head>

<body>
    <?php
    {
        //Advait Deochakke
        //20BCE1143

        // $sql = "CREATE DATABASE ct2";
        // if ($conn->query($sql) === TRUE) 
        // {
        //   echo "<br>Database created successfully";
        // } 
        // else 
        // {
        //   echo "<br>Error creating database: " . $conn->error;
        // }

        // $sql = "CREATE TABLE StuDetails (
        //     stu_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        //     stuname VARCHAR(30) NOT NULL,
        //     coursename VARCHAR(50) not null,
        //     cgpa float(6) unsigned not null,
        //     stuyear int(6) unsigned not null,
        //     hobby varchar(30) not null
        //     )";
        // if ($conn->query($sql) === TRUE) 
        // {
        //     echo "<br>Table studetails created successfully";
        // } 
        // else 
        // {
        //     echo "<br>Error creating table: " . $conn->error;
        // }
    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    //Note: implementing without sessions and password hashing, as should be done ideally. 
    $servername = "localhost";
    $username = "advait_localhost";
    $password = "password";
    $dbname = "ct2";

    $generic_error = "";
    $result_msg = "";
    $searchres = "";
    $afterdelete = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("<br>Connection failed: " . $conn->connect_error);
    }
    $tabledisplaysql = "select stu_id, stuname, coursename, cgpa, stuyear, hobby from studetails";
    //display_table($conn, $sql);
    echo "<br>";

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['Enter_Data'])) {
            $stuname_enter = test_input($_POST["stuname_enter"]);
            $stucourse_enter = test_input($_POST["stucourse_enter"]);
            $stucgpa_enter = test_input($_POST["stucgpa_enter"]);
            $stuyear_enter = test_input($_POST["stuyear_enter"]);
            $stuhobby_enter = test_input($_POST["stuhobby_enter"]);
            $valid = verify_input(0, $stuname_enter, $stucourse_enter, $stucgpa_enter, $stuyear_enter, $stuhobby_enter);
            $sql = "insert into studetails (stuname, coursename, cgpa, stuyear, hobby) values 
            ('$stuname_enter', '$stucourse_enter', '$stucgpa_enter', '$stuyear_enter', '$stuhobby_enter')";
            if($valid == 1)
            {
                if(mysqli_query($conn, $sql))
                {
                    $result_msg = "Successful Entry of $stuname_enter data";
                }
                else
                {
                    $generic_error = $generic_error."Error Entering Data.";
                }
            }
            else
            {
                $generic_error = $generic_error."Invalid Attr Entry";
            }
            
        }
        else if(isset($_POST['Search_Data'])) {
            $stuid_search = ">=0";
            $stuname_search = "[a-zA-Z]+";
            $stucourse_search = "[a-zA-Z]+";
            $stucgpa_search = ">=0";
            $stuyear_search = ">=0";
            $stuhobby_search = "[a-zA-Z]+";

            {//inputs
                if (!empty($_POST["stuid_search"]))
                {
                    $stuid_search = test_input($_POST["stuid_search"]);
                }
                if (!empty($_POST["stuname_search"])) 
                {
                    $stuname_search = test_input($_POST["stuname_search"]);
                }
                if (!empty($_POST["stucourse_search"])) 
                {
                    $stucourse_search = test_input($_POST["stucourse_search"]);
                }
                if (!empty($_POST["stucgpa_search"])) 
                {
                    $stucgpa_search = test_input($_POST["stucgpa_search"]);
                }
                if (!empty($_POST["stuyear_search"])) 
                {
                    $stuyear_search = test_input($_POST["stuyear_search"]);
                }
                if (!empty($_POST["stuhobby_search"])) 
                {
                    $stuhobby_search = test_input($_POST["stuhobby_search"]);
                }
            }
            $sql = "select stu_id, stuname, coursename, cgpa, stuyear, hobby from studetails where 
            stu_id$stuid_search and cgpa$stucgpa_search and stuyear$stuyear_search 
            and stuname regexp '$stuname_search' and coursename regexp '$stucourse_search' and hobby regexp '$stuhobby_search'";                
            $searchres = display_table($conn, $sql);
        }
        else if(isset($_POST['Delete_Data'])) {
        
            $stuid_delete = ">=0";
            $stuname_delete = "[a-zA-Z]+";
            $stucourse_delete = "[a-zA-Z]+";
            $stucgpa_delete = ">=0";
            $stuyear_delete = ">=0";
            $stuhobby_delete = "[a-zA-Z]+";

            {//inputs
                if (!empty($_POST["stuid_delete"]))
                {
                    $stuid_delete = test_input($_POST["stuid_delete"]);
                }
                if (!empty($_POST["stuname_delete"])) 
                {
                    $stuname_delete = test_input($_POST["stuname_delete"]);
                }
                if (!empty($_POST["stucourse_delete"])) 
                {
                    $stucourse_delete = test_input($_POST["stucourse_delete"]);
                }
                if (!empty($_POST["stucgpa_delete"])) 
                {
                    $stucgpa_delete = test_input($_POST["stucgpa_delete"]);
                }
                if (!empty($_POST["stuyear_delete"])) 
                {
                    $stuyear_delete = test_input($_POST["stuyear_delete"]);
                }
                if (!empty($_POST["stuhobby_delete"])) 
                {
                    $stuhobby_delete = test_input($_POST["stuhobby_delete"]);
                }
            }
            $sql = "delete from studetails 
            where stu_id$stuid_delete and cgpa$stucgpa_delete and stuyear$stuyear_delete 
            and stuname regexp '$stuname_delete' and coursename regexp '$stucourse_delete' and hobby regexp '$stuhobby_delete'";                
            if(!mysqli_query($conn, $sql))
            {
                $generic_error=$generic_error."Unable to Delete";
            }
            $afterdelete = display_table($conn, $tabledisplaysql);
        }
        else if(isset($_POST['Send_Email']))
        {
            $custemail = test_input($_POST["custemail"]);

            $mail = new PHPMailer(true);
            try 
            {									
                $mail->isSMTP();											
                $mail->Host	 = 'smtp.gmail.com;';					
                $mail->SMTPAuth = true;							
                $mail->Username = 'advaitdeochakke@gmail.com';				
                $mail->Password = 'btdkwzhvcktacfao'; //appspecific password generation for automation						
                $mail->SMTPSecure = 'tls';							
                $mail->Port	 = 587;
                $mail->SMTPDebug = false;

                $mail->setFrom('advaitdeochakke@gmail.com', 'Advait');		
                $mail->addAddress($custemail);
                
                $mail->isHTML(true);								
                $mail->Subject = 'Chall Task 2 : Send Help';
                $mail->Body = display_table($conn, $tabledisplaysql);
                $mail->send();
            } 
            catch (Exception $e) 
            {
                $generic_error = $generic_error."<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }
        else if(isset($_POST['Upload']))
        {
            //uploading to some directory
            //file_uploads is On
            $target_file_path = "tmp/".basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) 
            {
                echo "Sorry, your file was not uploaded.";
            } 
            else 
            {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_path)) 
                {
                    echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
                } 
                else 
                {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }
        else if(isset($_POST['Upload_Email']))
        {
            //uploading to some directory
            //file_uploads is On
            $target_file_path = "tmp/".basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) 
            {
                echo "Sorry, your file was not uploaded.";
            } 
            else 
            {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_path)) 
                {
                    $custemail = test_input($_POST["custemail"]);
            if(mysqli_query($conn, $sql))
            {
                $mail = new PHPMailer(true);
                try 
                {									
                    $mail->isSMTP();											
                    $mail->Host	 = 'smtp.gmail.com;';					
                    $mail->SMTPAuth = true;							
                    $mail->Username = 'advaitdeochakke@gmail.com';				
                    $mail->Password = 'btdkwzhvcktacfao'; //appspecific password generation for automation						
                    $mail->SMTPSecure = 'tls';							
                    $mail->Port	 = 587;
                    $mail->SMTPDebug = false;

                    $mail->setFrom('advaitdeochakke@gmail.com', 'Advait');		
                    $mail->addAddress($custemail);
                    
                    $mail->isHTML(true);								
                    $mail->Subject = 'Chall Task 2 : Send Help';
                    $mail->Body = display_table($conn, $tabledisplaysql);
                    $mail->send();
                } 
                catch (Exception $e) 
                {
                    $generic_error = $generic_error."<br>Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } 
            else 
            {
                echo "Error: <br>".mysqli_error($conn);
            }
                } 
                else 
                {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

        }     
    }   

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function display_table($conn, $sql) {
        $tablebuilder = "<table><tr><th>StuID</th><th>StuName</th><th>CourseName</th><th>CGPA</th><th>StuYear</th><th>Hobby</th></tr>";
        $result = mysqli_query($conn, $sql);
        if($result -> num_rows > 0)
        {
            while($row = $result->fetch_assoc())
                {
                    $tablebuilder = $tablebuilder."<tr><td>".$row["stu_id"]."</td><td>".$row["stuname"]."</td><td>".$row["coursename"]."</td><td>".$row["cgpa"]."</td><td>".$row["stuyear"]."</td><td>".$row["hobby"]."</td></tr>";
                }
        }
        else
        {
            echo "test<br>";
        }
        
        $tablebuilder = $tablebuilder."</table><br>";
        return $tablebuilder;
    }
    function verify_input($stuid, $stuname, $stucourse, $stucgpa, $stuyear, $stuhobby) {
        $valid_stuid = "/^[0-9]+/";
        $valid_cgpa = "/^([0-9]{1, 2}(\.?[0-9]?[0-9]?)?)/";
        $valid_else = "/^[a-zA-Z]+/";
        $valid_stuyear = "/^[1-4]{1}/";
            if(!preg_match($valid_stuid, $stuid) || !preg_match($valid_cgpa, $stucgpa) || !preg_match($valid_else, $stuname)|| !preg_match($valid_else, $stucourse)|| !preg_match($valid_stuyear, $stuyear) || !preg_match($valid_else, $stuhobby))
            {
                return 1;
            }
            else
            {
                // $echo (preg_match($valid_stuid, $stuid));
                // $echo (preg_match($valid_cgpa, $stucgpa));
                // $echo (preg_match($valid_else, $stuname));
                // $echo (preg_match($valid_else, $stucourse));
                // $echo (preg_match($valid_stuyear, $stuyear));
                // $echo (preg_match($valid_else, $stuhobby));
                return 0;
            }
                
    }
    ?>
    <h2> Chall Task 2 </h2><br>
    <h3> 20BCE1143 </h3><br>
    <h1>Status of query : <?php echo $result_msg?></h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <br><h2>Enter Data</h2>
        stu_name : <input type="text" name="stuname_enter">
        <br><br>
        stu_course : <input type="text" name="stucourse_enter">
        <br><br>
        stu_cgpa : <input type="text" name="stucgpa_enter">
        <br><br>
        stu_year : <input type="text" name="stuyear_enter">
        <br><br>
        stu_hobby : <input type="text" name="stuhobby_enter">
        <br><br>
        <input type="submit" name="Enter_Data" value="Enter Data">  <br><br><br>

        <h2>Search Data</h2>
        <br><p>Data you dont want to specify, leave blank</p><br>
        stu_id  : <input type="test" name="stuid_search">
        <br><br>
        stu_name : <input type="text" name="stuname_search">
        <br><br>
        stu_course : <input type="text" name="stucourse_search">
        <br><br>
        stu_cgpa : <input type="text" name="stucgpa_search">
        <br><br>
        stu_year : <input type="text" name="stuyear_search">
        <br><br>
        stu_hobby : <input type="text" name="stuhobby_search">
        <br><br>
        <input type="submit" name="Search_Data" value="Search Data"> 
        
        <br>
        <?php echo $searchres ?>

        <br><br><br>

        <h2>Delete Data</h2>
        <br><p>Data where you want to delete everything, leave blank</p><br>
        stu_id  : <input type="test" name="stuid_delete">
        <br><br>
        stu_name : <input type="text" name="stuname_delete">
        <br><br>
        stu_course : <input type="text" name="stucourse_delete">
        <br><br>
        stu_cgpa : <input type="text" name="stucgpa_delete">
        <br><br>
        stu_year : <input type="text" name="stuyear_delete">
        <br><br>
        stu_hobby : <input type="text" name="stuhobby_delete">
        <br><br>
        <input type="submit" name="Delete_Data" value="Delete Data"> 
        
        <br>
        <?php echo $afterdelete ?>

        <br><br><br>

        Send an Email to this Addr => <input type="email" name="custemail">
        <br><br>
        <input type="submit" name="Send_Email" value="Send Full Student Details"> 

        <br><br><br>

        Upload Student Marks File => <input type="file" name="fileToUpload" id="fileToUpload">
        <br><br>
        <input type="submit" name="Upload" value="Upload Student Details File to Server">
        <input type="submit" name="Upload_Email" value="Upload Student Details File to Server and Email to above mail">
        
        <br><br><br>
    </form>

    <?php

        $conn->close();
    ?>
    <span class="error"><?php echo $generic_error?></span>
    <br>
</body>
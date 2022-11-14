<html>
    <head>
        <title>20BCE1143 - Ex 7</title>
        <style>
            .error
            {
                color:red;
            }
        </style>
    </head>
    <body>
        <?php
            $marksErr = "";
            $marks = 0;
            $validation = 1;
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST["marks"])) 
                {
                    $marksErr = "Required to Enter Marks";
                }
                else
                {
                    $marks = test_input($_POST["marks"]);
                    $valid_marks = "/^[0-9]{1,2}$/";
                    $perfect_marks = "/100/";
                    if(preg_match($perfect_marks, $marks))
                    {
                        $marksErr = "Congrats on Perfect marks!";
                    }
                    else if(!preg_match($valid_marks, $marks))
                    {
                        $marksErr = "Enter Valid Marks";
                        $validation = 0;
                    }
                        
                }
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
              }
        ?>
        <h2>Enter Your Marks Below</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Marks: <input type="text" name="marks" value="<?php echo $marks;?>">
            <span class="error">* <?php echo $marksErr;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">  
        </form>

        <?php
            echo "<h2>You are eligible for the selected</h2><br>";
            if($validation==0)
              echo "Invlaid Marks<br>";
            else if($marks>=90)
              echo "Computer Science and Engineering<br>";
            else if($marks>=80)
              echo "Mechanical Enigeering<br>";
            else if($marks>=70)
              echo "Civil Engineering<br>";
            else
              echo "Other Types of Engineering<br>";
        ?>
    </body>
</html>
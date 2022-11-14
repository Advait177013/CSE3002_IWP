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
        $validation = 1;
        $numberErr = "";
        $number = 0;
        $save = 0;
        $sum = 0;
        if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST["number"])) 
                {
                    $numberErr = "Required to Enter Marks";
                    $save = $number;
                }
                else
                {
                    $number = test_input($_POST["number"]);
                    $valid_number = "/^\d{4}$/";
                    if(!preg_match($valid_number, $number))
                    {
                        $numberErr = "Enter Valid 4-digit Number";
                        $validation = 0;
                    }
                    if($validation == 1)
                    {
                        $save = $number;
                        $i=0;
                        do
                        {
                            $sum = $sum + $number%10;
                            $number = ($number-$number%10)/10;
                            $i++;
                        }
                        while($i<4);
                        if(($save%$sum)==0)
                        {
                            $validation = 2;
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
        ?>

        <h2>Enter Your Number Below</h2><br>
        We will tell whether it is divisble by the sum of its digit<br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!-- we can also use HTML Pattern attribute for form -->
            Number: <input type="text" name="number" value="<?php echo $save;?>" title="Four digit number">
            <span class="error">* <?php echo $numberErr;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">  
        </form>

        <?php
            echo "<h2>Your Number is : </h2><br>";
            if($validation==0)
                echo "Invlaid Number<br>";
            else if($validation==1)
                echo "Indivisible<br>";
            else 
                echo "Divisible<br>";
        ?>
    </body>
</html>



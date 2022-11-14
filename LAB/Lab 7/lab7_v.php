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
        $og = 0;
        if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if (empty($_POST["number"])) 
                {
                    $numberErr = "Required to Enter Marks";
                    $og = $number;
                }
                else
                {
                    $number = test_input($_POST["number"]);
                    $valid_number = "/^\d*$/";
                    if(!preg_match($valid_number, $number))
                    {
                        $numberErr = "Enter Valid Number";
                        $validation = 0;
                        $og=$number;
                    }
                    if($validation == 1)
                    {
                        $og=$number;
                        $cur_size=1;
                        do
                        {
                            $whether_zero = $number%10;
                            $addendum=0;
                            if($whether_zero!=0)
                            {
                                $tenpow =  pow(10,$cur_size);
                                $addendum = ($number%10)*$tenpow;   
                                $save = $save + $addendum;
                                $number = ($number-$number%10)/10;
                                $cur_size++;
                            }
                            else
                            {
                                $number = ($number-$number%10)/10;
                            }
                        }
                        while($number!=0);
                        $save=$save/10;  
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
            Number: <input type="text" name="number" value="<?php echo $og;?>" title="Any digit number">
            <span class="error">* <?php echo $numberErr;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit">  
        </form>

        <?php
            echo "<h2>Your Number with 0s removed is : </h2><br>";
            if($validation==0)
                echo "Invlaid Number<br>";
            else if($validation==1)
                echo "$save<br>";
            else 
                echo "$save<br>";
        ?>
    </body>
</html>



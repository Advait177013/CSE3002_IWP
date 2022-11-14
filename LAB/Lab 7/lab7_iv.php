<html>
    <head>
        <title>20BCE1143 - Ex 7</title>
    </head>
    <body>
        <?php
            $myArr = array(1);
            $i=0;
            do
            {
                $myArr[$i+1]=$myArr[$i]+$i+1+1;
                echo "number is ".$myArr[$i]."<br>";
                $i++;
            }
            while($i<15);
        ?>
    </body>
</html>



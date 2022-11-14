<html>
    <head>
        <title>20BCE1143 - Ex 7</title>
    </head>
    <body>
        <?php
        echo "For loan of ₹10,000 <br>For interest of 10%p/m <br>Yearly payment is - ";
        $principal = 10000;
        $interest = 0.1;
        $amount = 0 + $principal;
        for($i = 0; $i < 12; $i++)
        {
            $amount = $amount + $interest * $principal;
        }
        echo "₹$amount<br>";
        ?>
    </body>
</html>



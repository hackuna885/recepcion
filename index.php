<?php
$numEmp = (isset($_GET['numEmp'])) ? $_GET['numEmp'] : '';

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HACKUNA</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
    </style>
</head>
<body>
    <div>
        <?php echo '<img src="generadorQR.php?id='.$numEmp.'"/>';?>
    </div>
</body>
</html>
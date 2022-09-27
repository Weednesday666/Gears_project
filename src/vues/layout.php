<!--layout principale , il est afficher sur chaque page du site-->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="https://seeklogo.com/images/X/Xbox_360_Gears_Of_War-logo-CC2C2C77F4-seeklogo.com.png" />
    <link rel="stylesheet" type="text/css" href="https://thomascavelier.sites.3wa.io/GEARS_FINAL/public/CSS/style.css">
    <title>Gears mini painting guide</title>
</head>
<body>

    <?php

    // header
    require 'src/vues/navbar.php';

    // main
    if (isset($layout)) {
        require $layout.'.php';
    }

    // footer
    require 'src/vues/footer.php';

    ?>


</body>
</html>

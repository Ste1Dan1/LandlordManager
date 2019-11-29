<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <link href="./CSS/topbar.css" rel="stylesheet" type="text/css">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">
        <title>Datenschutz</title>
    </head>
    <body>

        <?php
        include 'topbar.inc.php';
        include 'loginCheck.inc.php';
        ?>
        <div class="pagecontent">
            <h1>Datenschutz</h1>
            <?php
            include 'loremIpsum.php'
            ?>  

        </div>


    </body>
    <?php
    include 'footer.inc.php';
    ?>
</html>
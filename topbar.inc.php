<!DOCTYPE html>
<!-- source: https://www.w3schools.com/howto/howto_css_dropdown_navbar.asp -->

<html>
    <head>
        <meta name="Topbar Styling" content="width=device-width, initial-scale=1">
        <link href="./CSS/footer.css" rel="stylesheet" type="text/css">

    </head>
    <body>

        <?php
        session_start();
        include 'loginCheck.inc.php';
        include 'db.inc.php';
        ?>

        <div class="home">
            <a href="index.php"><img src="Images/Logo_Landlord_Manager.png" /></a>
        </div>


        <div class="navbar">

<!--            <a href="index.php"><img src="Images/Logo_Landlord_Manager.png" /></a>-->

            <div class="dropdown">
                <button class="dropbtn">Mieter 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="mieter.php">Mieter verwalten</a>
                    <a href="mietvertrag.php">Mietverträge verwalten</a>
                    <a href="mietzahlung.php">Mietzahlungen verwalten</a>

                </div>
            </div>


            <div class="dropdown">
                <button class="dropbtn">Immobilien 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="haus.php">Häuser verwalten</a>
                    <a href="wohnung.php">Wohnungen verwalten</a>

                </div>
            </div>


            <div class="dropdown">
                <button class="dropbtn">Nebenkosten 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="kostenkategorien.php">Kostenkategorien verwalten</a>
                    <a href="lieferanten.php">Lieferanten verwalten</a>
                    <a href="nkrechnungen.php">Nebenkostenrechnungen verwalten</a>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropbtn">Reports 
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="mieterspiegel.php">Mieterspiegel</a>

                </div>
            </div>

            <a href="user_ausgabe.php">User</a>
            <a href="logout.php">Logout</a>

        </div>

  
        <div class="navLogin">
            <?php
            echo "User: " . $_SESSION["name"];
            ?>
        </div>



    </body>
</html>

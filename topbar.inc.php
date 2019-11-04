<!DOCTYPE html>
<!-- source: https://www.w3schools.com/howto/howto_css_dropdown_navbar.asp -->

<html>
<head>
<meta name="Topbar Styling" content="width=device-width, initial-scale=1">
<link href="./CSS/topbar.css" rel="stylesheet" type="text/css">

</head>
<body>

    <?php
    session_start();
    include 'loginCheck.inc.php';
    include 'db.inc.php';
    ?>
    
    
<div class="navbar">
  <a href="index.php">Startseite</a>

  
  <div class="dropdown">
    <button class="dropbtn">Mieter 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
                    <a href="mieter.php">Mieter verwalten</a>
                    <a href="mietvertrag.php">Mietverträge verwalten</a>
      <a href="mietzahlung_ausgabe.php">Erfasste Mietzahlungen darstellen</a>
      <a href="mietzahlung_erfassen.php">Neue Mietzahlung erfassen</a>

    </div>
  </div>
  

  <div class="dropdown">
    <button class="dropbtn">Immobilien 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
                    <a href="haus.php">Häuser verwalten</a>
                    <a href="wohnung_ausgabe.php">Wohnungen verwalten</a>

    </div>
  </div>
  
  
  <div class="dropdown">
    <button class="dropbtn">Nebenkosten 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
        <a href="perioden_ausgabe.php">Erfasste Zahlungsperioden darstellen</a>
                    <a href="kostenkategorien.php">Kostenkategorien verwalten</a>
        <a href="lieferanten_ausgabe.php">Erfasste Lieferanten darstellen</a>
        <a href="lieferanten_erfassen.php">Neuen Lieferanten erfassen</a>
                    <a href="nkrechnungen.php">Nebenkostenrechnungen verwalten</a>
    </div>
  </div>
  
    <a href="user_ausgabe.php">User</a>
    <a href="logout.php">Logout</a>

</div>

</body>
</html>

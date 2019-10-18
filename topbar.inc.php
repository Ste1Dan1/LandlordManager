<!DOCTYPE html>
<!-- source: https://www.w3schools.com/howto/howto_css_dropdown_navbar.asp -->

<html>
<head>
<meta name="Topbar Styling" content="width=device-width, initial-scale=1">
<link href="./CSS/topbar.css" rel="stylesheet" type="text/css">

</head>
<body>

<div class="navbar">
  <a href="index.php">Startseite</a>

  
  <div class="dropdown">
    <button class="dropbtn">Mieter 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="mieter_ausgabe.php">Erfasste Mieter anzeigen</a>
      <a href="mieter_erfassen.php">Neuen Mieter erfassen</a>
    </div>
  </div> 
  
  <div class="dropdown">
    <button class="dropbtn">Miete
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="mietvertrag_ausgabe.php">Erfasste Mietverträge darstellen</a>
      <a href="mietvertrag_erfassen.php">Neuen Mietvertrag erfassen</a>
      <a href="mietzahlung_ausgabe.php">Erfasste Mietzahlungen darstellen</a>
      <a href="mietzahlung_erfassen.php">Neue Mietzahlung erfassen</a>
    </div>
  </div>
  
  <div class="dropdown">
    <button class="dropbtn">Immobilien 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="wohnung_ausgabe.php">Erfasste Wohnungen anzeigen</a>
        <a href="wohnung_erfassen.php">Neue Wohnung erfassen</a>
        <a href="haus_ausgabe.php">Erfasste Häuser darstellen</a>
        <a href="haus_erfassen.php">Neues Haus erfassen</a>
    </div>
  </div>
  
  
  <div class="dropdown">
    <button class="dropbtn">Nebenkosten 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
        <a href="perioden_ausgabe.php">Erfasste Zahlungsperioden darstellen</a>
        <a href="kostenkategorien_ausgabe.php">Erfasste Kostenkategorien darstellen</a>
        <a href="lieferanten_ausgabe.php">Erfasste Lieferanten darstellen</a>
        <a href="lieferanten_erfassen.php">Neuen Lieferanten erfassen</a>
        <a href="nkrechnungen_ausgabe.php">Erfasste Nebenkostenrechnungen darstellen</a>
        <a href="nkrechnungen_erfassen.php">Neue Nebenkostenrechnung erfassen</a>
    </div>
  </div>
  
    <a href="user_ausgabe.php">User</a>
    <a href="logout.php">Logout</a>

</div>

</body>
</html>

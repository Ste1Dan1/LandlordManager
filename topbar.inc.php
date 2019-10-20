
<link href="./CSS/topbar.css" rel="stylesheet" type="text/css">


    <?php
    session_start();
    include 'loginCheck.inc.php';
    include 'db.inc.php';
    ?>
    
    
<div class="navbar">
  <a href="index.php">Startseite</a>

  
  <div class="dropdown">
    <button class="dropbtn">Miete 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="mieter.php">Mieter Verwalten</a>
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
        <a href="wohnung.php">Wohnungen Verwalten</a>
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
        <a href="lieferanten.php">Lieferanten Verwalten</a>
        <a href="nkrechnungen_ausgabe.php">Erfasste Nebenkostenrechnungen darstellen</a>
        <a href="nkrechnungen_erfassen.php">Neue Nebenkostenrechnung erfassen</a>
    </div>
  </div>
  
    <a href="user_ausgabe.php">User</a>
    <a href="logout.php">Logout</a>
    
    <div class="navbar-right">
        <a href=""><img src="Images/Logo_Landlord_Manager.png" height="40px"></a>
    </div>
    
</div>


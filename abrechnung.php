<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title>LandlordManager - Jahresabrechnung</title>
    </head>

    <body>
        <?php
        include 'db.inc.php';
        include 'topbar.inc.php';
        ?>
        
        <h1>Ihre erfassten Nebenkosten-Rechnungen pro Haus </h1>
        <form name ="jahrauswahl" method="post" action="abrechnung.php">
            <select name="jahr">
                <option value="Alle">Alle anzeigen</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
            <button class="btn" type="submit" name="show" >Anzeigen</button>          

        </form>
 
        <?php 
            
            $abfrage_haus = "SELECT * FROM haus ORDER BY bezeichnung";
            $res_haus = mysqli_query($link, $abfrage_haus) or die("Abfrage Haus hat nicht geklappt");
            
            while ($table = mysqli_fetch_array($res_haus)) {
                $summe = 0;
                $anzahl = 0;
                $anzwhg = $table['anz_whg'];
                $bewmonate = $anzwhg * 12;
                $anteil;
                ?>
            <h2>Nebenkosten für Haus <?php echo $table['bezeichnung'] ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Datum NK-Rechnung</th>
                        <th>Lieferant</th>
                        <th>Betrag</th>
                        <th>Kostenkategorie</th>
                    </tr>
                </thead>

                <?php
              
                $hausname = $table['bezeichnung'];
                if (isset($_POST['show'])){
                if ($_POST['jahr'] == "Alle"){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2019){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2019-01-01' AND '2019-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2020){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2020-01-01' AND '2020-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2021){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2021-01-01' AND '2021-12-31' ORDER BY datum;";
                }
                if ($_POST['jahr'] == 2022){
                $abfrage_NK = "SELECT * from nkrechnungenprohaus WHERE bezeichnung = '$hausname' AND datum BETWEEN '2022-01-01' AND '2022-12-31' ORDER BY datum;";
                }
            }
                $res = mysqli_query($link, $abfrage_NK) or die("Abfrage NK-Rechnungen hat nicht geklappt");
                
                while ($row = mysqli_fetch_array($res)) { 
                    $summe += $row['Betrag'];
                    $anzahl +=1;
                    $datumalt = strtotime($row['Datum']);
                    $datum = date("d.m.Y", $datumalt);
                    ?>
                    <tr>
                        <td><?php echo $datum; ?></td>
                        <td><?php echo $row['Lieferant']; ?></td>
                        <td><?php echo $row['Betrag']; ?></td>
                        <td><?php echo $row['Beschreibung']; ?></td>
                    </tr>
                    <?php }
                
                if ($anzahl >=1){
                    $anteil = round(($summe / $bewmonate), 2);
                ?>
                    <tr>
                        <td><strong><?php echo 'TOTAL'; ?></strong></td>
                        <td><?php echo ''; ?></td>
                        <td><strong><?php echo $summe; ?></strong></td>
                        <td><?php echo ''; ?></td>
                    </tr>
                    <tr><td></td><td></td><td></td><td></td></tr>
                    <tr>
                        <td><strong><?php echo 'Anz. Wohnungen'; ?></strong></td>
                        <td><?php echo $anzwhg; ?></td>
                        <td><strong><?php echo 'Anteil' ?></strong></td>
                        <td><?php echo $anteil; ?></td>
                    </tr>
            <?php } ?>
            </table>
            <?php  }
            
            ?>

        

</body>
</html>


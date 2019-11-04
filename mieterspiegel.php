<html>
    <head>
        <meta charset="UTF-8">
        <link href="./CSS/style.css" rel="stylesheet" type="text/css">
        <title></title>
    </head>

    <body>
        <?php
        include('topbar.inc.php');

        $abfrage = "SELECT `mieter`.*, `mietvertrag`.*, `wohnung`.*, `haus`.*
FROM `mietvertrag` 
	LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
	LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
	LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID`
        WHERE cast(mietende as date) >=  cast(CURDATE() as date) 
        OR mietende IS NULL" ;

        $res = mysqli_query($link, $abfrage) or die("Abfrage hat nicht geklappt". mysqli_error($link));
        ?>

        
        
        <table>
           
            <thead>
                  
                <tr>
                    <th>Anrede</th>
                    <th>Vorname</th>
                    <th>Name</th>
                    <th>Strasse / Nr.</th>
                    <th>PLZ / Ort</th>
                    <th>Wohnung</th>
                    <th>Mietbeginn</th>
                    <th>Mietende</th>
                    <th>Mietzins / Monat</th>
                    <th>Nebenkosten / Monat</th>
                    <th><a href="mieterspiegelExport.php" class="exp_btn" style="float: right">Exportieren</a></th>
                    
                    
                </tr>
            </thead>

            <?php while ($row = mysqli_fetch_array($res)) { ?>
                <tr>
                    <td><?php echo $row['anrede']; ?></td>
                    <td><?php echo $row['vorname']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['strasse_nr']; ?></td>
                    <td><?php echo $row['plz'] . " " . $row['ort']; ?></td>
                    <td><?php echo $row['bezeichnung'] . " " . $row['wohnungsNummer']; ?></td>
                    <td><?php echo $row['mietbeginn']; ?></td>
                    <td><?php echo $row['mietende']; ?></td>
                    <td><?php echo $row['mietzins_mtl']; ?></td>
                    <td><?php echo $row['nebenkosten_mtl']; ?></td>

                </tr>
            <?php }
            ?>
        </table>






    </body>
</html>

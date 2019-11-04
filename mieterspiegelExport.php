<?php
//include database configuration file
include 'db.inc.php';

//get records from database
$query = $link->query("SELECT `mieter`.*, `mietvertrag`.*, `wohnung`.*, `haus`.*
FROM `mietvertrag` 
	LEFT JOIN `mieter` ON `mietvertrag`.`FK_mieterID` = `mieter`.`mieterID` 
	LEFT JOIN `wohnung` ON `mietvertrag`.`FK_wohnungID` = `wohnung`.`wohnungID` 
	LEFT JOIN `haus` ON `wohnung`.`FK_hausID` = `haus`.`hausID`
        WHERE cast(mietende as date) >=  cast(CURDATE() as date) 
        OR mietende IS NULL");

if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "mieterspiegel_" . date('Y-m-d') . ".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    $fields = array("Anrede", "Vorname", "Name", "Strasse Nr", "PLZ", "Ort", "Gebäude", "Wohnungs-Nr.", "Mietbeginn", "Mietende", "Mietzins", "Nebenkosten");
    fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $lineData = array($row['anrede'],$row['vorname'], $row['name'], $row['strasse_nr'], $row['plz'], $row['ort'], $row['bezeichnung'], $row['wohnungsNummer'], $row['mietbeginn'], $row['mietende'], $row['mietzins_mtl'],$row['nebenkosten_mtl']);
        fputcsv($f, $lineData, $delimiter);
    }
    
     
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;

?>
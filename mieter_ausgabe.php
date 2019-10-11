<!DOCTYPE html>
<!--
Mieterseite mit Tabellenübersicht der Mieter
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $anzahl_spalten = mysqli_num_fields($res);
        echo "\n";
        for ($i=0; $i<$anzahl_spalten; $i++)
        { $finfo = mysqli_fetch_field_direct($res, $i);
        echo "".$finfo->name."\n"; } echo "\n";
        
        while($zeile= mysqli_fetch_assoc($res))
        { echo ""; while(list($key,$value)=each($zeile))
        { echo "".$value.""; } 
        
        echo "";
        
        }
        
        echo "";
        
        mysqli_close($link); ?> Weitere Adressen erfassen! 
        
        
        
        ?>
    </body>
</html>

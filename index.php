<?php

// INIZIALIZZAZIONE VARIABILI
$a = "";
$b = "";
$operazione = "";
$opzioni = array(); 

$erroreA = "";
$erroreB = "";
$erroreOperazione = "";

$esito = "";

$risultato = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    // RECUPERO DATI
    $a = (isset($_POST["a"]) ? trim($_POST["a"]) : "");
    $b = (isset($_POST["b"]) ? trim($_POST["b"]) : "");
    $operazione = (isset($_POST["operazione"]) ? $_POST["operazione"] : "");
    $opzioni = (isset($_POST["opzioni"]) ? $_POST["opzioni"] : array());


    // CONTROLLO DATI
    // Controllo a
    if($a == "") $erroreA = "a non inserita";
    elseif(!is_numeric($a)) $erroreA = "a non numerica";

    // Controllo b
    if($b == "") $erroreB = "b non inserita";
    elseif(!is_numeric($b)) $erroreB = "b non numerica";
    elseif($operazione == "quoziente" && $b == 0) $erroreB = "b deve essere diversa da 0";      // Controlla che b sia diversa da zero soltanto quando bisogna effettuare una divisione

    // Controllo operazione
    if($operazione == "") $erroreOperazione = "operazione non selezionata";


    // CONTROLLO COMPLESSIVO
    if($erroreA == "" && $erroreB == "" && $erroreOperazione == ""){

        $esito = "OK";


        // CALCOLI
        // Operazione
        if($operazione == "somma") $risultato = $a + $b;
        elseif($operazione == "differenza") $risultato = $a - $b;
        elseif($operazione == "prodotto") $risultato = $a * $b;
        elseif($operazione == "quoziente") $risultato = $a / $b;

        // Opzione
        if(in_array("valore_assoluto", $opzioni)) $risultato = abs($risultato);
        if(in_array("quadrato", $opzioni)) $risultato = pow($risultato, 2);
        if(in_array("arrotondamento", $opzioni)) $risultato = round($risultato, 2);

    }
    else $esito = "KO";



    // MESSAGGI DI ERRORE (da mettere nel CSV)
    $errori = $erroreA . " - " . $erroreB . " - " . $erroreOperazione;

    // FILE CSV
    $file = fopen("log.csv", "a");


    // SCRITTURA INTESTAZIONI
    if(filesize("log.csv") == 0){
        fputcsv($file, array("Data", "a", "b", "Operazione", "Opzioni", "Risultato", "Esito", "Errori"));
    }


    // Conversione array in stringa (Per inserirlo in una singola colonna del CSV)
    $opzioniCSV = implode(", ", $opzioni);

    // SCRITTURA DATI
    fputcsv($file, array(date("d/m/Y H:i:s"), $a, $b, $operazione, $opzioniCSV, $risultato, $esito, $errori));


    fclose($file);


}

?>











<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Calcolatore matematico</title>
    <link rel="stylesheet" href="stile.css">
</head>

<body>

    <h1>Calcolatore matematico</h1>

    <form method="post" action="index.php">

        <label for="a">a:</label>
        <input type="text" id="a" name="a" value="<?php echo htmlspecialchars($a); ?>">
        <?php if($erroreA != "") echo "<p class='errore'>" . $erroreA . "</p>"; ?>


        <br>


        <label for="b">b:</label>
        <input type="text" id="b" name="b" value="<?php echo htmlspecialchars($b); ?>">
        <?php if($erroreB != "") echo "<p class='errore'>" . $erroreB . "</p>"; ?>


        <fieldset>

            <legend>Operazione</legend>

            <input type="radio" name="operazione" value="somma" id="somma">
            <label for="somma">Somma</label>

            <input type="radio" name="operazione" value="differenza" id="differenza">
            <label for="differenza">Differenza</label>

            <input type="radio" name="operazione" value="prodotto" id="prodotto">
            <label for="prodotto">Prodotto</label>

            <input type="radio" name="operazione" value="quoziente" id="quoziente">
            <label for="quoziente">Quoziente</label>

            <?php if($erroreOperazione != "") echo "<p class='errore'>" . $erroreOperazione . "</p>";?>

        </fieldset>


        <fieldset>

            <legend>Opzioni</legend>

            <input type="checkbox" name="opzioni[]" value="valore_assoluto" id="valore_assoluto"
            <?php if(in_array("valore_assoluto", $opzioni)) echo "checked"; ?>>
            <label for="valore_assoluto">Valore assoluto</label>


            <input type="checkbox" name="opzioni[]" value="quadrato" id="quadrato"
            <?php if(in_array("quadrato", $opzioni)) echo "checked"; ?>>
            <label for="quadrato">Quadrato</label>
            

            <input type="checkbox" name="opzioni[]" value="arrotondamento" id="arrotondamento"
            <?php if(in_array("arrotondamento", $opzioni)) echo "checked"; ?>>
            <label for="arrotondamento">Arrotondamento</label>


        </fieldset>


        <button type="submit">Calcola</button>

    </form>



    <!-- RISULTATO -->
    <?php

    if($esito == "OK"){ ?>

        <div class="risultato">
        <h2>RISULTATO</h2>

        <p>a: <?php echo htmlspecialchars($a); ?></p>
        <p>b: <?php echo htmlspecialchars($b); ?></p>
        <p>Operazione scelta: <?php echo htmlspecialchars($operazione); ?></p>
        <p>Risultato finale: <?php echo number_format((float)$risultato, 2, ",", "."); ?></p>

        </div>
    
    
    
    <?php
    }
    ?>






    <!-- STORICO -->
    <?php

    // SCRITTURA INTESTAZIONI
    echo 
    "<table border='1'>
        <tr>
            <th>a</th>
            <th>b</th>
            <th>Operazione</th>
            <th>Risultato</th>
            <th>Esito</th>
        </tr>";


    

    

    if(file_exists("log.csv")){

        $file = fopen("log.csv", "r");


        // LETTURA DATI
        $riga = "";

        $riga = fgetcsv($file);     // Legge la prima riga del file (Intestazioni)

        while(($riga = fgetcsv($file)) != false){
            
            echo 
            "<tr>
                <td>" . htmlspecialchars($riga[1]) . "</td>
                <td>" . htmlspecialchars($riga[2]) . "</td>
                <td>" . htmlspecialchars($riga[3]) . "</td>
                <td>" . number_format((float)$riga[5], 2, ",", ".") . "</td>
                <td>" . htmlspecialchars($riga[6]) . "</td>
            </tr>";
        }


        fclose($file);
    }
    
    echo "</table>";  // LA CHIUSURA (della tabella) deve avvenire DOPO IL CICLO e DOPO L'IF
    


    ?>


</body>
</html>

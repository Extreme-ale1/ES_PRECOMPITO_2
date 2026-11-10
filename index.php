<?php
    if(isset($_GET["optioons"])){
        print_r($_GET["options"]);
        // Se l'array options è definito posso scorrerlo:
        // con un for oppure 
        // con un foreach
        // foreach($array as $element)
        //      ... qui $element è l'elemento i-esimo d

        foreach ($_GET["options"] as $element){
            echo $element;

            // In questo caso particolare

            //
            if(in_array("absolute", $_GET["options"])){
                // Allora calcolo il valore assoluto
            }

            // Qui controllo se l'utente a selezionato ANCHE square SENZA else if ma solo con if()
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <h1>CALCOLATRICE</h1>

        <br>

        <label for="a">a:</label>
        <input type="number" id="a" name="a" step="any" required>

        <br>

        <label for="b">b:</label>
        <input type="number" id="b" name="b" step="any" required>

        <br><br>

        <div>
            <fieldset>
                <legend>Operazione</legend>

                <input type="radio" id="op" name="op" value="somma">
                <label for="somma">somma</label>

                <br>

                <input type="radio" id="op" name="op" value="differenza">
                <label for="somma">differenza</label>

                <br>

                <input type="radio" id="op" name="op" value="prodotto">
                <label for="somma">prodotto</label>

                <br>

                <input type="radio" id="op" name="op" value="quoziente">
                <label for="somma">quoziente</label>
            </fieldset>

        </div>


        <div>
            <fieldset>
                <legend>Opzioni</legend>

                <input type="checkbox" id="abs" name="options[]" value="assoluto">
                <label for="abs">valore assoluto</label>

                <br>

                <input type="checkbox" id="abs" name="options[]" value="quadrato">
                <label for="abs">quadrato</label>

                <br>

                <input type="checkbox" id="abs" name="options[]" value="2decimali">
                <label for="abs">arrotonda a 2 decimali</label>
            </fieldset>

            <br>

            <input type="submit" value="Calcola">




        </div>
    </form>
    
</body>
</html>
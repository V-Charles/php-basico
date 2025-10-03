<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Temperatura</title>
</head>
<body>
    <?php 
        $cel = $_POST['cel'] ?? 0;
    ?>
    <main>
        <h1>Conversor de Temperatura</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="cel">Qual a temperatura em Celsius no momento?</label>
            <input type="number" name="cel" id="idcel" required step="0.01">
            <p></p>
            <input type="submit" value="Converter">
        </form>
    </main>
    <?php 
        $fah = ($cel * 9/5) + 32;

        if ($cel >= 100) {
            $msg = "Está muito quente!";
        } else if ($cel <= 0) {
            $msg = "Está muito frio!";
        } else {
            $msg = "Está ok... eu acho";
        }
    ?>
    <section>
        <h2>Temperatura Convertida</h2>
        <ul>
            <li>Temperatura em Celsius: <?=$cel?></li>
            <li>Temperatura em Fahrenheit: <?=$fah?></li>
            <li><?=$msg?></li>
        </ul>
    </section>
</body>
</html>
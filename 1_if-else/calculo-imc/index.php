<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculo de IMC</title>
</head>
<body>
    <?php 
        $peso = $_POST['peso'] ?? 0;
        $altura = $_POST['altura'] ?? 1;
    ?>
    <main>
        <h1>Calculo de IMC</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="peso">Qual o seu peso atual?</label>
            <input type="number" name="peso" id="idpeso" step="0.01" required>
            <p></p>
            <label for="altura">Qual a sua altura atual?</label>
            <input type="number" name="altura" id="idaltura" step="0.01" required>
            <p></p>
            <input type="submit" value="Calcular">
        </form>
        <hr>
    </main>
    <?php 
        $imc = $peso / ($altura * $altura);

        if ($imc < 18.5) {
            $msg = "Abaixo do peso";
        } else if ($imc >= 18.5 && $imc < 25) {
            $msg = "Peso normal";
        } else if ($imc >= 25 && $imc < 30) {
            $msg = "Sobrepeso";
        } else {
            $msg = "Gordão!";
        }
    ?>
    <section>
        <h2>Calculo do seu IMC</h2>
        <ul>
            <li>IMC: <?=number_format($imc, 2, ",", ".")?></li>
            <li><?=$msg?></li>
        </ul>
    </section>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador de Idades para Categorias</title>
</head>
<body>
    <?php 
        $idade = $_POST['idade'] ?? 0;
    ?>
    <main>
        <h1>Verificador de Idade</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="idade">Informe sua idade</label>
            <input type="number" name="idade" id="ididade" required>
            <p></p>
            <input type="submit" value="Verificar">
        </form>
    </main>
    <?php 
        if ($idade < 13) {
            $msg = "Criança";
        } else if ($idade >= 13 && $idade <=17) {
            $msg = "Adolescente";
        } else if ($idade >= 18 && $idade <= 59) {
            $msg = "Adulto";
        } else if ($idade >= 60) {
            $msg = "Idoso";
        } else {
            $msg = "Idade Inválida!";
        }
    ?>
    <section>
        <p><?=$msg?></p>
    </section>
</body>
</html>
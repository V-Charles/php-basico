<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador de Doação</title>
</head>
<body>
    <?php 
        $idade = $_POST['idade'] ?? 18;
        $peso = $_POST['peso'] ?? 0;
    ?>
    <main>
        <h1>Informe os seguintes dados para realizar a verificação</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="idade">Idade da pessoa:</label>
            <input type="number" name="idade" id="ididade">
            <p></p>

            <label for="peso">Peso da pessoa:</label>
            <input type="number" name="peso" id="idpeso">
            <p></p>

            <input type="submit" value="Verificar">
        </form>
    </main>
    <?php 
        if ($idade >= 16 && $idade <= 69) {
            if ($peso >= 50) {
                $msg = "O doador atente aos requisitos";
            } else {
                $msg = "O peso do doador não é compatível";
            }
        } else {
            $msg = "Idade do doador não é compatível";
        }
    ?>
    <section>
        <p><?=$msg?></p>
    </section>
</body>
</html>
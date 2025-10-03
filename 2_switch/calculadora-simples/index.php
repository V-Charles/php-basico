<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade com Switch</title>
</head>
<body>
    <?php 
        $valor1 = $_POST['v1'] ?? 0;
        $valor2 = $_POST['v2'] ?? 0;
        $operacao = $_POST['operacao'] ?? '';
        $erro = '';
        $resul = null;

        if ($operacao === '') {
            $erro = "Erro: é necessário informar uma operação!";
        } else if ($operacao == 4 && $valor2 == 0) {
            $erro = "Erro: não é possível dividir por 0 (zero)";
        } else {
            switch ($operacao) {
                case 1:
                    $resul = $valor1 + $valor2;
                    break;
                case 2:
                    $resul = $valor1 - $valor2;
                    break;
                case 3:
                    $resul = $valor1 * $valor2;
                    break;
                case 4:
                    $resul = $valor1 / $valor2;
                    break;
                default:
                    $erro = "Erro: operação inválida!";
            }
        }
    ?>
    <main>
        <h1>Calculadora de Operações Simples</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="v1">Informe o primeiro valor:</label>
            <input type="number" name="v1" id="idv1" required>
            <p></p>
            <label for="v2">Informe o segundo valor:</label>
            <input type="number" name="v2" id="idv2" required>
            <p></p>
            <label for="operacao">Escolha uma operação:</label>
            <select name="operacao" id="idoperacao">
                <option value="">--SELECIONE--</option>
                <option value="1">Adição</option>
                <option value="2">Subtração</option>
                <option value="3">Multiplicação</option>
                <option value="4">Divisão</option>
            </select>
            <p></p>
            <input type="submit" value="Calcular">
        </form>
    </main>
    <hr>
    <section>
        <?php
            if ($erro !== '') {
                echo "<p>$erro</p>";
            } else if ($resul !== null) {
                echo "<p>Resultado: ". number_format($resul, 2, ",", ".") ."</p>";
            }
        ?>
    </section>
</body>
</html>
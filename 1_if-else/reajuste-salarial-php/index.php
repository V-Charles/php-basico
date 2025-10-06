<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reajuste salarial</title>
</head>
<body>
    <?php 
        $nomeFuncionario = $_POST['nome'] ?? '';
        $salarioFuncionario = $_POST['salario'] ?? 0;
        $tempoDeEmpresa = $_POST['tempo'] ?? 0;
        $notaDesempenho = $_POST['desempenho'] ?? 0;

        $percentualAumento = 0;
        $bonusPercentualValor = 0;
        $bonusFixoValor = 0;
        $novoSalario = 0;
        $erro = '';

        if ($nomeFuncionario === '') {
            $erro = "Erro: O campo nome não pode estar vazio!";
        } else if ($salarioFuncionario <= 0) {
            $erro = "Erro: O salário deve ser um valor válido!";
        } else if ($tempoDeEmpresa <= 0) {
            $erro = "Erro: O tempo de empresa deve ser maior que 0.";
        } else if ($notaDesempenho <= 0 || $notaDesempenho > 5) {
            $erro = "Erro: A nota de desempenho deve ser de 1 a 5.";
        }

        if ($erro === '') {
            if ($tempoDeEmpresa <= 1) {
                $percentualAumento = 0;
            } else if ($tempoDeEmpresa >=2 && $tempoDeEmpresa <= 3) {
                $percentualAumento = 0.05;
            } else if ($tempoDeEmpresa >= 4 && $tempoDeEmpresa <= 6) {
                $percentualAumento = 0.10;
            } else if ($tempoDeEmpresa >= 7 && $tempoDeEmpresa < 10) {
                $percentualAumento = 0.15;
            } else if ($tempoDeEmpresa >= 10 && $notaDesempenho == 5) {
                // Caso especial: funcionário com mais de 10 anos e desempenho máximo
                $percentualAumento = 0.15;
                $bonusFixoValor = 2000;
            }

            $valorAumento = $salarioFuncionario * $percentualAumento;
            $novoSalario = $salarioFuncionario + $valorAumento;

            if ($notaDesempenho == 5) {
                if ($notaDesempenho == 5) {
                    $bonusPercentualValor = $novoSalario * 0.10;
                } else if ($notaDesempenho == 4) {
                    $bonusPercentualValor = $novoSalario * 0.05;
                }
            }

            $novoSalario += $bonusPercentualValor + $bonusFixoValor;

        }
    ?>
    <main>
        <h1>Preencha os seguintes dados</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="nome">Nome do funcionário:</label>
            <input type="text" name="nome" id="idnome" required>
            <p></p>
            <label for="salario">Salário atual: R$</label>
            <input type="number" name="salario" id="idsalario" min="0.01" step="0.01" placeholder="0,00" required>
            <p></p>
            <label for="tempo">Tempo de empresa: </label>
            <input type="text" name="tempo" id="idtempo" min="1" placeholder="Em anos" required>
            <p></p>
            <label for="desempenho">Desempenho do funcionário (1 a 5)</label>
            <select name="desempenho" id="iddesempenho">
                <option value="">-- Selecione --</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <p></p>
            <input type="submit" value="Calcular Salário">
        </form>
        <hr>
    </main>
    <section>
        <?php
            if ($erro === '') {
                echo "<h2>Dados Retornados</h2>";
                echo "<ul>";
                echo "<li>Nome do funcionário: $nomeFuncionario</li>";
                echo "<li>Salário original: R$ ". number_format($salarioFuncionario, 2, ",", ".") ."</li>";
                echo "<li>Tempo de empresa: $tempoDeEmpresa anos</li>";
                echo "<li>Desempenho: $notaDesempenho</li>";
                echo "<li>Aumento aplicado: " . ($percentualAumento * 100) ."% (R$ " . number_format($valorAumento, 2, ",", ".") . ")</li>";
                echo "<li>Bônus percentual: R$ " . number_format($bonusPercentualValor, 2, ",", ".") . "</li>";
                echo "<li>Bônus fixo: R$ " . number_format($bonusFixoValor, 2, ",", ".") . "</li>";
                echo "<li>Salário final reajustado: <strong>R$ " . number_format($novoSalario, 2, ",", ".") . "</strong></li>";
                echo "</ul>";
            } else {
                echo "<p><strong>$erro</strong></p>";
            }
        ?>
    </section>
</body>
</html>
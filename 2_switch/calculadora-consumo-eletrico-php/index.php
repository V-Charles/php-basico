<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Consumo Elétrico Residencial</title>
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            $nome = $_POST['nome'] ?? '';
            $tipoInstalacao = $_POST['tipoinstalacao'] ?? '';
            $consumo = $_POST['consumo'] ?? 0;

            $tarifaAplicada = 0;
            $valorBruto = 0;
            $valorImposto = 0;
            $valorTotalConta = 0;
            $erro = '';

            if ($nome === '') {
                $erro = "Erro: O campo nome deve ser preenchido!";
            } elseif ($tipoInstalacao === '') {
                $erro = "Erro: O tipo de instalação deve ser informada!";
            } elseif ($consumo <= 0) {
                $erro = "Erro: A quantidade de consumo informada é inválida. Tente novamente!";
            }

            if ($erro === '') {
                switch ($tipoInstalacao) {
                    case 'Residencial':
                        if ($consumo <= 100) {
                            $tarifaAplicada = 0.50;
                        } else {
                            $tarifaAplicada = 0.65;
                        }
                        break;
                    case 'Comercial':
                        if ($consumo <= 250) {
                            $tarifaAplicada = 0.55;
                        } else {
                            $tarifaAplicada = 0.60;
                        }
                        break;
                    case 'Industrial':
                        if ($consumo <= 500) {
                            $tarifaAplicada = 0.60;
                        } else {
                            $tarifaAplicada = 0.75;
                        }
                        break;
                    default:
                        $erro = "Erro: O tipo de instalação selecionado é inválido. Tente novamente!";
                        break;
                }

                if ($erro === '') {
                    $valorBruto = $consumo * $tarifaAplicada;
                    if ($consumo <= 100) {
                        $valorImposto = $valorBruto * 0.05;
                    } elseif ($consumo <= 500) {
                        $valorImposto = $valorBruto * 0.10;
                    } else {
                        $valorImposto = $valorBruto * 0.15;
                    }
                } else {
                    $erro = "Erro: Não foi possível efetuar o calculo. Tente novamente!";
                }

                if ($erro === '') {
                    $valorTotalConta = $valorBruto + $valorImposto;
                }
            }
        }
    ?>
    <main>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="nome">Nome do cliente:</label>
            <input type="text" name="nome" id="id-nome" required>
            <p></p>
            <label for="tipoinstalacao">Qual o tipo de instalação:</label>
            <select name="tipoinstalacao" id="id-tipoinstalacao" required>
                <option value="">-- SELECIONE --</option>
                <option value="Residencial">Residencial</option>
                <option value="Comercial">Comercial</option>
                <option value="Industrial">Industrial</option>
            </select>
            <p></p>
            <label for="consumo">Consumo mensal em kWh (quilowatts-hora):</label>
            <input type="number" name="consumo" id="id-consumo" required>
            <p></p>
            <input type="submit" value="Calcular">
        </form>
        <hr>
    </main>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<strong>$erro</strong>";
            } else {
                echo "<h2>Resultado do calculo</h2>";
                echo "<ul>";
                echo "<li>Nome do cliente: <strong>$nome</strong></li>";
                echo "<li>Tipo de instalção: <strong>$tipoInstalacao</strong></li>";
                echo "<li>Consumo em KWh: <strong>$consumo</strong></li>";
                echo "<li>Tarifa aplicada por kWh: <strong>R$ ". number_format($tarifaAplicada, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor antes do imposto: <strong>R$ ". number_format($valorBruto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor do imposto: <strong>R$ ". number_format($valorImposto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor total da conta <strong>R$ ". number_format($valorTotalConta, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>
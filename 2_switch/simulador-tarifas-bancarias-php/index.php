<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulador de Tarifas Bancárias</title>
</head>
<body>
    <?php 
        $nomeCliente = $_POST['nome'] ?? '';
        $tipoContaCliente = $_POST['tipoConta'] ?? '';
        $operacoesRealizadas = $_POST['operacoes'] ?? 1;
        
        $erro = '';
        $tarifaBase = 0;
        $tarifaExtra = 0;
        $tarifaTotal = 0;
        $limiteOperacoes = 0;
        $operacoesExtras = 0;

        // Validações de campos
        if ($nomeCliente === '') {
            $erro = "Erro: O nome do cliente deve preenchido!";
        } elseif ($tipoContaCliente === '') {
            $erro = "Erro: O tipo de conta deve ser informado!";
        } elseif ($operacoesRealizadas < 1) {
            $erro = "Erro: Quantidade inválida ou menor que zero.";
        }

        if ($erro === '') {
            switch ($tipoContaCliente) {
                case "Poupança":
                    $tarifaBase = 5;
                    $limiteOperacoes = 5;
                    $tarifaExtra = 2;
                    break;
                case "Corrente":
                    $tarifaBase = 10;
                    $limiteOperacoes = 10;
                    $tarifaExtra = 1.5;
                    break;
                case "Premium":
                    $tarifaBase = 20;
                    $limiteOperacoes = 20;
                    $tarifaExtra = 1;
                    break;
                default:
                    $erro = "Erro: O tipo de conta escolhido não existe. Tente novamente!";
                    break;
            }

            if ($erro === '') {
                $operacoesExtras = $operacoesRealizadas > $limiteOperacoes ? $operacoesRealizadas - $limiteOperacoes : 0;
                $tarifaTotal = $tarifaBase + ($tarifaExtra * $operacoesExtras);
            }
        }
    ?>
    <main>
        <h1>Preencha os seguintes dados</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="nome">Nome do cliente:</label>
            <input type="text" name="nome" id="id-nome" required>
            <p></p>
            <label for="tipoConta">Tipo de Conta:</label>
            <select name="tipoConta" id="id-tipoConta">
                <option value="">-- Selecione --</option>
                <option value="Corrente">Corrente</option>
                <option value="Poupança">Poupança</option>
                <option value="Premium">Premium</option>
            </select>
            <p></p>
            <label for="operacoes">Quantidade de operações realizadas no mês (apenas números):</label>
            <input type="number" name="operacoes" id="id-operacoes" min="1" placeholder="ex.: 15 saques" required>
            <p></p>
            <input type="submit" value="Simular">
        </form>
        <hr>
    </main>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p><strong>$erro</strong></p>";
            } else {
                echo "<h2>Resultado da Simulação</h2>";
                echo "<ul>";
                echo "<li>Cliente: <strong>$nomeCliente</strong></li>";
                echo "<li>Tipo de conta: <strong>$tipoContaCliente</strong></li>";
                echo "<li>Operações realizadas: <strong>$operacoesRealizadas</strong></li>";
                echo "<li>Tarifa base: <strong>". number_format($tarifaBase, 2, ",", ".") ."</strong></li>";
                echo "<li>Operações extras: <strong>$operacoesExtras</strong></li>";
                echo "<li>Tarifa total: <strong>R$ ". number_format($tarifaTotal, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>
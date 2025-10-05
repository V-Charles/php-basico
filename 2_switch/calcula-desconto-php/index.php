<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade com Switch</title>
</head>
<body>
    <?php 
        $valorOriginal = $_POST['valor'] ?? 0;
        $cliente = $_POST['tipoCliente'] ?? '';
        
        $valorFinal = 0;
        $valorDesconto = 0;
        $valorImposto = 0;
        $erro = '';
        $tipoCliente = '';

        if ($valorOriginal <= 0) {
            $erro = "Valor do produto inválido!";

        } elseif ($cliente === '') {
            $erro = "É necessário informar o tipo de cliente.";

        } else {

            switch ($cliente) {
                case '1':
                    $percentualDesconto = 0.05;
                    $tipoCliente = 'Comum';
                    break;
                case '2':
                    $percentualDesconto = 0.10;
                    $tipoCliente = 'Premium';
                    break;
                case '3':
                    $percentualDesconto = 0.15;
                    $tipoCliente = 'VIP';
                    break;
                default:
                    $erro = "Tipo de cliente inválido!";
            }

            if ($erro === '') {
                $valorDesconto = $valorOriginal * $percentualDesconto;
                $valorFinal = $valorOriginal - $valorDesconto;
                $valorImposto = $valorFinal * 0.07;
                $valorFinal += $valorImposto;
            }
        }
    ?>
    <main>
        <h1>Informe os seguintes dados</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <label for="valor">Valor do produto</label>
            <input type="number" name="valor" id="idvalor" step="0.01" min="0.01" required placeholder="R$ 0,00">

            <select name="tipoCliente" id="idTipocliente">
                <option value="">Tipo de cliente</option>
                <option value="1">1 - Comum (5%)</option>
                <option value="2">2 - Premium (10%)</option>
                <option value="3">3 - VIP (15%)</option>
            </select>
            <p></p>
            <input type="submit" value="Aplicar">
        </form>
        <hr>
    </main>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p><strong>$erro</strong></p>";
            } else {
                echo "<h2>Desconto gerado com sucesso!</h2>";
                echo "<ul>";
                echo "<li>Tipo de cliente: <strong>$tipoCliente</strong></li>";
                echo "<li>Valor Original: <strong>R$ ". number_format($valorOriginal, 2, ",", ".") ." </strong></li>";
                echo "<li>Valor do Desconto: <strong>R$ ". number_format($valorDesconto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor do Imposto: (7%) <strong>R$ ". number_format($valorImposto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor Final: <strong>R$ ". number_format($valorFinal, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Preço de Ingresso</title>
</head>
<body>
    <?php 
        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = $_POST['nome'] ?? '';
            $idade = $_POST['idade'] ?? 0;
            $diaSemana = $_POST['diaSemana'] ?? '';

            if ($nome === '') {
                $erro = "Erro: O nome deve ser informado!";
            } elseif ($idade <= 0) {
                $erro = "Erro: O valor da idade deve ser válido!";
            } elseif ($diaSemana === '') {
                $erro = "Erro: O dia da semana deve ser informado!";
            }

            function defineValorBase($diaSemana) {
                switch ($diaSemana) {
                    case 'segunda':
                    case 'terca':
                    case 'quarta':
                        return 20;
                        break;
                    case 'quinta':
                    case 'sexta':
                    case 'sabado':
                    case 'domingo':
                        return 30;
                        break;
                    default:
                        $erro = "Erro: Dia escolhido inválido!";
                        return 0;
                        break;
                }
            }

            function calculaDesconto($ingressoBase, $idade) {
                $desconto = 0;

                if ($idade > 0 && $idade < 12) {
                    $desconto = $ingressoBase * 0.50;
                } elseif ($idade >= 60) {
                    $desconto = $ingressoBase * 0.40;
                }
                return $desconto;
            }

            if ($erro === '') {
                $ingressoBase = defineValorBase($diaSemana);
                $desconto = calculaDesconto($ingressoBase, $idade);

                $precoFinal = $ingressoBase - $desconto;
            }
        }
    ?>
    <main>
        <h1>Formulário de Ingresso</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="nome">Nome do Cliente:</label>
            <input type="text" name="nome" id="id-nome" required>
            <p></p>
            <label for="idade">Idade do Cliente:</label>
            <input type="number" name="idade" id="id-idade" min="1" placeholder="Apenas números" required>
            <p></p>
            <label for="diaSemana">Dia da semana:</label>
            <select name="diaSemana" id="id-diaSemana" required>
                <option value="">-- SELECIONE --</option>
                <option value="segunda">Seguda-Feira</option>
                <option value="terca">Terça-Feira</option>
                <option value="quarta">Quarta-Feira</option>
                <option value="quinta">Quinta-Feira</option>
                <option value="sexta">Sexta-Feira</option>
                <option value="sabado">Sábado</option>
                <option value="domingo">Domingo</option>
            </select>
            <p></p>
            <input type="submit" value="Gerar Ingresso">
        </form>
    </main>
    <hr>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p><strong>$erro</strong></p>";
            } else {
                echo "<ul>";
                echo "<li>Nome do cliente: <strong>$nome</strong></li>";
                echo "<li>Idade do cliente: <strong>$idade</strong></li>";
                echo "<li>Dia da semana escolhido: <strong>$diaSemana</strong></li>";
                echo "<li>Valor original do ingresso: <strong>R$ ". number_format($ingressoBase, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor do desconto: <strong>R$ ". number_format($desconto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor final do ingresso: <strong>R$ ". number_format($precoFinal, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>
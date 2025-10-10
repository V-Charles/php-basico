<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de desconto progressivo</title>
</head>
<body>
    <?php 
        $erro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = $_POST['nome'] ?? '';
            $preco = $_POST['valorcompra'] ?? 0;

            if ($nome === '') {
                $erro = "Erro: É necessário inserir um nome.";
            } elseif ($preco <= 0) {
                $erro = "Erro: O valor informado é inválido.";
            }

            if ($erro === '') {

                function calcularDesconto($preco) {
                    if ($preco > 100 && $preco <= 500) {
                        return 0.05;
                    } elseif ($preco > 500 && $preco <= 1000) {
                        return 0.10;
                    } elseif ($preco > 1000) {
                        return 0.15;
                    } else {
                        return 0;
                    }
                }

                $percentualDesconto = calcularDesconto($preco);

                $desconto = $preco * $percentualDesconto;
                $total = $preco - $desconto;
            }
        }
    ?>
    <main>
        <h1>Preencha os campos a seguir</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <label for="nome">Nome:</label><br>
                <input type="text" name="nome" id="id-nome">
                <p></p>
                <label for="valorcompra">Valor da Compra (R$):</label><br>
                <input type="number" name="valorcompra" id="id-valorcompra" step="0.01">
                <p></p>
                <input type="submit" value="Calcular">
        </form>
        <hr>
    </main>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p><strong>$erro</strong></p>";
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                echo "<ul>";
                echo "<li>Nome do cliente: <strong>$nome</strong></li>";
                echo "<li>Valor original da compra: <strong>R$ ". number_format($preco, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor do desconto: <strong>R$ ". number_format($desconto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor final da compra: <strong>R$ ". number_format($total, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de Seguro Veicular</title>
</head>
<body>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = $_POST['nome'] ?? '';
            $valorVeiculo = $_POST['valorVeiculo'] ?? 0;
            $tipoVeiculo = $_POST['tipoVeiculo'] ?? '';
            $idade = $_POST['idade'] ?? 0;
            $tempoHabilitado = $_POST['tempoHabilitado'] ?? 0;

            $valorBaseSeguro = 0;
            $acrescimoRisco = 0;
            $descontoAplicado = 0;
            $valorImposto = 0;
            $valorFinalAnual = 0;
            $percentualTaxa = 0;
            $erro = '';

            if ($nome === '') {
                $erro = "Erro: É necessário informar um nome.";
            } elseif ($valorVeiculo <= 0) {
                $erro = "Erro: O valor do veículo precisa ser válido.";
            } elseif ($tipoVeiculo === '') {
                $erro = "Erro: O tipo de veículo deve ser informado.";
            } elseif ($idade <= 0) {
                $erro = "Erro: A idade deve ser um valor válido.";
            } elseif ($idade > 0 && $idade < 18) {
                $erro = "Erro: O condutor deve ser maior de idade.";
            } elseif ($tempoHabilitado <= 0) {
                $erro = "Erro: O tempo de habilitação deve ser válido.";
            }

            if ($erro === '') {
                switch ($tipoVeiculo) {
                    case 'carro':
                        $percentualTaxa = 0.05;
                        $tipoVeiculo = "Carro";
                        break;
                    case 'moto':
                        $percentualTaxa = 0.08;
                        $tipoVeiculo = "Moto";
                        break;
                    case 'caminhao':
                        $percentualTaxa = 0.06;
                        $tipoVeiculo = "Caminhão";
                        break;
                    default:
                        $erro = "Erro: O tipo de veículo selecionado é inválido.";
                        break;
                }

                if ($erro === '') {
                    $valorBaseSeguro = $valorVeiculo * $percentualTaxa;

                    if ($idade < 25) {
                        $acrescimoRisco = $valorBaseSeguro * 0.10;
                    } elseif ($idade > 60) {
                        $acrescimoRisco = $valorBaseSeguro * 0.05;
                    }

                    $valorFinalAnual = $valorBaseSeguro + $acrescimoRisco;

                    if ($tempoHabilitado >= 3 && $tempoHabilitado <= 5) {
                        $descontoAplicado = $valorFinalAnual * 0.05;
                    } elseif ($tempoHabilitado > 5) {
                        $descontoAplicado = $valorFinalAnual * 0.10;
                    }

                    $valorFinalAnual = $valorFinalAnual - $descontoAplicado;
                    $valorImposto = $valorFinalAnual * 0.07;
                    $valorFinalAnual = $valorFinalAnual + $valorImposto;

                }
            } 
        }
    ?>
    <main>
        <h1>Preencha o formulário</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="nome">Nome do cliente:</label>
            <input type="text" name="nome" id="id-nome" required>
            <p></p>
            <label for="valorVeiculo">Valor do veículo: R$ </label>
            <input type="number" name="valorVeiculo" id="id-valorVeiculo" step="0.01" min="0.01" required>
            <p></p>
            <label for="tipoVeiculo">Tipo de veículo</label>
            <select name="tipoVeiculo" id="id-tipoVeiculo" required>
                <option value="">-- SELECIONE --</option>
                <option value="carro">Carro</option>
                <option value="moto">Moto</option>
                <option value="caminhao">Caminhão</option>
            </select>
            <p></p>
            <label for="idade">Idade do condutor:</label>
            <input type="number" name="idade" id="id-idade" min="18" required>
            <p></p>
            <label for="tempoHabilitado">Tempo de habilitação:</label>
            <input type="number" name="tempoHabilitado" id="id-tempoHabilitado" required>
            <p></p>
            <input type="submit" value="Calcular">
        </form>
        <hr>
    </main>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p><strong>$erro</strong></p>";
            } else {
                echo "<h2>Resultado da Apólice</h2>";
                echo "<ul>";
                echo "<li>Nome do cliente: <strong>$nome</strong></li>";
                echo "<li>Tipo de veículo: <strong>$tipoVeiculo</strong></li>";
                echo "<li>Valor do veículo: <strong>R$ ". number_format($valorVeiculo, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor base do seguro: <strong>R$ ". number_format($valorBaseSeguro, 2, ",", ".") ."</strong></li>";
                echo "<li>Acréscimo de risco: <strong>R$ ". number_format($acrescimoRisco, 2, ",", ".") ."</strong></li>";
                echo "<li>Desconto aplicado: <strong>R$ ". number_format($descontoAplicado, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor do imposto: <strong>R$ ". number_format($valorImposto, 2, ",", ".") ."</strong></li>";
                echo "<li>Valor final do seguro anual: <strong>R$ ". number_format($valorFinalAnual, 2, ",", ".") ."</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
</body>
</html>
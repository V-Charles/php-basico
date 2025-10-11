<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de avaliação de funcionário</title>
</head>
<body>
    <?php
        $erro = '';
        $mostrarResultados = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mostrarResultados = true;

            $nome = trim($_POST['nomeCompleto'] ?? '');
            $cargo = trim($_POST['cargo'] ?? '');
            
            $dataAdmissaoStr = $_POST['dataadmissao'] ?? '';
            $anosDeEmpresa = 0;
            
            if (!empty($dataAdmissaoStr)) {
                $dataAdmissao = new DateTime($dataAdmissaoStr);
                $hoje = new DateTime();
                $diferenca = $hoje->diff($dataAdmissao);
                $anosDeEmpresa = $diferenca->y;
            }

            $projetos = (int)($_POST['projetosconcluidos'] ?? 0);
            $faltas = (int)($_POST['faltas'] ?? 0);
            $notaSupervisor = (float)($_POST['notasupervisor'] ?? 0);

            if ($nome === '') {
                $erro = "Erro: O campo nome deve ser preenchido!";
            } elseif($cargo === '') {
                $erro = "Erro: O campo cargo deve ser preenchido!";
            } elseif (empty($dataAdmissaoStr)) {
                $erro = "Erro: O campo para a data de admissão do funcionário deve ser preenchido!";
            } elseif ($projetos < 0) {
                $erro = "Erro: A quantidade de projetos concluídos não pode ser negativa!";
            } elseif ($faltas < 0) {
                $erro = "Erro: A quantidade de faltas deve ser válida!";
            } elseif ($notaSupervisor < 0 || $notaSupervisor > 10) {
                $erro = "Erro: A nota de supervisor deve ser de 0 a 10.";
            }

            function bonusPorTempo($anos) {
                if ($anos < 1) return 0;
                if ($anos <= 3) return 2;
                if ($anos <= 5) return 5;
                return 8;
            }

            function calcularPontuacao($projetos, $faltas, $nota, $bonus) {
                $pontuacao = ($projetos * 10) + ($nota * 5) + $bonus;
                $pontuacao -= ($faltas * 2);
                return max(0, $pontuacao);
            }

            function classificarFuncionario($pontuacao) {
                switch (true) {
                    case ($pontuacao >= 100): return "Funcionário do mês!";
                    case ($pontuacao >= 80): return "Excelente Desempenho!";
                    case ($pontuacao >= 60): return "Bom Desempenho.";
                    case ($pontuacao >= 40): return "Regular";
                    default: return "Precisa melhorar.";
                }
            }

            if ($erro === '') {
                $bonus = bonusPorTempo($anosDeEmpresa);
                $pontuacaoFinal = calcularPontuacao($projetos, $faltas, $notaSupervisor, $bonus);
                $classificacao = classificarFuncionario($pontuacaoFinal);

                $nomeFormatado = strtoupper($nome);
                $cargoFormatado = ucfirst($cargo);
                $pontuacaoFinal = round($pontuacaoFinal, 2);
                $dataAvaliacao = date("d/m/Y");
            }
        }
    ?>
    <main>
        <h1>Preencha o formulário</h1>
        <form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
            <label for="nomeCompleto">Nome completo do funcionário:</label>
            <input type="text" name="nomeCompleto" id="id-nomeCompleto" required>
            <p></p>
            <label for="cargo">Cargo do funcionário:</label>
            <input type="text" name="cargo" id="id-cargo" required>
            <p></p>
            <label for="dataadmissao">Data de admissão:</label>
            <input type="date" name="dataadmissao" id="id-dataadmissao" required>
            <p></p>
            <label for="projetosconcluidos">Número de projetos concluídos no mês:</label>
            <input type="number" name="projetosconcluidos" id="id-projetosconcluidos" min="0" required>
            <p></p>
            <label for="faltas">Número de faltas:</label>
            <input type="number" name="faltas" id="id-faltas" min="0" required>
            <p></p>
            <label for="notasupervisor">Nota de avaliação do supervisor:</label>
            <input type="number" name="notasupervisor" id="id-notasupervisor" min="0" max="10" placeholder="De 0 a 10" required>
            <p></p>
            <button type="submit">Avaliar Funcionário</button>
        </form>
        <hr>
    </main>
    <?php if ($mostrarResultados): ?>
    <section>
        <?php 
            if ($erro !== '') {
                echo "<p style='color: red;'><strong>$erro</strong></p>";
            } else {
                echo "<h2>Resultado da Avaliação do Funcionário</h2>";
                echo "<ul>";
                echo "<li>Nome do funcionário: <strong>$nomeFormatado</strong></li>";
                echo "<li>Cargo: <strong>$cargoFormatado</strong></li>";
                echo "<li>Tempo de empresa: <strong>$anosDeEmpresa anos</strong></li>";
                echo "<li>Projetos concluídos no mês: <strong>$projetos</strong></li>";
                echo "<li>Números de faltas: <strong>$faltas</strong></li>";
                echo "<li>Nota do supervisor: <strong>$notaSupervisor</strong></li>";
                echo "<li>Pontuação final: <strong>$pontuacaoFinal</strong></li>";
                echo "<li>Classificação: <strong>$classificacao</strong></li>";
                echo "<li>Data da avaliação: <strong>$dataAvaliacao</strong></li>";
                echo "</ul>";
            }
        ?>
    </section>
    <?php endif; ?>
</body>
</html>
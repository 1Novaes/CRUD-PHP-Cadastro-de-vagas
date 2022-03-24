<?php
$mensagem = '';

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Ação executada com succeso</div>';
            break;
        case 'error':
            $mensagem = '<div class="alert alert-danger">Ação Não executada</div>';
            break;
    }
}


$resultados = '';

foreach ($vagas as $vaga) {
    $resultados .= '<tr>
                        <td>' . $vaga->id . '</td>
                        <td>' . $vaga->titulo . '</td>
                        <td>' . $vaga->descricao . '</td>
                        <td>' . ($vaga->ativo == 's' ? 'Ativo' : 'Inativo') . '</td>
                        <td>' . date('d/m/Y à\s H:i:s', strtotime($vaga->data)) . '</td>
                        <td>
                           <a href="editar.php?id=' . $vaga->id . '"> 
                           <button type="button" class="btn btn-primary mt-2 w-100">Editar</button>
                           </a> 
                           <a href="excluir.php?id=' . $vaga->id . '"> 
                           <button type="button" class="btn btn-danger mt-2 w-100 ">Excluir</button>
                           </a> 
                        </td>
                        </tr>';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center ">Nenhuma vaga encontrada. Cadastre uma vaga</td>   
                                                    </tr>'
?>
<main>
    <?= $mensagem ?>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova vaga</button>
        </a>
    </section>
    <!-- Tabela com a lista de vagas -->
    <section>
        <table class="table bg-light mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Descricao</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>

                <?= $resultados ?>

            </tbody>
        </table>

    </section>
</main>
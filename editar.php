<?php

require __DIR__ . '/vendor/autoload.php';

define('TITLE', 'Editar vaga');

use \App\Entity\Vaga;

// Validação do ID

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');
    exit;
}

$obvaga = Vaga::getVaga($_GET['id']);


// Validação da vaga
if (!$obvaga instanceof Vaga) {
    header('location: index.php?status=error');
    exit;
}

//Validação do Post
if (isset($_POST['titulo'], $_POST['descricao'], $_POST['ativo'])) {
    //NÃO FOI NECESSARIO INSTANCIA AQUI , POIS VAGA VOI INSTANCIADO ACIMA
    // $obvaga = new Vaga();

    $obvaga->titulo = $_POST['titulo'];
    $obvaga->descricao = $_POST['descricao'];
    $obvaga->ativo = $_POST['ativo'];
    $obvaga->atualizar();

    header('location: index.php?status=success');
    exit;
}


include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/formulario.php';
include __DIR__ . '/includes/footer.php';
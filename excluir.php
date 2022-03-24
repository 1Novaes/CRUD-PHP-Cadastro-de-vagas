<?php

require __DIR__ . '/vendor/autoload.php';



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
if (isset($_POST['excluir'])) {



    $obvaga->excluir();

    header('location: index.php?status=success');
    exit;
}


include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/confirm-delete.php';
include __DIR__ . '/includes/footer.php';
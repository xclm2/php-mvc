<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= env('APP_NAME') ?><?= isset($data['title']) ? ' / ' . $data['title'] : ''?></title>
        <link rel="stylesheet" href="<?= asset('styles/bootstrap/css/bootstrap.min.css') ?>"/>
    </head>
<body>
<?php require 'nav.php' ?>
<div class="container mt-5">
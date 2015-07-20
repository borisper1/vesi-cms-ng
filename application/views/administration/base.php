<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title ?></title>

        <link href="<?=$urls['admin_bootstrap.css']?>" rel="stylesheet">
        <link href="<?=$urls['bootstrap-switch.css']?>" rel="stylesheet">
        <link href="<?=$urls['fontawesome']?>" rel="stylesheet">
        <link href="<?=base_url('assets/administration/main.css')?>" rel="stylesheet">

        <?php foreach($urls['aux_css_loader'] as $aux_url): ?>
            <link href="<?=$aux_url?>" rel="stylesheet">
        <?php endforeach; ?>
    </head>
    <body>

        <?php echo $menu ?>
        <div class="container-fluid">
            <?php echo $content ?>
        </div>

        <?php echo $system_dom ?>

        <script src="<?=$urls['jquery']?>"></script>
        <script>window.jQuery || document.write('<script src="<?=$urls['jquery_local']?>">\x3C/script>')</script>
        <script src="<?=$urls['jquery-ui.js']?>"></script>
        <script src="<?=$urls['bootstrap.js']?>"></script>
        <script src="<?=$urls['bootstrap-switch.js']?>"></script>
        <script src="<?=base_url('assets/administration/main.js')?>"></script>
        <?php foreach($urls['aux_js_loader'] as $aux_url): ?>
            <script src="<?=$aux_url?>"></script>
        <?php endforeach; ?>
    </body>
</html>

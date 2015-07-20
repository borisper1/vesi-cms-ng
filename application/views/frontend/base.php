<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title ?></title>

        <link href="<?=$urls['frontend_bootstrap.css']?>" rel="stylesheet">
        <link href="<?=$urls['fontawesome']?>" rel="stylesheet">
        <link href="<?=base_url('assets/frontend-main.css')?>" rel="stylesheet">

        <?php if($legacy_support): ?>
            <!--[if lt IE 9]>
            <script src="<?=$urls['html5shiv']?>"></script>
            <script src="<?=$urls['respond.js']?>"></script>
            <![endif]-->
        <?php endif; ?>
    </head>
    <body>
        <?php echo $menu ?>

        <?php echo $content ?>

        <script src="<?=$urls['jquery']?>"></script>
        <?php if($use_cdn['jquery']): ?>
            <script>window.jQuery || document.write('<script src="<?=$fallback_urls['jquery']?>">\x3C/script>')</script>
        <?php endif; ?>
        <script src="<?=$urls['bootstrap.js']?>"></script>
        <?php if($use_cdn['bootstrap.js']): ?>
            <script>(typeof $().emulateTransitionEnd == 'function') || document.write('<script src="<?=$fallback_urls['bootstrap.js']?>">\x3C/script>')</script>
        <?php endif; ?>
        <?php if($hover_menus): ?>
            <script src="<?=$urls['bootstrap_menu_hover']?>"></script>
        <?php endif; ?>
        <script src="<?=base_url('assets/frontend-main.js')?>"></script>
    </body>
</html>

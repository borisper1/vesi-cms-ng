<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo strip_tags($title) ?></title>

        <link href="<?=base_url('assets/third_party/bootstrap/css/bootstrap-custom.min.css')?>" rel="stylesheet">
        <link href="<?=$urls['fontawesome']?>" rel="stylesheet">
        <link href="<?=base_url('assets/frontend-main.css')?>" rel="stylesheet">

        <?php if($legacy_support): ?>
            <!--[if lt IE 8]>
                <script>window.location.href = "<?=base_url('assets/unsupported.html') ?>"</script>
            <![endif]-->
            <!--[if lt IE 9]>
            <script src="<?=base_url('assets/third_party/legacy-support/html5shiv.min.js')?>"></script>
            <script src="<?=base_url('assets/third_party/legacy-support/respond.min.js')?>"></script>
            <![endif]-->
        <?php else: ?>
            <!--[if lt IE 9]>
            <script>window.location.href = "<?=base_url('assets/unsupported.html') ?>"</script>
            <![endif]-->
        <?php endif; ?>
    </head>
    <body>
        <div id="page-wrapper">
            <?php echo $menu ?>

            <?php echo $content ?>
        </div>
        <script src="<?=$urls['jquery']?>"></script>
        <?php if($use_cdn['jquery']): ?>
            <script>window.jQuery || document.write('<script src="<?=$fallback_urls['jquery']?>">\x3C/script>')</script>
        <?php endif; ?>
        <script src="<?=$urls['bootstrap.js']?>"></script>
        <?php if($use_cdn['bootstrap.js']): ?>
            <script>(typeof $().emulateTransitionEnd == 'function') || document.write('<script src="<?=$fallback_urls['bootstrap.js']?>">\x3C/script>')</script>
        <?php endif; ?>
        <?php if($hover_menus): ?>
            <script src="<?=base_url('assets/third_party/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')?>"></script>
        <?php endif; ?>
        <script src="<?=base_url('assets/frontend-main.js')?>"></script>
        <?php foreach($urls['aux_js_loader'] as $aux_url): ?>
            <script src="<?=$aux_url?>"></script>
        <?php endforeach; ?>
    </body>
</html>

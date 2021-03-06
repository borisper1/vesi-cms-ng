<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $title ?></title>

        <link href="<?=base_url('assets/third_party/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('assets/third_party/bootstrap-switch/bootstrap-switch.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('assets/third_party/fontawesome/css/font-awesome.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('assets/third_party/bootstrap-select/css/bootstrap-select.min.css')?>" rel="stylesheet">
        <link href="<?=base_url('assets/administration/main.css')?>" rel="stylesheet">

        <?php foreach($urls['aux_css_loader'] as $aux_url): ?>
            <link href="<?=$aux_url?>" rel="stylesheet">
        <?php endforeach; ?>
    </head>
    <body>

        <?php echo $menu ?>
        <div class="container-fluid" id="base-gui-container">
            <?php echo $content ?>
        </div>

        <?php echo $system_dom ?>

        <script src="<?=$urls['jquery']?>"></script>
        <script>window.jQuery || document.write('<script src="<?=$urls['jquery_local']?>">\x3C/script>')</script>
        <script src="<?=base_url('assets/third_party/jquery-ui/jquery-ui.min.js')?>"></script>
        <script src="<?=base_url('assets/third_party/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?=base_url('assets/third_party/bootstrap-switch/bootstrap-switch.min.js')?>"></script>
        <script src="<?=base_url('assets/third_party/bootstrap-select/js/bootstrap-select.min.js')?>"></script>
        <script src="<?=base_url('assets/third_party/bootstrap-select/js/i18n/defaults-it_IT.min.js')?>"></script>
        <script src="<?=base_url('assets/third_party/ace/ace.js')?>"></script>
        <script>
            !function () {
                window.vbcknd = {};
                window.vbcknd.base_url = "<?=base_url() ?>";
                window.vbcknd.services = {};
                window.vbcknd.config = {};
                window.vbcknd.auto_name_format = function (title) {
                    return title.replace(/[^A-Za-z0-9 ]+/, '').replace(/\s+/g, '-').toLowerCase().substr(0, 40);
                };
                window.vbcknd.auto_file_size_format = function (size) {
                    var i = -1;
                    var byteUnits = [' kiB', ' MiB', ' GiB', ' TiB'];
                    do {
                        size = size / 1024;
                        i++;
                    } while (size > 1024);
                    return Math.max(size, 0.01).toFixed(2) + byteUnits[i];
                };
            }();
        </script>
        <script src="<?=base_url('assets/administration/main.js')?>"></script>
        <script src="<?=base_url('assets/file_conversion_service.js')?>"></script>
        <?php foreach($urls['aux_js_loader'] as $aux_url): ?>
            <script src="<?=$aux_url?>"></script>
        <?php endforeach; ?>
    </body>
</html>

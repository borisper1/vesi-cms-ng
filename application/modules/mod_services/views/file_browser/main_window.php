<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Esplora files - Vesi CMS</title>
    <link href="<?= base_url('assets/third_party/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/third_party/fontawesome/css/font-awesome.min.css') ?>" rel="stylesheet">
</head>
<body>
<span class="hidden" id="function-number"><?= $function_number ?></span>
<div class="container-fluid" id="choose-target-fs-view">
    <h4>Scegli il file da collegare al documento</h4>
    <button class="btn btn-default path-indicator" id="file-picker-level-up" disabled><i class="fa fa-level-up"></i>
    </button>
    <button class="btn btn-default path-indicator" id="file-picker-upload-file" disabled><i class="fa fa-cloud-upload"></i> Carica file
    </button>
    <code id="file-picker-path-indicator"><?= $path ?></code>
    <br><br>
    <table class="table table-hover file-picker-list">
        <?php foreach ($path_array as $file): ?>
            <tr class="file-picker-<?= $file['type'] ?> file-picker-element" data-path="<?= $file['path'] ?>">
                <td><i class="fa fa-lg fa-fw <?= $file['icon'] ?>"></i> <a href="#"
                                                                           class="file-manager-picker-link"><?= $file['name'] ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script src="<?= $urls['jquery'] ?>"></script>
<script>window.jQuery || document.write('<script src="<?=$urls['jquery_local']?>">\x3C/script>')</script>
<script src="<?= base_url('assets/third_party/bootstrap/js/bootstrap.min.js') ?>"></script>
<script>
    !function () {
        window.vbcknd = {};
        window.vbcknd.base_url = "<?=base_url() ?>";
    }();
</script>
<script src="<?= base_url('assets/file_browser_service.js') ?>"></script>
</body>
</html>

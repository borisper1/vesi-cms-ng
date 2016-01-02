<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-upload"></i> File e immagini</h1></div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#"><i class="fa fa-cloud-upload fa-fw"></i> Carica file </a></li>
        <li><a href="#"><i class="fa fa-folder fa-fw"></i> Nuova cartella</a></li>
    </ul>
</div>
<div class="btn-group spaced hidden" id="file-system-actions">
    <button type="button" class="btn btn-default" id="fmgr-download"><i class="fa fa-download"></i> Scarica</button>
    <button type="button" class="btn btn-default" id="fmgr-rename"><i class="fa fa-pencil"></i> Rinomina</button>
    <button type="button" class="btn btn-default" id="fmgr-delete"><i class="fa fa-trash"></i> Elimina</button>
    <button type="button" class="btn btn-default" id="fmgr-delete"><i class="fa fa-caret-square-o-right"></i> Sposta</button>
    <button type="button" class="btn btn-default" id="fmgr-delete"><i class="fa fa-copy"></i> Copia</button>
</div>
<div class="btn-group pull-right spaced" data-toggle="buttons">
    <label class="btn btn-default active">
        <input type="radio" name="path" id="path-files" autocomplete="off" checked><i class="fa fa-file"></i> File
    </label>
    <label class="btn btn-default">
        <input type="radio" name="path" id="path-image" autocomplete="off"><i class="fa fa-image"></i> Immagini
    </label>
</div>
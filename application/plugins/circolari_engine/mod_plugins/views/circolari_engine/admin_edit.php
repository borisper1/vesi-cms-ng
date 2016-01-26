<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-copy"></i> Circolari</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-cnumsuf"><?= $number . $suffix ?></span> <span
        id="f-title"><?= $title ?></span>
    <small><span class="label label-info" id="f-category"><?= $category ?></span> <span class="label label-default"
                                                                                        id="f-id"><?= $id ?></span>
    </small>
</h3>
<div class="btn-group pull-right" id="page-actions">
    <button type="button" class="btn btn-default" id="save-circolare"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?= $is_new ? 'true' : 'false' ?></span>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare
        la circolare:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Circolare salvata con successo.
</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio della circolare...
</div>
<div class="form-group">
    <label for="input-title">Titolo della circolare:</label>
    <input type="text" class="form-control" id="i-title" placeholder="Inserisci titolo" value="<?= $title ?>">
</div>

<div class="form-inline form-group">
    <label for="input-title">Circolare N°:</label>
    <input type="number" class="form-control form-inline" id="i-number" placeholder="Numero" value="<?= $number ?>">
    <label for="input-title">Suffisso:</label>
    <input type="text" class="form-control form-inline" id="i-suffix" placeholder="Suffisso" value="<?= $suffix ?>">
</div>


<div class="btn-group spaced" id="editor-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-upload"></i> Importa da file <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="import-document" data-format="docx"><i class="fa fa-fw fa-file-word-o"></i> File Word</a>
            </li>
            <li><a href="#" class="import-document" data-format="odt"><i class="fa fa-fw fa-file-text-o"></i> File ODT
                    (ODF)</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-download"></i> Esporta <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="export-document" data-format="docx"><i class="fa fa-fw fa-file-word-o"></i> File Word</a>
            </li>
            <li><a href="#" class="export-document" data-format="odt"><i class="fa fa-fw fa-file-text-o"></i> File ODT
                    (ODF)</a></li>
            <li><a href="#" class="export-document" data-format="latex"><i class="fa fa-fw fa-file-pdf-o"></i> File PDF</a>
            </li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-pencil-square-o"></i> Inserisci layout <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="insert-2-columns"><i class="fa fa-fw fa-columns"></i> Layout a due colonne</a></li>
            <li><a href="#" id="insert-3-columns"><i class="fa fa-fw fa-columns"></i> Layout a tre colonne</a></li>
        </ul>
    </div>
</div>
<br>

<textarea class="textarea-standard" id="gui_editor"><?= $content ?></textarea>
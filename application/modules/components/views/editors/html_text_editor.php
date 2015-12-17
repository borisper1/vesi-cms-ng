<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <i class="fa fa-warning"></i> <strong>Attenzione!</strong> La pagina pubblicata potrebbe avere un aspetto diverso da quello visualizzato nell'editor.
</div>

<span id="editor-name" class="hidden">html-text</span>

<div class="btn-group" id="editor-actions">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-upload"></i> Importa da file <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="import-document" data-format="docx"><i class="fa fa-fw fa-file-word-o"></i> File Word</a></li>
            <li><a href="#" class="import-document" data-format="odt"><i class="fa fa-fw fa-file-text-o"></i> File ODT (ODF)</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-download"></i> Esporta <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" class="export-document" data-format="docx"><i class="fa fa-fw fa-file-word-o"></i> File Word</a></li>
            <li><a href="#" class="export-document" data-format="odt"><i class="fa fa-fw fa-file-text-o"></i> File ODT (ODF)</a></li>
            <li><a href="#" class="export-document" data-formt="pdf"><i class="fa fa-fw fa-file-pdf-o"></i> File PDF</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-pencil-square-o"></i> Inserisci layout <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="insert-2-columns"><i class="fa fa-fw fa-columns"></i> Layout a due colonne</a></li>
            <li><a href="#" id="insert-3-columns"><i class="fa fa-fw fa-columns"></i> Layout a tre colonne</a></li>
        </ul>
    </div>
</div>
<br><br>

<textarea class="textarea-standard" id="gui_editor"><?=$content ?></textarea>
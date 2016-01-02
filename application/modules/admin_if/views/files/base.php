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
    <button type="button" class="btn btn-default" id="fmgr-move"><i class="fa fa-caret-square-o-right"></i> Sposta</button>
    <button type="button" class="btn btn-default" id="fmgr-copy"><i class="fa fa-copy"></i> Copia</button>
</div>
<div class="btn-group pull-right spaced" data-toggle="buttons">
    <label class="btn btn-default active">
        <input type="radio" name="path" id="path-files" autocomplete="off" checked><i class="fa fa-file"></i> File
    </label>
    <label class="btn btn-default">
        <input type="radio" name="path" id="path-image" autocomplete="off"><i class="fa fa-image"></i> Immagini
    </label>
</div>
<span class="hidden" id="boot-path">files</span>
<div class="alert alert-info hidden" id="loading-spinner"><i class="fa fa-refresh fa-spin"></i> Caricamento del percorso...</div>
<div class="alert alert-danger hidden" id="error-warning">
    <i class="fa fa-warning"></i> <b>Si è verificato un errore imprevisto nel caricamento del percorso.</b>
    Il server potrebbe esser non disponibile oppure non si dispone delle autorizzazioni necessarie per accedere al percorso. <a href="<?=base_url('admin/files') ?>" class="alert-link">Ricaricare</a> la pagina per riprovare
</div>
<div class='modal fade' id='preview-modal' tabindex='-1' role='dialog' aria-labelledby='preview-modal-label' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <a href="#" target="_blank" class="pull-right" id="file-preview-download"><i class="fa fa-download"></i> Scarica file</a>
                <h4 class='modal-title' id='preview-modal-label'><i class="fa fa-eye"></i> Anteprima file</h4>
            </div>
            <div class='modal-body' id="preview-modal-content"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="rename-element-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Rinomina elemento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-rename-element">Inserire il nome da assegnare all'elemento</label>
                    <input type="text" class="form-control" id="i-rename-element">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="rename-element-modal-confirm" data-dismiss="modal"><i class="fa fa-pencil"></i> Rinomina</button>
            </div>
        </div>
    </div>
</div>
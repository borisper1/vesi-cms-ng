<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header">
    <h1><i class="fa fa-upload"></i> File e immagini
        <button type="button" class="btn btn-default pull-right launch-contextual-help tooltipped" title="Aiuto"
                data-help_path="files"><i class="fa fa-question-circle"></i></button>
    </h1>
</div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#" id="filemgr-upload-file"><i class="fa fa-cloud-upload fa-fw"></i> Carica file </a></li>
        <li><a href="#" id="filemgr-new-folder"><i class="fa fa-folder fa-fw"></i> Nuova cartella</a></li>
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
    <i class="fa fa-exclamation-circle"></i> <b>Si è verificato un errore imprevisto nel caricamento del percorso.</b>
    Il server potrebbe esser non disponibile oppure non si dispone delle autorizzazioni necessarie per accedere al percorso. <a href="<?=base_url('admin/files') ?>" class="alert-link">Ricaricare</a> la pagina per riprovare
</div>
<div class="alert alert-info hidden" id="operation-spinner"><i class="fa fa-refresh fa-spin"></i> Operazione su file in corso...</div>
<div class="alert alert-danger alert-dismissible hidden" id="operation-error">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile completare l'operazione su file</b> Il server potrebbe esser non disponibile oppure non si dispone delle autorizzazioni necessarie per accedere al percorso.
</div>
<div class="modal fade" id="preview-modal" tabindex="-1" role="dialog" aria-labelledby="preview-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <a href="#" target="_blank" class="pull-right" id="file-preview-download"><i class="fa fa-download"></i> Scarica file</a>
                <h4 class="modal-title" id="preview-modal-label"><i class="fa fa-eye"></i> Anteprima file</h4>
            </div>
            <div class="modal-body" id="preview-modal-content"></div>
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

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione elementi</h4>
            </div>
            <div class="modal-body">
                L'eliminazione è una operazione definitiva. Eliminare gli elementi selezionati?
                <div id="delete-modal-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="choose-target-modal" tabindex="-1" role="dialog" aria-labelledby="choose-target-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="choose-target-modal-label"><i class="fa fa-lg fa-folder-open"></i> Scegli la destinazione</h4>
            </div>
            <div class="modal-body">
                <p>Scegliere la cartella in cui spostare/copiare i file selezionati</p>
                <div id="choose-target-fs-view">
                    <button class="btn btn-default path-indicator" id="file-picker-level-up" disabled><i class="fa fa-level-up"></i></button> <code id="file-picker-path-indicator">/</code>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="choose-target-modal-confirm" data-dismiss="modal"><i class="fa fa-bolt"></i> Sposta/copia</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-folder-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-folder"></i> Nuova cartella</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-folder-name">Inserire il nome della cartella</label>
                    <input type="text" class="form-control" id="i-folder-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-folder-modal-confirm" data-dismiss="modal"><i class="fa fa-plus"></i> Crea cartella</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload-file-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-cloud-upload"></i> Carica file</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" id="upload-engine-image-warning" role="alert"><i class="fa fa-info-circle"></i> E' possibile caricare solo immagini in formato <code>JPEG</code>, <code>PNG</code>, <code>GIF</code>, <code>Bitmap</code> o <code>SVG</code> in questa cartella</div>
                <div id="upload-engine-drop-zone">
                    TRASCINA QUI I FILE oppure
                    <button type="button" class="btn btn-default" id="upload-engine-select-files"><i class="fa fa-folder-open"></i> Seleziona files</button>
                </div>
                <form id="upload-engine-form" method="post" action="<?=base_url('services/file_upload/index') ?>" enctype="multipart/form-data" class="hidden">
                    <input type="file" id="upload-engine-files-input" name="files" multiple>
                    <input type="hidden" id="upload-engine-target-field" name="target">
                </form>
                <div id="upload-engine-file-cage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="upload-file-modal-close"><i class="fa fa-remove"></i> Chiudi</button>
            </div>
        </div>
    </div>
</div>

<div id="file-uploading-template" class="hidden">
    <div class="upload-engine-file-indicator" data-status="uploading">
        <i class="fa fa-file-o fa-2x path-indicator"></i> <span class="upload-engine-file-label">Nome file.ext</span>
        <button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-remove"></i> Annulla</button>
        <div class="progress">
            <div class="progress-bar" style="width: 0%; min-width: 2em;"><span class="upload-engine-file-progress-label">0%</span></div>
        </div>
        <p class="text-danger upload-engine-file-failed hidden"><i class="fa fa-exclamation-circle"></i> Si è verificato un errore durante il caricamento del file.</p>
    </div>
</div>
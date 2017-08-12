<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="modal fade" id="export-conversion-modal" tabindex="-1" role="dialog" aria-labelledby="export-conversion-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="export-conversion-modal-label"><i class="fa fa-lg fa-cogs"></i> Conversione documento in corso...</h4>
            </div>
            <div class="modal-body">
                <p>Preparazione del file per il download. Attendere...</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="export-conversion-done-modal" tabindex="-1" role="dialog" aria-labelledby="export-conversion-done-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="export-conversion-done-modal-label"><i class="fa fa-lg fa-check"></i> Documento pronto per il download</h4>
            </div>
            <div class="modal-body">
                <p>Il documento è stato convertito correttamente. Premere sul pulsante seguente per scaricare il file</p>
                <a id="export-conversion-download-file-but" class="btn btn-default" href="#" download><i class="fa fa-download"></i> Scarica file</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="conversion-failed-modal" tabindex="-1" role="dialog" aria-labelledby="conversion-failed-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conversion-failed-modal-label"><i class="fa fa-lg fa-exclamation-circle"></i> Errore conversione documento</h4>
            </div>
            <div class="modal-body">
                <p>il servizio conversione documenti ha riscontrato un errore e non ha potuto completare l'operazione.</p>
                <a role="button" data-toggle="collapse" href="#conversion-error-box" aria-expanded="false" aria-controls="collapseExample">Mostra dettagli</a>
                <div class="collapse" id="conversion-error-box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="conversion-upload-file-modal" tabindex="-1" role="dialog" aria-labelledby="conversion-upload-file-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conversion-upload-file-modal-label"><i class="fa fa-lg fa-upload"></i> Carica file per l'importazione</h4>
            </div>
            <div class="modal-body">
                <form id="conversion-file-upload-form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="conversion-file-input">Scegliere il file da importare</label>
                        <input type="file" id="conversion-file-input" name="to_convert">
                        <p class="help-block">Dimensione massima: <?=ini_get("upload_max_filesize");?>B</p>
                    </div>
                    <button type="submit" class="btn btn-default">Importa file</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import-conversion-progress-modal" tabindex="-1" role="dialog" aria-labelledby="import-conversion-progress-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="export-conversion-modal-label"><i class="fa fa-lg fa-cogs"></i> Caricamento e conversione documento in corso...</h4>
            </div>
            <div class="modal-body">
                <div id="import-progress-uploading">
                    <p>Caricamento del file. Attendere...</p>
                    <div class="progress">
                        <div id="import-upload-bar" class="progress-bar" style="width: 0%; min-width: 2em;">0%</div>
                    </div>
                </div>
                <div id="import-progress-converting" class="hidden">
                    <p>Conversione del file in corso. Attendere...</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

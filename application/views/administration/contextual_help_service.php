<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="contextual-help-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-question-circle"></i> Aiuto di Vesi-CMS
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </h4>
            </div>
            <div class="modal-body" id="contextual-help-modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="help-error-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conversion-failed-modal-label"><i
                        class="fa fa-lg fa-exclamation-circle"></i> Errore caricamento aiuto</h4>
            </div>
            <div class="modal-body">
                <p>Il servizio di aiuto contestuale ha riscontrato un errore e non ha potuto completare
                    l'operazione. La pagina di aiuto cercata potrebbe essere non disponibile (può verificarsi con alcuni
                    componenti aggiuntivi).</p>
                <a role="button" data-toggle="collapse" href="#help-error-box" aria-expanded="false"
                   aria-controls="collapseExample">Mostra dettagli</a>
                <div class="collapse" id="help-error-box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
            </div>
        </div>
    </div>
</div>
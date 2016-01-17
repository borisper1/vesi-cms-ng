<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="code-editor-modal" tabindex="-1" role="dialog" aria-labelledby=code-editor-modal-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="code-editor-modal-label"><i class="fa fa-lg fa-code"></i> Modifica codice
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert" id="code-editor-autosave"><i class="fa fa-info-circle"></i>
                    Le modifiche saranno scartate se non si salva da questa finestra. Le modifiche salvate sono
                    definitive. <b>ricaricare la pagina dopo aver salvato da questa finestra</b>, o le modifiche verrano
                    sovrascritte
                </div>
                <pre id="code-editor"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-primary" id="code-editor-save"><i class="fa fa-save"></i> Salva
                </button>
            </div>
        </div>
    </div>
</div>
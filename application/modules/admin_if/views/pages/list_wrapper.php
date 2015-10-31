<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-file"></i> Pagine</h1></div>
<div class="btn-group">
    <button type="button" class="btn btn-success" id="new-page"><span class="fa fa-plus"></span> Nuova pagina</button>
    <button type="button" class="btn btn-default" id="new-redirect"><span class="fa fa-exchange"></span> Nuovo reindirizzamento</button>
</div>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default" id="show-all"><i class="fa fa-eye"></i> Mostra tutto</button>
    <button type="button" class="btn btn-default" id="hide-all"><i class="fa fa-eye-slash"></i> Nascondi tutto</button>
</div>
<div class="clearfix"></div>
<br><br>

<div class="alert alert-danger alert-dismissible hidden" id="deletion-error-alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare la pagina:</b><br><span id="error-msg"></span>
</div>

<div class="alert alert-danger alert-dismissible hidden content-alert" id="content-deletion-error">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare i contenuti:</b><br> I contenuti sono stati dissociati, ma non è stato possible eliminare alcuni contenuti. Questi contenuti sono adesso orfani.
</div>
<div class="alert alert-success alert-dismissible hidden content-alert" id="content-deletion-success">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Contenuti eliminati con successo
</div>
<div class="alert alert-info hidden content-alert" id="content-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione dei contenuti selezionati...</div>

<datalist id="containers-list">
    <?php foreach($containers as $container): ?>
        <option value="<?=$container ?>"></option>
    <?php endforeach; ?>
</datalist>

<div class="modal fade" id="page-delete-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-trash"></i> Elimina pagina</h4>
            </div>
            <div class="modal-body">
                <div id="page-deletion-modal-wait">
                    <p>Caricamento informazioni albero contenuti. Attendere...</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                    </div>
                </div>
                <div id="page-deletion-modal-show" class="hidden">
                    <p>Questa pagina verrà eliminata definitivamente, inoltre tutti i contenuti della pagina dissociati
                        <br>Eliminare questa pagina?</p>
                </div>
                <div id="page-deletion-modal-orphans" class="hidden">
                    <p>Eliminando questa pagina i seguenti contenuti rimarranno orfani (non sono associati a nessun'altra pagina). Selezionare i contenuti da eliminare definitivamente.</p>
                    <table class="table">
                        <thead><tr>
                            <th>Id</th>
                            <th>Tipo</th>
                            <th>Contenuto</th>
                        </tr></thead>
                        <tbody id="page-deletion-modal-orphan-content"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer hidden" id="page-delete-modal-toolbar">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="page-delete-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina pagina</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tags-edit-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-tags"></i> Modifica tags pagina</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-tags-value">Inserire i tag separandoli con una virgola <kbd>,</kbd></label>
                    <input type="text" class="form-control" id="i-tags-value" placeholder="Tags">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="tags-edit-modal-confirm" data-dismiss="modal"><i class="fa fa-tag"></i> Modifica tags</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="redirect-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="redirect-modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-redirect-page">Inserire il nome del contenitore del reindirizzamento</label>
                    <input type="text" class="form-control" id="i-redirect-container" placeholder="Contenitore reindirizzamento" list="containers-list">
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-redirect-page">Inserire il nome del contenitore di destinazione</label>
                    <input type="text" class="form-control" id="i-redirect-target" placeholder="Contenitore destinazione" list="containers-list">
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="i-redirect-page">Inserire il nome di sistema della pagina da collegare</label>
                    <input type="text" class="form-control" id="i-redirect-page" placeholder="Nome pagina">
                    <span class="help-block">Può contenere solo lettere minuscole (non accentate), numeri e trattini <kbd>-</kbd></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="redirect-modal-confirm"></button>
            </div>
        </div>
    </div>
</div>

<div id="ajax-cage">
    <?=$rendered_elements ?>
</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-list"></i> Menu secondari</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-main-title"><?=$title ?></span>
    <small><span class="label label-info<?= $display_title >= 1 ? ' hidden' : '' ?>" id="f-show-title">non mostrare</span></small>
    <small><span class="label label-default" id="f-menu-id"><?=$id ?></span></small>
</h3>
<div class="btn-group pull-right" id="menu-actions" data-display_title="<?=$display_title >= 1 ? 'true' : 'false' ?>">
    <div class="btn-group" role="group">
        <button id="new-dropdown" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="new-parent-dropdown"><i class="fa fa-fw fa-bars"></i> Menu a tendina</a></li>
            <li><a href="#" id="new-parent-link"> <i class="fa fa-fw fa-link"></i> Link semplice</a></li>
        </ul>
    </div>
    <button type="button" class="btn btn-default" id="save-menu"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code" disabled><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="edit-attributes"><i class="fa fa-wrench"></i> Modifica attributi</button>
    <button type="button" class="btn btn-default" id="refresh-menu"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>

<div class="modal fade" id="edit-attributes-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-wrench"></i> Modifica attributi</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="i-menu-title">Inserire il titolo del menu</label>
                    <input type="text" class="form-control" id="i-menu-title" placeholder="Titolo">
                </div>
                <div class="checkbox toggle">
                    <label>
                        <input type="checkbox" id="menu-display-title" <?=$display_title >= 1 ? 'checked' : '' ?>> &nbsp;Mostra il titolo
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" id="edit-attributes-confirm"><i class="fa fa-bolt"></i> Modifica attributi</button>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare il menu:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Menu salvato con successo, <b>Premere su <i>Aggiorna</i></b> per continuare a modificare il menu creato e ricaricare le informazioni sullo stato pagine</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio del menu...</div>
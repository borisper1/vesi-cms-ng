<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-list"></i> Menu secondari</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica menu: <span class="f-main-title"><?=$title ?></span></h3>
<div class="btn-group pull-right" id="menu-actions">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus"></i> Nuova voce principale <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="new-parent-dropdown">Menu a tendina</a></li>
            <li><a href="#" id="new-parent-link">Link semplice</a></li>
        </ul>
    </div>
    <button type="button" class="btn btn-default" id="save-menu"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="refresh-menu"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile modificare l'account:</b><br><span id="error-msg"></span></div>
<div class="alert alert-danger hidden" id="delete-error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare l'account:</b><br><span id="delete-error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Utente modificato con successo</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Modifica dell'utente...</div>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-th-list"></i> Menu principale</h1></div>
<div class="btn-group" id="menu-actions">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus"></i> Nuova voce principale <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="new-parent-dropdown"><i class="fa fa-fw fa-bars"></i> Menu a tendina</a></li>
            <li><a href="#" id="new-parent-link"><i class="fa fa-fw fa-link"></i> Link semplice</a></li>
        </ul>
    </div>
    <button type="button" class="btn btn-default" id="save-menu"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code" disabled><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="refresh-menu"><i class="fa fa-refresh"></i> Aggiorna</button>
</div>
<br><br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare il menu:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Menu salvato con successo, <b>Aggiornare la pagina</b> per ricaricare le informazioni sullo stato pagine</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio del menu...</div>

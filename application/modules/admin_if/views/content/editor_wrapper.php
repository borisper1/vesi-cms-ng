<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-cubes"></i> Gestione contenuti</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-preview"><?=$preview ?></span>
    <small><span class="label label-info"><span id="f-type"><?=$type ?></span> <i class="fa fa-ellipsis-v"></i> <span id="f-id"><?=$id ?></span></span></small>
</h3>
<div class="btn-group pull-right" id="content-actions">
    <button type="button" class="btn btn-default" id="save-content"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>
<br>

<div class="alert alert-danger hidden alert-save" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile
        salvare il contenuto:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden alert-save" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Contenuto salvato con successo.
</div>
<div class="alert alert-info hidden alert-save" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio del
    contenuto...
</div>

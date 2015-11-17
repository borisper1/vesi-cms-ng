<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-bullhorn"></i> Gestione avvisi</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-preview"><?=$preview ?></span>
    <small><span class="label label-info" id="f-id"><?=$id ?></span></small>
</h3>
<div class="btn-group pull-right" id="content-actions">
    <button type="button" class="btn btn-default" id="save-alerts"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code" disabled><i class="fa fa-code"></i> Modifica codice</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<span id="is-new" class="hidden"><?=$is_new ? 'true' : 'false' ?></span>
<br>

<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare l'avviso:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success alert-dismissible hidden" id="success-alert">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Avviso salvato con successo.
</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvataggio dell'avviso...</div>
<div class="row">
    <div class="col-md-9">
        <label for="input-pages">Inserire le pagine in cui visualizzare l'avviso:</label>
        <input type="text" class="form-control" id="input-pages" placeholder="Inserisci etichetta" value="<?=$display_on?>">
        <span class="help-block">Inserire <kbd>all</kbd> per visualizzare l'avviso in tutte le pagine, oppure inserire un elenco separato da <kbd>,</kbd> nel formato <code>[contenitore]::[nome]</code></span>
        <br>
        <textarea class='textarea-small' id='gui_editor'><?=$content?></textarea>
    </div>
    <div class="col-md-3">
        <span id="type-hidden" class="hidden"><?=$type ?></span>
        <label for="input-type">Scegliere il tipo di avviso da visualizzare:</label>
        <select class="selectpicker form-control" id="input-type">
            <option value="info">[info] Stile informazione (azzurro)</option>
            <option value="success">[success] Stile successo (verde)</option>
            <option value="warning">[warning] Stile avviso (arancio)</option>
            <option value="danger">[danger] Stile pericolo (rosso)</option>
        </select>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="input-dismissible" <?=$dismissible ? 'checked' : ''?>>
                Consenti la chiusura dell'avviso da parte dell'utente
            </label>
        </div>
        </div>
    </div>
</div>
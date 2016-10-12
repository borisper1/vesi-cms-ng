<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-wrench"></i> Impostazioni</h1></div>

<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <?php foreach($interfaces as $interface): ?>
                <li role="presentation" <?= $active_interface===$interface['name'] ? 'class="active"' : '' ?>><a href="<?=base_url('admin/config/'.$interface['name']) ?>"><i class="fa <?=$interface['icon'] ?>"></i> <?=$interface['label'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="btn-group spaced" id="config-actions">
            <button type="button" class="btn btn-default" id="save-config"><i class="fa fa-save"></i> Salva</button>
            <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
        </div>
        <div class="alert alert-config alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i>
            <b>Impossibile aggiornare la configurazione</b>: il server non ha terminato l'esecuzione (Errore HTTP 500)
        </div>
        <div class="alert alert-config alert-success alert-dismissible hidden" id="success-alert">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Configurazione aggiornata con successo.
        </div>
        <div class="alert alert-config alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i>
            Aggiornamento della configurazione del sistema...
        </div>

        <?=$rendered_interface ?>
    </div>
</div>
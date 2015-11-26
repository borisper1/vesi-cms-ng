<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-cog"></i> Configurazione</h1></div>

<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a href="<?=base_url('admin/config') ?>"><i class="fa fa-cog"></i> Generali</a></li>
            <li role="presentation"><a href="<?=base_url('admin/config/sources') ?>"><i class="fa fa-cubes"></i> Risorse esterne e compatibilità</a></li>
        </ul>
    </div>
    <div class="col-md-9">
        <div class="btn-group" id="config-actions">
            <button type="button" class="btn btn-default" id="save-config"><i class="fa fa-save"></i> Salva</button>
            <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
        </div>
        <br>
        <br>
        <div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile aggiornare la configurazione</b>: il server non ha terminato l'esecuzione (Errore HTTP 500)</div>
        <div class="alert alert-success alert-dismissible hidden" id="success-alert">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <i class="fa fa-check"></i> Configurazione aggiornata con successo.
        </div>
        <div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Aggiornamento della configurazione del sistema...</div>
        <div class="form-group">
            <label for="i-website-name">Titolo del sito:</label>
            <input type="text" class="form-control" id="i-website-name" placeholder="Inserire il titolo del sito" value="<?=$website_name ?>">
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Aspetto e comportamento</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <span class="hidden" id="c-menu-class"><?=$menu_class ?></span>
                    <label for="i-menu-class">Stile del menu principale:</label>
                    <select class="form-control selectpicker" id="i-menu-class">
                        <option value="default">Stile bootstrap standard (bianco)</option>
                        <option value="inverse">Stile bootstrap invertito (nero)</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="checkbox toggle">
                        <label>
                            <input type="checkbox" id="i-menu-hover" <?=$menu_hover ? 'checked' : '' ?>> &nbsp;Abilita menu a sfioramento (bootstrap-hover-dropdown)
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox toggle">
                        <label>
                            <input type="checkbox" id="i-use-fluid-containers" <?=$use_fluid_containers ? 'checked' : '' ?>> &nbsp;Abilita layout fluido (il contenuto riempie lo schermo senza margini, sconsigliato)
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox toggle">
                        <label>
                            <input type="checkbox" id="i-display-home-page-title" <?=$display_home_page_title ? 'checked' : '' ?>> &nbsp;Mostra il titolo per la pagina iniziale (sconsigliato)
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
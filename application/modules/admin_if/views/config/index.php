<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-cog"></i> Configurazione</h1></div>
<div class="row">
    <div class="col-md-9 col-md-offset-3">
        <div class="btn-group" id="config-actions">
            <button type="button" class="btn btn-default" id="save-config"><i class="fa fa-save"></i> Salva</button>
            <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a href="<?=base_url('admin/config') ?>"><i class="fa fa-cog"></i> Generali</a></li>
            <li role="presentation"><a href="<?=base_url('admin/config/sources') ?>"><i class="fa fa-cubes"></i> Risorse esterne e compatibilità</a></li>
        </ul>
    </div>
    <div class="col-md-9">
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
                    <label for="i-menu-class">Stile del menu principale:</label>
                    <select class="form-control" id="i-menu-class">
                        <option value="standard">Stile bootstrap standard (bianco)</option>
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
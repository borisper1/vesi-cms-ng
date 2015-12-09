<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="form-group">
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
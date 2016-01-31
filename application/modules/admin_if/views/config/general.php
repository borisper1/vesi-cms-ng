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
            <label for="i-logo-image-path">Immagine logo del sito:</label>
            <input type="text" class="form-control" id="i-logo-image-path" placeholder="Inserire il percorso"
                   value="<?= $logo_image_path ?>">
            <span class="help-block">Inserire il percorso (relativo alla base del sito) dell'immagine da utilizzare come logo del sito (generalmente situata in <code>img/...</code>)</span>
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

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Utilizzo disco file temporanei</h3>
    </div>
    <div class="panel-body">
        <p>Usati <?= $current_temp_size ?> di <?= $current_temp_max_size ?>MiB</p>
        <div class="progress">
            <div class="progress-bar"
                 style="min-width: 2em; width: <?=$current_temp_size_percent ?>%;"><?= $current_temp_size_percent ?>%
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-limit-temp-folder" <?= $limit_temp_folder ? 'checked' : '' ?>>
                    &nbsp;Limita lo spazio per i file temporanei
                </label>
            </div>
            <span class="help-block">I file temporanei saranno eliminati quando lo spazio occupato supera il limite massimo (il servizio di manutenzione automatica deve essere abilitato)</span>
        </div>
        <div class="form-group">
            <label for="i-temp-folder-max-size">Dimensione massima dei file temporanei:</label>
            <input type="range" min="24" max="512" step="2" placeholder="Spazio da assegnare in MiB"
                   id="i-temp-folder-max-size" value="<?= $current_temp_max_size ?>">
            <span class="help-block">Scegliere lo spazio sui disco da assegnare ai file temporanei in MiB (<span
                    id="temp-current-max-size"><?= $current_temp_max_size ?></span>MiB)</span>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Servizio di manutenzione automatica</h3>
    </div>
    <div class="panel-body">
        <p>Il servizio di manutenzione viene eseguito automaticamente per eliminare file temporanei e assicurare il
            corretto funzionamento del sistema</p>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-enable-auto-maint" <?=$enable_automatic_maint ? 'checked' : '' ?>> &nbsp;Abilita il servizio di manutenzione automatica
                </label>
            </div>
        </div>
        <p>Per eseguire il servizio impostare una pianificazione che esegua lo script all'URL <code><?=base_url('services/maintenance/execute') ?></code> ogni settimana.
        Se il server non supporta <code>cron</code> o <code>Task Scheduler</code> è possibile utilizzare un sevizio esterno o il server di conversione documenti per impostare
        la pianificazione.</p>
    </div>
</div>
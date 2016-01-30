<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" id="i-enable-file-conversion" <?=$enable_file_conversion ? 'checked' : '' ?>> &nbsp;Attiva il servizio di conversione documenti
        </label>
    </div>
    <span class="help-block">Questo servzio è richiesto per l'importazione o l'esportazione di documenti non in formato HTML. Alcuni componenti aggiuntivi potrebbero richiedere questo servzio</span>
</div>

<div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" id="i-execute-on-remote" <?=$execute_on_remote ? 'checked' : '' ?>> &nbsp;Utilizza un server remoto al posto di quello locale per la conversione di documenti
        </label>
    </div>
    <span class="help-block">Utilizzare questa opzione solo se il server locale non supporta <code>pandoc</code> oppure non consente l'esecuzione di comandi shell da PHP</span>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Spazio di archiviazione</h3>
    </div>
    <div class="panel-body">
        <p>Usati <?= $current_used_size ?>MiB di <?= $output_folder_max_size ?>MiB</p>
        <div class="progress">
            <div class="progress-bar"
                 style="min-width: 2em; width: <?= $current_used_percent ?>%;"><?= $current_used_percent ?>%
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-limit-output-folder" <?= $limit_output_folder ? 'checked' : '' ?>>
                    &nbsp;Limita lo spazio per i file convertiti
                </label>
            </div>
            <span class="help-block">I file convertiti (inclusi i file zip scaricati da <i>File e immagini</i>) saranno eliminati quando lo spazio occupato supera il limite massimo (il servizio di manutenzione automatica deve essere abilitato)</span>
        </div>
        <div class="form-group">
            <label for="i-output-folder-max-size">Dimensione massima dei file convertiti:</label>
            <input type="range" min=24 max=2048 step="24" placeholder="Spazio da assegnare in MiB"
                   id="i-output-folder-max-size" value="<?= $output_folder_max_size ?>">
            <span class="help-block">Scegliere lo spazio sui disco da assegnare ai file convertiti in MiB (<span
                    id="output-current-max-size"><?= $output_folder_max_size ?></span>MiB)</span>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Impostazioni server remoto</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="i-remote-server-url">URL del server remoto:</label>
            <input type="text" class="form-control" id="i-remote-server-url" placeholder="Inserire l'url completo del server remoto" value="<?=$remote_server_url ?>">
            <span class="help-block">Inserire l'URL completo, che deve essere accessibile dall'interprete PHP. </span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-token">Token per il server remoto:</label>
            <input type="text" class="form-control" id="i-remote-server-token" placeholder="Inserire il token per il server remoto" value="<?=$remote_server_token ?>">
            <span class="help-block">Il token è generato dal server remoto e permette di identificare questo sito. Se il token non è corretto la connessione sarà rifutata dal server remoto</span>
        </div>
        <p>Il trasferimento sarà autenticato usando <code>HMAC-SHA256</code>. Questo non impedice a un utente mailintenzionato la lettura del documento, ma impedisce la modifica del documento con attacchi MITM.<br>
        Per una sicurezza migliore si consiglia di usare il protocollo <code>HTTPS (TLS 1.2)</code> per impedire l'intercettazione dei documenti.</p>
        <p>La chiave di autenticazione <code>HMAC-256</code> è impostabile nel database (<code>config->file_conversion->hmac_key</code>). Questa chiave è generata dal server e deve rimanaere segreta (non va inviata con mezzi insciuri come e-mail o chat).</p>
    </div>
</div>
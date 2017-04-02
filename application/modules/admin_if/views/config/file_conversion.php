<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" class="checkbox-sw"
                   id="i-enable-file-conversion" <?= $enable_file_conversion ? 'checked' : '' ?>> &nbsp;Attiva il
            servizio di conversione documenti
        </label>
    </div>
    <span class="help-block">Questo servzio è richiesto per l'importazione o l'esportazione di documenti non in formato HTML. Alcuni componenti aggiuntivi potrebbero richiedere questo servzio</span>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Esportazione documenti PDF</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw" id="i-enable-tcpdf" <?= $enable_tcpdf ? 'checked' : '' ?>> &nbsp;Abilita esportazione documenti PDF (via <code>TCPDF</code>)
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-pdf-header-title">Titolo dell'intestazione dei file PDF:</label>
            <input type="text" class="form-control" id="i-pdf-header-title" placeholder="Inserire il titolo" value="<?=$pdf_header_title ?>">
            <span class="help-block">Questo apparirà nell'intestazione su ogni pagina dei documenti PDF creati</span>
        </div>
        <div class="form-group">
            <label for="i-pdf-header-text">Testo esteso dell'intestazione dei file PDF:</label>
            <textarea class="form-control" rows="2" id="i-pdf-header-text" placeholder="Inserire il testo"><?=$pdf_header_text ?></textarea>
            <span class="help-block">Questo apparirà nell'intestazione su ogni pagina dei documenti PDF creati</span>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Conversione documenti tramite <code>pandoc</code></h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw" id="i-enable-pandoc" <?= $enable_pandoc ? 'checked' : '' ?>> &nbsp;Abilita conversione documenti tramite <code>pandoc</code>
                </label>
            </div>
            <span class="help-block"><code>pandoc</code> è necessario per l'importazione e l'esportazione di documenti di Microsoft Word e Open Document Text</span>
        </div>
        <?php if($local_pandoc): ?>
            <div class="alert alert-success"><i class="fa fa-check"></i> Installazione locale di <code>pandoc</code> disponibile.
            </div>
        <?php else: ?>
            <div class="alert alert-warning "><i class="fa fa-warning"></i> <b>Impossibile trovare una installazione di
                    <code>pandoc</code> locale</b>. Installare <code>pandoc</code> oppure utilizzare un server remoto per il servizio conversione documenti
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-execute-on-remote" <?= $pandoc_execute_on_remote ? 'checked' : '' ?>> &nbsp;Utilizza un server remoto
                    al posto di quello locale per la conversione di documenti
                </label>
            </div>
            <span class="help-block">Utilizzare questa opzione solo se il server locale non supporta <code>pandoc</code> oppure non consente l'esecuzione di comandi shell da PHP</span>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Impostazioni server remoto</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="i-remote-server-url">URL del server remoto:</label>
                    <input type="text" class="form-control" id="i-remote-server-url" placeholder="Inserire l'url completo del server remoto" value="<?=$pandoc_remote_server_url ?>">
                    <span class="help-block">Inserire l'URL completo, che deve essere accessibile dall'interprete PHP. </span>
                </div>
                <div class="form-group">
                    <label for="i-remote-server-token">Token per il server remoto:</label>
                    <input type="text" class="form-control" id="i-remote-server-token" placeholder="Inserire il token per il server remoto" value="<?=$pandoc_remote_server_token ?>">
                    <span class="help-block">Il token è generato dal server remoto e permette di identificare questo sito. Se il token non è corretto la connessione sarà rifutata dal server remoto</span>
                </div>
                <p>Il trasferimento sarà autenticato usando <code>HMAC-SHA256</code>. Questo non impedice a un utente mailintenzionato la lettura del documento, ma impedisce la modifica del documento con attacchi MITM.<br>
                    Per una sicurezza migliore si consiglia di usare il protocollo <code>HTTPS (TLS 1.2)</code> per impedire l'intercettazione dei documenti.</p>
                <p>La chiave di autenticazione <code>HMAC-SHA256</code> è generata dal server e deve rimanaere segreta (non va inviata con mezzi insciuri come e-mail o chat).</p>
                <button type="button" class="btn btn-default"><i class="fa fa-key"></i> Imposta chiave <code>HMAC-SHA256</code></button>
            </div>
        </div>

    </div>
</div>


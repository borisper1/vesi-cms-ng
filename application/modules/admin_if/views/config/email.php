<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Account mail (SMTP) per il sito</h3>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="i-remote-server-url">Hostname del server SMTP:</label>
            <input type="text" class="form-control" id="i-smtp-server-host"
                   placeholder="Inserire il nome/indirizzo ip del server SMTP" value="<?= $smtp_hostname ?>">
            <span class="help-block">L'indirizzo deve essere accessibile dall'interprete PHP. </span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Porta del server SMTP:</label>
            <input type="number" class="form-control" id="i-smtp-server-port"
                   placeholder="Inserire la porta del server SMTP" value="<?= $smtp_port ?>">
            <span class="help-block">La porta è comunemente 25 o 587 (per connessioni in chiaro) o 587 o 465 (per connessioni SSL/TLS) </span>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw" id="i-enable-smtp-ssl" <?= $smtp_ssl ? 'checked' : '' ?>>
                    &nbsp;Usa SSL/TLS per la connessione al server
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-enable-smtp-auth" <?= $smtp_auth ? 'checked' : '' ?>>
                    &nbsp;Usa autenticazione per SMTP
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Indirizzo e-mail:</label>
            <input type="email" class="form-control" id="i-smtp-address" placeholder="Inserire l'indirizzo e-mail"
                   value="<?= $smtp_address ?>">
            <span
                class="help-block">L'indirizzo e-mail dell'account che il sistema utilizzerà per accedere al server SMTP</span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Nome utente:</label>
            <input type="text" class="form-control" id="i-smtp-username" placeholder="Inserire il nome utente"
                   value="<?= $smtp_user ?>">
            <span
                class="help-block">Il nome utente dell'account che il sistema utilizzerà per accedere al server SMTP</span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Password:</label>
            <input type="password" class="form-control" id="i-smtp-password"
                   placeholder="Inserire la password se si desidera modificare la password memorizzata">
            <span class="help-block">La password dell'account che il sistema utilizzerà per accedere al server SMTP. La password sarà memorizzata in chiaro nel database dell'applicazione. <b>Inserire una password solo per cambiare la password memorizzata nel database</b></span>
        </div>
    </div>
</div>
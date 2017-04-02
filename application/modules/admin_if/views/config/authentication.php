<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" class="checkbox-sw" id="i-enable-frontend-auth" <?= $enable_frontend ? 'checked' : '' ?>>
            &nbsp;Abilita autenticazione per gli utenti del pubblico
        </label>
    </div>
    <span class="help-block">Permette l'autenticazione sul sito anche al di fuori dall'area amministrativa (può essere richiesto da alcuni componenti aggiuntivi).</i></span>
</div>

<div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" class="checkbox-sw" id="i-enable-ldap-auth" <?= $enable_ldap ? 'checked' : '' ?>>
            &nbsp;Abilita autenticazione tramite LDAP
        </label>
    </div>
    <span class="help-block">Permette di autenticare gli utenti con un sistema centralizzato che implementa il protocollo LDAP.</i></span>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Impostazioni autenticazione LDAP </h3>
    </div>
    <div class="panel-body">
        <div class="alert alert-warning">
            <i class="fa fa-warning"></i> <b>L'unica implementazione di LDAP completamente supportata è Active
                Directory</b>. L'integrazione potrebbe non funzionare con altro software.
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Hostname del server LDAP:</label>
            <input type="text" class="form-control" id="i-ldap-server-host"
                   placeholder="Inserire il nome/indirizzo IP del server LDAP" value="<?= $ldap_hostname ?>">
            <span class="help-block">L'indirizzo deve essere accessibile dall'interprete PHP. </span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Porta del server LDAP:</label>
            <input type="number" class="form-control" id="i-ldap-server-port"
                   placeholder="Inserire la porta del server LDAP" value="<?= $ldap_port ?>">
            <span class="help-block">La porta è comunemente 389 o 10389 (per connessioni in chiaro) o 636 (per connessioni SSL/TLS) </span>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw" id="i-enable-ldap-ssl" <?= $ldap_ssl ? 'checked' : '' ?>>
                    &nbsp;Usa connessione SSL/TLS (<code>ldaps://</code>)
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Nome utente:</label>
            <input type="text" class="form-control" id="i-ldap-username" placeholder="Inserire il nome utente"
                   value="<?= $ldap_user ?>">
            <span class="help-block">Il nome utente dell'account che il sistema utilizzerà per accedere al tree LDAP. Deve avere privilegi di lettura su tutta la directory</span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Password:</label>
            <input type="password" class="form-control" id="i-ldap-password"
                   placeholder="Inserire la password se si desidera modificare la password memorizzata">
            <span class="help-block">La password dell'account che il sistema utilizzerà per accedere al tree LDAP. La password sarà memorizzata in chiaro nel database dell'applicazione. <b>Inserire una password solo per cambiare la password memorizzata nel database</b></span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">DN di base:</label>
            <input type="text" class="form-control" id="i-ldap-base-dn" placeholder="Inserire il nome utente"
                   value="<?= $ldap_base_dn ?>">
            <span
                class="help-block">Il DN (distinguished name) di base da utilizzare per interrogare il server LDAP</span>
        </div>
        <br>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw"
                           id="i-ldap-sync-email" <?= $ldap_sync_email ? 'checked' : '' ?>>
                    &nbsp;Ottieni indirizzo e-mail tramite LDAP
                </label>
            </div>
            <span class="help-block">Permette di ottenere automaticamente gli indirizzi e-mail degli utenti da LDAP.
                Deselezionare se le informazioni nella directory non sono aggiornate</i></span>
        </div>
    </div>
</div>
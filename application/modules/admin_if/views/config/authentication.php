<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>


<div class="form-group">
    <div class="checkbox toggle">
        <label>
            <input type="checkbox" class="checkbox-sw" id="i-enable-ldap-auth" <?= '' ? 'checked' : '' ?>> &nbsp;Abilita
            autenticazione tramite LDAP
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
                Directory</b>. L'integrazione di gruppi e permessi non sarà disponibile con altre implementazioni.
        </div>
        <div class="form-group">
            <label>Tipo di server LDAP utilizzato:</label>
            <div class="radio">
                <label>
                    <input type="radio" name="ldap-type" id="i-ldap-type-ad" value="ad" checked>
                    Active Directory
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="ldap-type" id="i-ldap-type-std" value="std">
                    Sistema LDAP standard (OpenLDAP, Apache Directory Server,...)
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Hostname del server LDAP:</label>
            <input type="text" class="form-control" id="i-ldap-server-host"
                   placeholder="Inserire il nome/indirizzo ip del server LDAP" value="<?= '' ?>">
            <span class="help-block">L'indirizzo deve essere accessibile dall'interprete PHP. </span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Porta del server LDAP:</label>
            <input type="text" class="form-control" id="i-ldap-server-port"
                   placeholder="Inserire la porta del server LDAP" value="<?= '' ?>">
            <span class="help-block">La porta è comunemente 389 o 10389 (per connessioni in chiaro) o 636 (per connessioni SSL/TLS) </span>
        </div>
        <div class="form-group">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" class="checkbox-sw" id="i-enable-ldap-auth" <?= '' ? 'checked' : '' ?>>
                    &nbsp;Usa connessione SSL/TLS (<code>ldaps://</code>)
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Nome utente:</label>
            <input type="text" class="form-control" id="i-ldap-username" placeholder="Inserire il nome utente"
                   value="<?= '' ?>">
            <span class="help-block">Il nome utente dell'account che il sistema utilizzerà per accedere al tree LDAP. Deve avere privilegi di lettura su tutta la directory</span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">Password:</label>
            <input type="password" class="form-control" id="i-ldap-password"
                   placeholder="Inserire la password se si desidera modificare la password memorizzata"
                   value="<?= '' ?>">
            <span class="help-block">La password dell'account che il sistema utilizzerà per accedere al tree LDAP. La password sarà memorizzata in chiaro nel database dell'applicazione. <b>Inserire una password solo per cambiare la password memorizzata nel database</b></span>
        </div>
        <div class="form-group">
            <label for="i-remote-server-url">DN di base:</label>
            <input type="text" class="form-control" id="i-ldap-base-dn" placeholder="Inserire il nome utente"
                   value="<?= '' ?>">
            <span
                class="help-block">Il DN (distinguished name) di base da utilizzare per interrogare il server LDAP</span>
        </div>
    </div>
</div>
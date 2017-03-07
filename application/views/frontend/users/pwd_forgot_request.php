<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="panel panel-default" id="panel-request-pwd-reset">
        <div class="panel-heading">
            <h3 class="panel-title">Richiedi reset password</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-warning">
                <i class="fa fa-warning"></i> <b>Il recupero della password è disponibile solo per utenti che utilizzano autenticazione locale</b>
                Gli account con un nome utente che contiene <code>@[dominio]</code> utilizzano autenticazione LDAP. In questo caso contattare l'amministratore del sistema per
                il recupero delle credenziali
            </div>
            <div class="alert alert-danger hidden" id="pwdresetrequest-error-alert">
                <i class="fa fa-exclamation-circle"></i> <b>Impossibile richiedere il reset della password:</b> i campi non sono stati
                compilati o i dati inseriti non sono corretti
            </div>
            <div class="alert alert-info hidden" id="pwdresetrequest-spinner-alert">
                <i class="fa fa-refresh fa-spin"></i> Invio richiesta reset password...
            </div>
            <div class="form-group">
                <label for="i-username">Inserire il nome utente</label>
                <input type="text" class="form-control" id="i-username" placeholder="Nome utente">
            </div>
            <div class="form-group">
                <label for="i-username">Inserire l'indirizzo email associato all'utente</label>
                <input type="email" class="form-control" id="i-email" placeholder="Email">
            </div>
            <button type="button" class="btn btn-primary" id="request-password-reset"><i class="fa fa-bolt"></i> Richiedi reset password
            </button>
        </div>
    </div>
    <div class="panel panel-success hidden" id="panel-request-pwd-reset-ok">
        <div class="panel-heading">
            <h3 class="panel-title">Richiedi reset password</b></h3>
        </div>
        <div class="panel-body">
            <h4 class="text-success"><i class="fa fa-check"></i> La richiesta per il reset della password è stata accettata</h4>
            <p class="text-success">A breve riceverà un messaggio di posta elettronica che permetterà di scegliere una nuova password e accedere nuovamente al sito</p>
        </div>
    </div>
    <div class="panel panel-danger hidden" id="panel-request-pwd-reset-failed">
        <div class="panel-heading">
            <h3 class="panel-title">Richiedi reset password</h3>
        </div>
        <div class="panel-body">
            <h4 class="text-danger"><i class="fa fa-exclamation-circle"></i> Richiesta reset password rifiutata.</h4>
            <p class="text-danger">L'utente utilizza autenticazione LDAP oppure l'utente potrebbe aver già richiesto il reset della password, controllare la propria casella di posta elettronica. Per ulteriore assistenza
            contattare l'amministratore del sistema</p>
        </div>
    </div>
</div>

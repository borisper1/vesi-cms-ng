<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<span class="hidden" id="pchange-id"><?= $id ?></span>
<span class="hidden" id="pchange-token"><?= $token ?></span>
<div class="container">
    <div class="panel panel-default" id="panel-pwd-change">
        <div class="panel-heading">
            <h3 class="panel-title">Modifica password account: <b><?= $username ?></b></h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-danger hidden" id="pchange-error-alert">
                <i class="fa fa-exclamation-circle"></i> <b>Impossibile cambiare la password:</b> i campi non sono stati
                compilati o le password non corrispondono o non rispettano i requisiti di complessità
            </div>
            <div class="form-group">
                <label for="i-password">Inserire la nuova password</label>
                <input type="password" class="form-control" id="i-password" placeholder="Password">
                <span class="help-block">La password deve avere almeno 8 caratteri. <b>Si raccomanda di utilizzare una password complessa</b></span>
            </div>
            <div id="pwd-meter-container">
                <div class="progress">
                    <div id="pwd-meter-progress" class="progress-bar progress-bar-danger" role="progressbar" style="width: 0%">
                    </div>
                </div>
                <p class="text-danger pwd-meter-main-text" id="pwd-meter-short"><b>La password inserita è troppo corta</b></p>
                <p class="text-danger pwd-meter-main-text hidden" id="pwd-meter-1"><b>La password inserita è molto debole</b></p>
                <p class="text-warning pwd-meter-main-text hidden" id="pwd-meter-2"><b>La password inserita è debole</b></p>
                <p class="text-success pwd-meter-main-text hidden" id="pwd-meter-3">La password inserita è accettabile</p>
                <p class="text-success pwd-meter-main-text hidden" id="pwd-meter-4">La password inserita è sicura</p>
            </div>
            <div class="form-group">
                <label for="c-password">Confermare la nuova password</label>
                <input type="password" class="form-control" id="i-cpassword" placeholder="Conferma password">
            </div>

            <button type="button" class="btn btn-primary" id="execute-password-change"><i class="fa fa-bolt"></i> Cambia
                password
            </button>
        </div>
    </div>
    <div class="panel panel-success hidden" id="panel-pwd-change-ok">
        <div class="panel-heading">
            <h3 class="panel-title">Modifica password account: <b><?= $username ?></b></h3>
        </div>
        <div class="panel-body">
            <h4 class="text-success"><i class="fa fa-check"></i> Password modificata correttamente. E' possibile
                accedere con la nuova password</h4>
        </div>
    </div>
    <div class="panel panel-danger hidden" id="panel-pwd-change-failed">
        <div class="panel-heading">
            <h3 class="panel-title">Modifica password account: <b><?= $username ?></b></h3>
        </div>
        <div class="panel-body">
            <h4 class="text-danger"><i class="fa fa-exclamation-circle"></i> Si è verificato un errore durante la
                modifica della password.</h4>
            <p class="text-danger">Per riprovare sarà necessario richiedere nuovamente il reset della password</p>
        </div>
    </div>
</div>

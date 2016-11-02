<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Cambiamento password riuscito</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-danger hidden" id="pchange-error-alert">
                <i class="fa fa-exclamation-circle"></i> <b>Impossibile cambiare la password:</b> i campi non sono stati
                compilati o le password non corrispondono
            </div>
            <div class="form-group">
                <label for="i-password">Inserire la nuova password</label>
                <input type="password" class="form-control" id="i-password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="c-password">Confermare la nuova password</label>
                <input type="password" class="form-control" id="i-cpassword" placeholder="Conferma password">
            </div>
        </div>
    </div>
</div>
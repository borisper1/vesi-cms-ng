<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-wrench"></i> Modifica account utente</h1></div>
<div class="btn-group pull-right" id="users-actions">
    <button type="button" class="btn btn-success" id="save-edit-self"><i class="fa fa-save"></i> Salva modifiche</button>
</div>
<div class="clearfix"></div>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile salvare i cambiamenti:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Cambiamenti salvati con successo</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Salvatggio dei cambiamenti...</div>

<form class="form-horizontal">
    <div class="form-group">
        <label for="i-email" class="col-sm-3 control-label">Indirizzo email:</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" id="i-email" placeholder="Email" value="<?=$email ?>">
        </div>
    </div>

    <br>

    <div class="form-group">
        <label for="i-password" class="col-sm-3 control-label">Password:</label>
        <div class="col-sm-7">
            <span class="password-inline pull-left">••••••••••••</span>
            <button type="button" class="btn btn-default pull-right" id="change-pwd"><i class="fa fa-lock"></i> Cambia password</button>
        </div>
    </div>
    <br>
</form>

<div class="modal fade" id="users_change_password">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-lock"></i> Cambia password</h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger hidden" id="pchange-error-alert">
                    <i class="fa fa-exclamation-circle"></i> <b>Impossibile cambiare la password:</b> i campi non sono stati compilati o le password non corrispondono
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

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-ban"></i> Annulla</button>
                <button type="button" class="btn btn-primary" id="pchange-ok"><i class="fa fa-check"></i> OK</button>
            </div>
        </div>

    </div>
</div>
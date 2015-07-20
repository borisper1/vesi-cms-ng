<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica utente: <span id="username"><?=$username ?></span></h3>
<div class="btn-group pull-right" id="users-actions">
    <button type="button" class="btn btn-success" id="save-edit"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-danger" id="delete-user"><i class="fa fa-trash"></i> Elimina</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile modificare l'account:</b><br><span id="error-msg"></span></div>
<div class="alert alert-danger hidden" id="delete-error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare l'account:</b><br><span id="delete-error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Utente modificato con successo</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Modifica dell'utente...</div>

<form class="form-horizontal">
    <div class="form-group">
        <label for="i-fullname" class="col-sm-3 control-label">Nome completo:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="i-fullname" placeholder="Nome completo" value="<?=$fullname ?>">
        </div>
    </div>
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

    <div class="form-group">
        <label for="i-group" class="col-sm-3 control-label">Gruppo permessi:</label>
        <div class="col-sm-7">
            <select class="form-control" id="i-group">
                <?php foreach($groups as $group_i): ?>
                    <option value="<?=$group_i['name'] ?>" <?=$group_i['name']===$group ? 'selected': '' ?>><?=$group_i['fullname'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-activate" <?=$active===1 ? 'checked' : '' ?>> &nbsp;Attiva questo account
                </label>
            </div>
        </div>
    </div>
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
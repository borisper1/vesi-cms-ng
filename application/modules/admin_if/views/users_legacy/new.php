<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<h3 class="pull-left inline"><i class="fa fa-user-plus"></i> Nuovo utente</h3>
<div class="btn-group pull-right" id="users-actions">
    <button type="button" class="btn btn-success" id="save-new"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile creare l'account:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Utente creato con successo</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Creazione dell'utente...</div>
<form class="form-horizontal">
    <div class="form-group">
        <label for="i-username" class="col-sm-3 control-label">Nome utente:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="i-username" placeholder="Nome utente">
        </div>
    </div>
    <div class="form-group">
        <label for="i-fullname" class="col-sm-3 control-label">Nome completo:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="i-fullname" placeholder="Nome completo">
        </div>
    </div>
    <div class="form-group">
        <label for="i-email" class="col-sm-3 control-label">Indirizzo email:</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" id="i-email" placeholder="Email">
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="i-password" class="col-sm-3 control-label">Password:</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="i-password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <label for="i-cpaswword" class="col-sm-3 control-label">Conferma password:</label>
        <div class="col-sm-7">
            <input type="password" class="form-control" id="i-cpassword" placeholder="Conferma password">
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="i-group" class="col-sm-3 control-label">Gruppo permessi:</label>
        <div class="col-sm-7">
            <select class="form-control selectpicker" id="i-group">
                <option value="super-users"
                        data-content="<span class='label label-danger'>super-users</span> Gruppo per gli utenti con accesso completo al sistema">
                    super-users
                </option>
                <?php foreach ($groups as $group_i): ?>
                    <option
                        data-content="<span class='label label-info'><?= $group_i['name'] ?></span> <?= $group_i['description'] ?>"><?= $group_i['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-activate"> &nbsp;Attiva subito questo account
                </label>
            </div>
        </div>
    </div>
</form>

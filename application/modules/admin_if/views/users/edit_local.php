<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica utente: <span id="username"
                                                                                 data-type="local"><?= $username ?></span>
    <span class="label label-success"><i class="fa fa-database"></i> Locale</span>
</h3>
<div class="btn-group pull-right" id="users-actions">
    <button type="button" class="btn btn-success" id="save-edit"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-danger" id="delete-user"><i class="fa fa-trash"></i> Elimina</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<form class="form-horizontal">
    <div class="form-group">
        <label for="i-fullname" class="col-sm-3 control-label">Nome completo:</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="i-fullname" placeholder="Nome completo"
                   value="<?= $full_name ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="i-email" class="col-sm-3 control-label">Indirizzo email:</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" id="i-email" placeholder="Email" value="<?= $email ?>">
        </div>
    </div>
    <br>

    <div class="form-group">
        <label for="i-password" class="col-sm-3 control-label">Password:</label>
        <div class="col-sm-7">
            <span class="password-inline pull-left">••••••••••••</span>
            <div class="btn-group pull-right" id="users-actions">
                <button type="button" class="btn btn-default" id="change-pwd"><i class="fa fa-key"></i> Resetta password
                </button>
                <button type="button" class="btn btn-default" id="change-pwd"><i class="fa fa-lock"></i> Cambia password
                </button>
            </div>

        </div>
    </div>
    <br>

    <div class="form-group">
        <label for="i-group" class="col-sm-3 control-label">Gruppo permessi amministrativo:</label>
        <div class="col-sm-7">
            <span class="hidden" id="current-admin-group"><?= $admin_group == '' ? 'none' : $admin_group ?></span>
            <select class="form-control selectpicker" id="i-admin-group">
                <option value="none"
                        data-content="<span class='label label-warning'>nessun gruppo</span> Questo utente non è un amministratore">
                    none
                </option>
                <option value="super-users"
                        data-content="<span class='label label-danger'>super-users</span> Gruppo per gli utenti con accesso completo al sistema">
                    super-users
                </option>
                <?php foreach ($admin_groups as $group_i): ?>
                    <option
                        data-content="<span class='label label-info'><?= $group_i['name'] ?></span> <?= $group_i['description'] ?>"><?= $group_i['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="i-group" class="col-sm-3 control-label">Gruppo permessi pubblico:</label>
        <div class="col-sm-7">
            <span class="hidden"
                  id="current-frontend-group"><?= $frontend_group == '' ? 'none' : $frontend_group ?></span>
            <select class="form-control selectpicker" id="i-frontend-group">
                <option value="none"
                        data-content="<span class='label label-warning'>nessun gruppo</span> Questo utente non ha accesso pubblico">
                    none
                </option>
                <?php foreach ($frontend_groups as $group_i): ?>
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
                    <input type="checkbox" id="i-activate" class="auto-bswitch" <?= $active === 1 ? 'checked' : '' ?>>
                    &nbsp;Attiva questo account
                </label>
            </div>
        </div>
    </div>
</form>
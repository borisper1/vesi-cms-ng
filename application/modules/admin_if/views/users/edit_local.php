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

<?php if ($status == 2): ?>
    <div class="alert alert-info" id="user_locked">
        <p><i class="fa fa-info-circle"></i> <b>L'utente è stato bloccato a causa di troppi accessi falliti.</b>
            <button type="button" class="btn btn-info" id="unlock-account"><i class="fa fa-unlock"></i> Sblocca</button>
        </p>
    </div>
<?php endif; ?>


<div class="save-user-alert alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile
        modificare l'account:</b><br><span id="error-msg"></span></div>
<div class="save-user-alert alert alert-danger hidden" id="delete-error-alert"><i class="fa fa-exclamation-circle"></i>
    <b>Impossibile eliminare l'account:</b><br><span id="delete-error-msg"></span></div>
<div class="save-user-alert alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Utente modificato
    con successo
</div>
<div class="save-user-alert alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Modifica
    dell'utente...
</div>
<div class="save-user-alert alert alert-info hidden" id="pwd-reset-spinner"><i class="fa fa-refresh fa-spin"></i>
    Richiesta reset password...
</div>

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
    <div class="form-group">
        <label class="col-sm-3 control-label">Ultimo acceso:</label>
        <div class="col-sm-7">
            <span class="generic-inline pull-left"><?= date("H:i:s d/m/Y", strtotime($last_login)) ?></span>
        </div>
    </div>
    <br>

    <?php if ($pending_pwd_reset): ?>
        <div class="alert alert-warning" id="user_pwd_reset_pending">
            <p><i class="fa fa-warning"></i> <b>L'utente ha già richiesto il reset della password.</b>
                <button type="button" class="btn btn-warning" id="revoke-reset-request"><i class="fa fa-trash"></i>
                    Revoca richiesta
                </button>
            </p>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="i-password" class="col-sm-3 control-label">Password:</label>
        <div class="col-sm-7">
            <span class="password-inline pull-left">••••••••••••</span>
            <div class="btn-group pull-right" id="users-actions">
                <button type="button" class="btn btn-default"
                        id="reset-pwd" <?= $pending_pwd_reset ? 'disabled' : '' ?>><i class="fa fa-key"></i> Resetta
                    password
                </button>
                <button type="button" class="btn btn-default" id="change-pwd"><i class="fa fa-lock"></i> Cambia password
                </button>
            </div>

        </div>
    </div>
    <br>

    <div class="form-group">
        <label for="i-admin-group" class="col-sm-3 control-label">Gruppo permessi amministrativo:</label>
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
        <label for="i-frontend-group" class="col-sm-3 control-label">Gruppo permessi pubblico:</label>
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
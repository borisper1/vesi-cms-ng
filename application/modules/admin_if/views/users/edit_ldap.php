<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica utente: <span id="username"
                                                                                 data-type="ldap"><?= $username ?></span>
    <span class="label label-info"><i class="fa fa-server"></i> LDAP</span>
</h3>
<div class="btn-group pull-right" id="users-actions">
    <button type="button" class="btn btn-success" id="save-edit"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-danger" id="delete-user"><i class="fa fa-trash"></i> Elimina</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>

<?php if ($ldap_failed): ?>
    <div class="alert alert-danger" id="ldap-connect-failed-all">
        <i class="fa fa-exclamation-circle"></i> <b>Non è stato possibile connettersi a LDAP.</b><br>
        Controllare la configurazione dell'autenticazione LDAP. Il server LDAP potrebbe essere non disponibile
        oppure non si dispone delle autorizzazioni necessarie per accedere alla directory.<br>
        Questo errore potrebbe impedire l'accesso per gli utenti che usano autenticazione LDAP<br>
        <a href="<?= base_url('admin/edit' . $username) ?>" class="alert-link">Ricaricare</a> la pagina per riprovare
    </div>
<?php endif; ?>
<?php if ($ldap_user_deleted): ?>
    <div class="alert alert-danger" id="ldap-user-deleted">
        <i class="fa fa-exclamation-circle"></i> <b>L'utente è stato eliminato da LDAP.</b><br>
        Questo utente non è stato trovato nella directory LDAP. L'utente non funzionerà se non si ricrea l'utente in
        LDAP
    </div>
<?php endif; ?>
<?php if ($ldap_user_obsolete_sync): ?>
    <div class="alert alert-info" id="ldap-user-not-synced">
        <i class="fa fa-info-circle"></i> <b>L'utente non è stato sincronizzato recentemente con LDAP.</b><br>
        Le informazioni (Nome, Gruppi derivati da LDAP e indirizzo e-mail) sull'utente potrebbero essere inesatte.
        Sincronizzare l'account per aggiornare le informazioni
    </div>
<?php endif; ?>

<form class="form-horizontal">
    <div class="form-group">
        <label class="col-sm-3 control-label">Nome completo:</label>
        <div class="col-sm-7">
            <span class="password-inline pull-left"><?= $full_name ?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">Indirizzo email:</label>
        <div class="col-sm-7">
            <a class="password-inline pull-left" href="mailto:<?= $email ?>"><?= $email ?></a>
        </div>
    </div>
    <br>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-admin-local-group"
                           class="auto-bswitch" <?= $admin_group_from_ldap == false ? 'checked' : '' ?>> &nbsp;Sovrascrivi
                    gruppo amministrativo LDAP con gruppo locale
                </label>
            </div>
        </div>
    </div>
    <div class="form-group <?= $admin_group_from_ldap ? 'hidden' : '' ?>" id="admin-group-box">
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
        <div class="col-sm-offset-3 col-sm-7">
            <div class="checkbox toggle">
                <label>
                    <input type="checkbox" id="i-admin-frontend-group"
                           class="auto-bswitch" <?= $frontend_group_from_ldap == false ? 'checked' : '' ?>> &nbsp;Sovrascrivi
                    gruppo pubblico LDAP con gruppo locale
                </label>
            </div>
        </div>
    </div>
    <div class="form-group <?= $frontend_group_from_ldap ? 'hidden' : '' ?>" id="frontend-group-box">
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
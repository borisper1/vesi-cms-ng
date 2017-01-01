<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <?php if($type == 1): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Modifica utente LDAP: <code id="flag-username"><?=$this->session->username ?></code></h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info"><i class="fa fa-info-circle"></i> Questo utente è un utente che usa autenticazione via LDAP e non può essere modificato. Se i dati sono inesatti o si desidera cambiare la propria password contattare l'amministatore del sistema
                    <?php if($ldap_man_email): ?><br>E' comunque possibile modificare l'indirizzo email.<?php endif; ?>
                </div>
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
                            <a class="generic-inline pull-left" href="mailto:<?= $email ?>"><?= $email ?></a>&nbsp;
                            <?php if($ldap_man_email): ?>
                                <button type="button" class="btn btn-default pull-right" id="edit-profile-email"><i class="fa fa-edit"></i> Modifica email</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Gruppo permessi:</label>
                        <div class="col-sm-7">
                            <span class="generic-inline pull-left"><?= $frontend_group ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ultimo acceso:</label>
                        <div class="col-sm-7">
                            <span class="generic-inline pull-left"><?= date("H:i:s d/m/Y", strtotime($last_login)) ?></span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Modifica utente locale: <code id="flag-username"><?=$this->session->username ?></code></h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nome completo:</label>
                        <div class="col-sm-7">
                            <span class="password-inline pull-left"><?= $full_name ?></span>&nbsp;
                             <button type="button" class="btn btn-default pull-right" id="edit-profile-fullname"><i class="fa fa-edit"></i> Modifica nome completo</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Indirizzo email:</label>
                        <div class="col-sm-7">
                            <a class="generic-inline pull-left" href="mailto:<?= $email ?>" id="profile-local-email"><?= $email ?></a>&nbsp;
                             <button type="button" class="btn btn-default pull-right" id="edit-profile-email"><i class="fa fa-edit"></i> Modifica email</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Gruppo permessi:</label>
                        <div class="col-sm-7">
                            <span class="generic-inline pull-left"><?= $frontend_group ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Ultimo acceso:</label>
                        <div class="col-sm-7">
                            <span class="generic-inline pull-left"><?= date("H:i:s d/m/Y", strtotime($last_login)) ?></span>
                        </div>
                    </div>
                    <?php if ($pending_pwd_reset): ?>
                        <div class="alert alert-warning" id="user_pwd_reset_pending">
                            <p><i class="fa fa-warning"></i> <b>L'utente ha già richiesto il reset della password.</b> Se non si ha richiesto il reset della password contattare l'amministratore del sistema</p>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="i-password" class="col-sm-3 control-label">Password:</label>
                        <div class="col-sm-7">
                            <span class="password-inline pull-left">••••••••••••</span>
                            <button type="button" class="btn btn-default pull-right" id="reset-pwd" <?= $pending_pwd_reset ? 'disabled' : '' ?>><i class="fa fa-key"></i> Richiedi reset password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="users-profile-edit-email">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-edit"></i> Cambia indirizzo email</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="i-profile-email">Inserire il nuovo indirizzo email</label>
                    <input type="email" class="form-control" id="i-profile-email" placeholder="Email">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-ban"></i> Annulla</button>
                <button type="button" class="btn btn-primary" id="profile-edit-email-ok"><i class="fa fa-edit"></i> Modifica email</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="users-profile-edit-fullname">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-edit"></i> Cambia nome completo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="i-profile-fullname">Inserire il nuovo nome completo</label>
                    <input type="text" class="form-control" id="i-profile-fullname" placeholder="Nome completo">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-ban"></i> Annulla</button>
                <button type="button" class="btn btn-primary" id="profile-edit-fullname-ok"><i class="fa fa-edit"></i> Modifica nome completo</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reset-password-progress-modal" tabindex="-1" role="dialog" aria-labelledby="reset-password-progress-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="reset-password-progress-modal-label"><i class="fa fa-lg fa-key"></i> Reset della password</h4>
            </div>
            <div class="modal-body">
                <p>Invio richiesta reset password. Attendere...</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reset-password-ok-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-lg fa-key"></i> Reset della password</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-success"><i class="fa fa-check"></i> La richiesta per il reset della password è stata accettata</h4>
                <p class="text-success">A breve riceverà un messaggio di posta elettronica che permetterà di scegliere una nuova password</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-remove"></i> Chiudi</button>
            </div>
        </div>
    </div>
</div>
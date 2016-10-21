<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<div class="btn-group" role="group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#" id="new-admin-user"><i class="fa fa-fw fa-wrench"></i> Utente amministrativo</a></li>
        <li><a href="#" id="new-frontend-user"><i class="fa fa-fw fa-globe"></i> Utente pubblico</a></li>
    </ul>
</div>
<?php if ($ldap_enabled): ?>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-hourglass-end"></i> Sincronizza <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="new-admin-user"><i class="fa fa-fw fa-hourglass-half"></i> Sincronizza selezionati</a>
            </li>
            <li><a href="#" id="new-frontend-user"><i class="fa fa-fw fa-hourglass-start"></i> Sincronizza tutti</a>
            </li>
        </ul>
    </div>
<?php endif; ?>
<div class="btn-group hidden" id="users-actions">
    <button type="button" class="btn btn-default" id="enable-users"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-users"><span class="fa fa-ban"></span> Revoca</button>
    <button type="button" class="btn btn-danger" id="delete-users"><span class="fa fa-trash"></span> Elimina</button>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <i class="fa fa-wrench"></i> Gestisci <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="#" id="set-admin-local-group"><i class="fa fa-fw  fa-lock"></i> Assegna gruppo amministrativo
                    locale</a></li>
            <li><a href="#" id="set-frontend-local-group"><i class="fa-fw  fa fa-lock"></i> Assegna gruppo pubblico
                    locale</a></li>
            <?php if ($ldap_enabled): ?>
                <li><a href="#" id="set-admin-ldap-group"><i class="fa fa-fw  fa-plug"></i> Usa gruppo amministrativo
                        LDAP</a></li>
                <li><a href="#" id="set-frontend-ldap-group"><i class="fa fa-fw  fa-plug"></i> Usa gruppo pubblico LDAP</a>
                </li>
            <?php endif; ?>
            <li role="separator" class="divider"></li>
            <li><a href="#" id="password-reset"><i class="fa fa-fw fa-key"></i> Resetta password</a></li>
        </ul>
    </div>
</div>
<br><br>
<?php if ($ldap_failed): ?>
    <div class="alert alert-danger" id="ldap-connect-failed-all">
        <i class="fa fa-exclamation-circle"></i> <b>Non è stato possibile connettersi a LDAP.</b><br>
        Controllare la configurazione dell'autenticazione LDAP. Il server LDAP potrebbe essere non disponibile
        oppure non si dispone delle autorizzazioni necessarie per accedere alla directory.<br>
        Questo errore potrebbe impedire l'accesso per gli utenti che usano autenticazione LDAP<br>
        <a href="<?= base_url('admin/users') ?>" class="alert-link">Ricaricare</a> la pagina per riprovare
    </div>
<?php endif; ?>
<?php if ($ldap_leftovers): ?>
    <div class="alert alert-danger" id="ldap-connect-failed-all">
        <i class="fa fa-exclamation-circle"></i> <b>L'integrazione LDAP è disabilitata ma ci sono utenti che usano
            questo metodo di autenticazione</b><br>
        Questi utenti non potranno accedere al sistema. Se non si intende utilizzare l'autenticazione LDAP eliminare gli
        account che usano questo tipo di autenticazione.
    </div>
<?php endif; ?>
<?php if ($ldap_users_deleted): ?>
    <div class="alert alert-danger" id="ldap-user-deleted">
        <i class="fa fa-exclamation-circle"></i> <b>Alcuni utenti sono stati eliminati da LDAP.</b><br>
        Alcuni utenti registrati nel sito sono stati eliminati da LDAP. Eliminare gli utenti non necessari dal sito.
    </div>
<?php endif; ?>
<?php if ($ldap_users_obsolete_sync): ?>
    <div class="alert alert-info" id="ldap-user-not-synced">
        <i class="fa fa-info-circle"></i> <b>Alcuni utenti non sono stati sincronizzati recentemente con LDAP.</b><br>
        Le informazioni (Nome, Gruppi derivati da LDAP e indirizzo e-mail) sull'utente potrebbero essere inesatte.
        Sincronizzare gli
        account per aggiornare le informazioni
    </div>
<?php endif; ?>

<div id="ajax-cage">
    <?php if ($admin_users != []): ?>
        <div class="panel panel-primary container-block" id="panel-admin">
            <div class="panel-heading">
                <h3 class="panel-title"><a class="lmb panel-actuator"><i class="fa fa-chevron-right"></i></a> <i
                        class="fa fa-wrench"></i> Utenti amministratori</h3>
            </div>

            <table class="table hidden">
                <thead>
                <tr>
                    <th>Nome utente</th>
                    <th>Tipo autenticazione</th>
                    <th>Stato</th>
                    <th>Gruppo (amministrativo)</th>
                    <th>Gruppo (pubblico)</th>
                    <th>Nome utente</th>
                    <th>E-Mail</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($admin_users as $user): ?>
                    <tr class="user-element" data-username="<?= $user['username'] ?>"
                        data-enable="<?= $user['active'] ? 'true' : 'false' ?>">
                        <td>
                            <input type="checkbox" class="vcms-select-user" value="<?= $user['username'] ?>"> <a
                                href="<?= base_url('admin/users/edit/' . $user['username']) ?>"><?= $user['username'] ?></a>
                            <?php if ($user['ldap_error'] === 1): ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip"
                                   title="Impossibile connettersi a LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 2): ?>
                                <i class="fa fa-hourglass-end tooltipped" data-toggle="tooltip"
                                   title="L'utente non è stato sincronizzato recentemente con LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 3): ?>
                                <i class="fa fa-user-times tooltipped" data-toggle="tooltip"
                                   title="L'utente non esiste in LDAP"></i>
                            <?php endif; ?>
                            <?php if ($user['no_local_group']): ?>
                                <i class="fa fa-exclamation-circle tooltipped" data-toggle="tooltip"
                                   title="Nessun gruppo locale associato a questo utente"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['type'] === 0): ?>
                                <i class="fa fa-database"></i> Locale
                            <?php else: ?>
                                <i class="fa fa-server"></i> LDAP
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['status'] === 0): ?>
                                <i class="fa fa-ban"></i> Revocato
                            <?php elseif ($user['status'] === 1): ?>
                                <i class="fa fa-check"></i> Attivo
                            <?php else: ?>
                                <i class="fa fa-lock"></i> Bloccato
                            <?php endif; ?>
                        </td>
                        <td><?= $user['admin_group'] ?>
                            <?php if ($user['admin_group_from_ldap']): ?>
                                <i class="fa fa-plug tooltipped" data-toggle="tooltip"
                                   title="Gruppo derivato da gruppi LDAP"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['frontend_group'] ?>
                            <?php if ($user['frontend_group_from_ldap']): ?>
                                <i class="fa fa-plug tooltipped" data-toggle="tooltip"
                                   title="Gruppo derivato da gruppi LDAP"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['full_name'] ?></td>
                        <td><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($frontend_users != []): ?>
        <div class="panel panel-primary container-block" id="panel-clients">
            <div class="panel-heading">
                <h3 class="panel-title"><a class="lmb panel-actuator"><i class="fa fa-chevron-right"></i></a> <i
                        class="fa fa-globe"></i> Utenti pubblico</h3>
            </div>

            <table class="table hidden">
                <thead>
                <tr>
                    <th>Nome utente</th>
                    <th>Tipo autenticazione</th>
                    <th>Stato</th>
                    <th>Gruppo</th>
                    <th>Nome utente</th>
                    <th>E-Mail</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($frontend_users as $user): ?>
                    <tr class="user-element" data-username="<?= $user['username'] ?>"
                        data-enable="<?= $user['active'] ? 'true' : 'false' ?>">
                        <td>
                            <input type="checkbox" class="vcms-select-user" value="<?= $user['username'] ?>"> <a
                                href="<?= base_url('admin/users/edit/' . $user['username']) ?>"><?= $user['username'] ?></a>
                            <?php if ($user['ldap_error'] === 1): ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip"
                                   title="Impossibile connettersi a LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 2): ?>
                                <i class="fa fa-hourglass-end tooltipped" data-toggle="tooltip"
                                   title="L'utente non è stato sincronizzato recentemente con LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 3): ?>
                                <i class="fa fa-user-times tooltipped" data-toggle="tooltip"
                                   title="L'utente non esiste in LDAP"></i>
                            <?php endif; ?>
                            <?php if ($user['no_local_group']): ?>
                                <i class="fa fa-exclamation-circle tooltipped" data-toggle="tooltip"
                                   title="Nessun gruppo locale associato a questo utente"></i>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['type'] === 0): ?>
                                <i class="fa fa-database"></i> Locale
                            <?php else: ?>
                                <i class="fa fa-server"></i> LDAP
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['status'] === 0): ?>
                                <i class="fa fa-ban"></i> Revocato
                            <?php elseif ($user['status'] === 1): ?>
                                <i class="fa fa-check"></i> Attivo
                            <?php else: ?>
                                <i class="fa fa-lock"></i> Bloccato
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $user['frontend_group'] ?>
                            <?php if ($user['frontend_group_from_ldap']): ?>
                                <i class="fa fa-plug tooltipped" data-toggle="tooltip"
                                   title="Gruppo derivato da gruppi LDAP"></i>
                            <?php endif; ?>
                        </td>
                        <td><?= $user['full_name'] ?></td>
                        <td><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

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
<div class="btn-group hidden" id="users-actions">
    <button type="button" class="btn btn-default" id="enable-users"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-users"><span class="fa fa-ban"></span> Revoca</button>
    <button type="button" class="btn btn-danger" id="delete-users"><span class="fa fa-trash"></span> Elimina</button>
</div>
<br><br>
<div class="alert alert-danger" id="ldap-connect-failed-all">
    <i class="fa fa-exclamation-circle"></i> <b>Non è stato possibile connettersi a AD DS (LDAP).</b><br>
    Controllare la configurazione dell'autenticazione AD DS (LDAP). Il server AD dS potrebbe essere non disponibile
    oppure non si dispone delle autorizzazioni necessarie per accedere alla directory.<br>
    Questo errore potrebbe impedire l'accesso per gli utenti che usano autenticazione AD DS (LDAP)<br>
    <a href="<?= base_url('admin/users') ?>" class="alert-link">Ricaricare</a> la pagina per riprovare
</div>
<div class="alert alert-danger" id="ldap-user-deleted">
    <i class="fa fa-exclamation-circle"></i> <b>Alcuni utenti sono stati eliminati da AD DS.</b><br>
    Alcuni utenti registrati nel sito sono stati eliminati da AD DS. Eliminare gli utenti non necessari dal sito.
</div>
<div class="alert alert-info" id="ldap-user-not-synched">
    <i class="fa fa-info-circle"></i> <b>Alcuni utenti non sono stati sincronizzati recentemente con AD DS.</b><br>
    Le informazioni (Nome, Gruppi AD DS e indirizzo e-mail) sull'utente potrebbero essere inesatte. Sincronizzare gli
    account per aggiornare le informazioni
</div>
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
                                href="<?= base_url('admin/users_legacy/edit/' . $user['username']) ?>"><?= $user['username'] ?></a>
                            <?php if ($user['ldap_failed']): ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip"
                                   title="Impossibile connettersi a LDAP"></i>
                            <?php elseif ($user['ldap_outdated']): ?>
                                <i class="fa fa-hourglass tooltipped" data-toggle="tooltip"
                                   title="L'utente non è stato sincronizzato recentemente con LDAP"></i>
                            <?php elseif ($user['ldap_removed']): ?>
                                <i class="fa fa-hourglass tooltipped" data-toggle="tooltip"
                                   title="L'utente non esiste in LDAP"></i>
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
                        <td><?= $user['group-admin'] ?></td>
                        <td><?= $user['group-frontend'] ?></td>
                        <td><?= $user['fullname'] ?></td>
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
                        <td><input type="checkbox" class="vcms-select-user" value="<?= $user['username'] ?>"> <a
                                href="<?= base_url('admin/users_legacy/edit/' . $user['username']) ?>"><?= $user['username'] ?></a>
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
                        <td><?= $user['group-frontend'] ?></td>
                        <td><?= $user['fullname'] ?></td>
                        <td><a href="mailto:<?= $user['email'] ?>"><?= $user['email'] ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

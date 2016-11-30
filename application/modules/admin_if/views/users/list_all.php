<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<div class="btn-group" role="group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#" id="new-local-user"><i class="fa fa-fw fa-database"></i> Utente locale</a></li>
        <li <?= $ldap_enabled ? '' : 'class="disabled"' ?>><a href="#" id="new-LDAP-user"><i
                    class="fa fa-fw fa-server"></i> Utente LDAP</a></li>
    </ul>
</div>
<div class="btn-group hidden" id="users-actions">
    <button type="button" class="btn btn-default" id="enable-users"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-users"><span class="fa fa-ban"></span> Revoca</button>
    <button type="button" class="btn btn-danger" id="delete-users"><span class="fa fa-trash"></span> Elimina</button>
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

<div class="save-user-alert alert alert-info hidden" id="new-user-spinner"><i class="fa fa-refresh fa-spin"></i>
    Creazione nuovo utente...
</div>
<div class="alert alert-success alert-dismissible hidden" id="new-user-success-alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Utente <i><span id="new-user-name"></span></i> creato con successo. Per visualizzare
    l'account nella lista aggiornare la pagina
</div>
<div class="alert alert-danger alert-dismissible hidden" id="new-user-failure-alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Impossibile creare l'account <i><span id="new-user-name"></span></i>.
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
                                href="<?= base_url('admin/users/edit/' . rawurlencode($user['username'])) ?>"><?= $user['username'] ?></a>
                            <?php if ($user['ldap_error'] === 1): ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip"
                                   title="Impossibile connettersi a LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 2): ?>
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
                                href="<?= base_url('admin/users/edit/' . rawurlencode($user['username'])) ?>"><?= $user['username'] ?></a>
                            <?php if ($user['ldap_error'] === 1): ?>
                                <i class="fa fa-exclamation-triangle tooltipped" data-toggle="tooltip"
                                   title="Impossibile connettersi a LDAP"></i>
                            <?php elseif ($user['ldap_error'] === 2): ?>
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

<div class="modal fade" id="new-local-user-modal" tabindex="-1" role="dialog" aria-labelledby="new-local-user-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-local-user-label"><i class="fa fa-plus"></i> Crea nuovo utente locale
                </h4>
            </div>

            <div class="modal-body">
                <div class="alert alert-danger hidden" id="local-error-alert">
                    <i class="fa fa-exclamation-circle"></i> <b>Impossibile creare l'utente locale:</b> i campi non sono
                    stati
                    compilati correttamente.
                </div>
                <p class="text-warning"><i class="fa fa-warning"></i> Attenzione: non sarà possibile modificare il nome
                    utente in seguito</p>
                <div class="form-group">
                    <label for="i-local-username">Inserire il nome utente per il nuovo utente</label>
                    <input type="text" class="form-control" id="i-local-username" placeholder="Nome utente">
                    <span class="help-block">Non può contenere spazi</span>
                </div>
                <div class="form-group">
                    <label for="i-local-fullname">Inserire il nome completo dell'utente</label>
                    <input type="text" class="form-control" id="i-local-fullname" placeholder="Nome completo">
                </div>
                <div class="form-group">
                    <label for="i-local-email">Inserire l'indirizzo e-mail dell'utente</label>
                    <input type="email" class="form-control" id="i-local-email" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <label>Metodo di inserimento password:</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="local-pwd-mode" id="i-local-pwd-mode-email" value="email" checked>
                            Richiedi una password via e-mail
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="local-pwd-mode" id="i-local-pwd-mode-none" value="none">
                            Non inserire una password ora, sarà possibile inserire una password nell'editor utente
                        </label>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-success" id="new-local-user-modal-confirm"><i
                        class="fa fa-plus"></i> Crea utente
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione utenti
                </h4>
            </div>
            <div class="modal-body">
                <p>Gli utenti selezionati verranno eliminati e non potranno più accedere al sistema.</p>
                <p>L'eliminazione è una operazione definitiva. Eliminare questi utenti?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i
                            class="fa fa-trash"></i> Elimina
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-ldap-user-modal" tabindex="-1" role="dialog" aria-labelledby="new-ldap-user-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-ldap-user-label"><i class="fa fa-plus"></i> Crea nuovo utente LDAP
                </h4>
            </div>

            <div class="modal-body">
                <div id="ldap-new-user-start">
                    <button type="button" class="btn btn-primary btn-block" id="but-ldap-new-user-search">Cerca un utente nella directory LDAP
                    </button>
                    <button type="button" class="btn btn-primary btn-block" id="but-ldap-new-user-from-group">Associa tutti gli utenti appartententi ad un
                        gruppo
                    </button>
                    <button type="button" class="btn btn-default btn-block" id="but-ldap-new-user-manual-bind">Associa un utente effettuando il login (<i>bind
                            manuale</i>)
                    </button>
                </div>
                <div id="ldap-new-user-search" class="hidden">
                    <div class="form-group">
                        <label for="i-ldap-user-query">Inserire il nome utente da cercare</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="i-ldap-user-query" placeholder="Nome utente">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Cerca</button>
                            </span>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Risultati ricerca</h3>
                        </div>
                        <div class="panel-body">
                            Nessuna ricerca effettuata
                        </div>
                    </div>
                </div>
                <div id="ldap-new-user-from-group" class="hidden">
                    <div class="form-group">
                        <label for="i-ldap-from-group">Scegli il gruppo LDAP da cui associare gli utenti (DN
                            completo)</label>
                        <select class="form-control selectpicker" id="i-ldap-from-group">
                            <option data-hidden="true">Seleziona un gruppo</option>
                            <?php foreach ($ldap_groups as $group_i): ?>
                                <option data-content="<?= $group_i['cn'] ?> <span class='label label-default'><?= $group_i['dn'] ?></span> "><?= $group_i['dn'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Utenti da associare</h3>
                        </div>
                        <div class="panel-body">
                            Nessun gruppo selezionato
                        </div>
                    </div>
                </div>
                <div id="ldap-new-user-manual-bind" class="hidden">
                    <div class="alert alert-warning">
                        <i class="fa fa-warning"></i> Associare gli account tramite bind manuale porebbe creare account
                        invalidi.
                        Si raccomanda di utilizzare gli altri metodi per creare account LDAP.
                    </div>
                    <div class="form-group">
                        <label for="i-ldap-bind-username">Inserire il nome utente per l'accesso LDAP</label>
                        <input type="text" class="form-control" id="i-ldap-bind-username" placeholder="Nome utente">
                    </div>
                    <div class="form-group">
                        <label for="i-ldap-bind-password">Inserire la password per l'accesso LDAP</label>
                        <input type="password" class="form-control" id="i-ldap-bind-password" placeholder="Password">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-success hidden" id="new-ldap-user-modal-confirm"><i
                            class="fa fa-plus"></i> Crea utente
                </button>
            </div>
        </div>
    </div>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-lock"></i> Gruppi e permessi</h1></div>
<span id="page-mode" class="hidden">list</span>
<div class="btn-group" role="group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="fa fa-plus"></i> Nuovo <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="<?= base_url('admin/groups/edit_admin/new') ?>" id="new-admin-group"><i
                    class="fa fa-fw fa-wrench"></i> Gruppo amministrativo</a></li>
        <li><a href="<?= base_url('admin/groups/edit_frontend/new') ?>" id="new-frontend-group"><i
                    class="fa fa-fw fa-globe"></i> Gruppo pubblico</a></li>
    </ul>
</div>
<div class="btn-group hidden" id="group-actions">
    <button type="button" class="btn btn-default" id="enable-groups"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-groups"><span class="fa fa-ban"></span> Blocca</button>
    <button type="button" class="btn btn-danger" id="delete-groups"><span class="fa fa-trash"></span> Elimina</button>
</div>
<br>
<br>
<div class="panel panel-primary container-block" id="panel-admin">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-wrench"></i> Gruppi amministratori</h3>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Stato</th>
            <th>Permessi</th>
            <th>Utenti a cui si applica</th>
            <?php if ($ldap_enabled): ?>
                <th>Gruppi LDAP a cui si applica</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="label label-danger">super-users</span></td>
            <td>Gruppo per gli utenti con accesso completo al sistema</td>
            <td><i class="fa fa-check"></i> Attivo</td>
            <td>Accesso completo</td>
            <td>
                <?php foreach ($admin_super_users as $user): ?>
                    <span class="label label-default"><?= $user ?></span>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php foreach ($admin_groups as $group): ?>
            <tr>
                <td><input type="checkbox" class="vcms-select-group" value="<?= $group['name'] ?>" data-type="admin"> <a
                        href="<?= base_url('admin/groups/edit_admin/' . $group['name']) ?>"><?= $group['name'] ?></a>
                </td>
                <td><?= $group['description'] ?></td>
                <td><?= $group['active'] ? "<i class=\"fa fa-check\"></i> Attivo" : "<i class=\"fa fa-ban\"></i> Revocato" ?></td>
                <td>
                    <?php foreach ($group['permissions'] as $perm): ?>
                        <span class="label label-info"><?= $perm ?></span>
                    <?php endforeach; ?>
                </td>
                <td class="group-members">
                    <?php foreach ($group['users'] as $user): ?>
                        <span class="label label-default"><?= $user ?></span>
                    <?php endforeach; ?>
                </td>
                <?php if ($ldap_enabled): ?>
                    <td>
                        <?php foreach ($group['ldap_groups'] as $ldg): ?>
                            <span class="label label-default"><?= $ldg ?></span>
                        <?php endforeach; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="panel panel-primary container-block" id="panel-frontend">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-globe"></i> Gruppi pubblico</h3>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Stato</th>
            <th>Permessi</th>
            <th>Utenti a cui si applica</th>
            <?php if ($ldap_enabled): ?>
                <th>Gruppi LDAP a cui si applica</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="label label-danger">super-users</span></td>
            <td>Gruppo per gli utenti con accesso completo al sistema</td>
            <td><i class="fa fa-check"></i> Attivo</td>
            <td>Accesso completo</td>
            <td>
                <?php foreach ($frontend_super_users as $user): ?>
                    <span class="label label-default"><?=$user ?></span>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php foreach ($frontend_groups as $group): ?>
            <tr>
                <td><input type="checkbox" class="vcms-select-group" value="<?= $group['name'] ?>" data-type="frontend">
                    <a href="<?= base_url('admin/groups/edit_frontend/' . $group['name']) ?>"><?= $group['name'] ?></a>
					<?php if ($psk_enabled && $group['enable_psk_authentication'] && $group['psk_key_set']): ?>
						<i class="fa fa-key tooltipped" title="Accesso con chiave precondivisa abilitato"></i>
					<?php endif; ?>
                </td>
                <td><?=$group['description'] ?></td>
                <td><?= $group['active'] ? "<i class=\"fa fa-check\"></i> Attivo" : "<i class=\"fa fa-ban\"></i> Revocato" ?></td>
                <td>
                    <?php foreach ($group['permissions'] as $perm): ?>
                       <span class="label label-info"><?= $perm ?></span>
                    <?php endforeach; ?>
                </td>
                <td class="group-members">
                    <?php foreach($group['users'] as $user): ?>
                        <span class="label label-default"><?=$user ?></span>
                    <?php endforeach; ?>
                </td>
                <?php if ($ldap_enabled): ?>
                    <td>
                        <?php foreach ($group['ldap_groups'] as $ldg): ?>
                            <span class="label label-default"><?= $ldg ?></span>
                        <?php endforeach; ?>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione gruppi
                </h4>
            </div>
            <div class="modal-body">
                <p>Eliminando i gruppi selezionati gli utenti associati a qui gruppi non potranno più accedere al sistema.</p>
                <div id="users-remaining" class="hidden">
                    <p class="text-danger">Ci sono ancora utenti associati ai gruppi selezionati per l'elimiazione.
                    <br>Gli utenti <span id="users-remaining-list"></span> non saranno più in grado di accedere al sistema</p>
                </div>
                <p>L'eliminazione è una operazione definitiva. Eliminare questi gruppi?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina</button>
            </div>
        </div>
    </div>
</div>
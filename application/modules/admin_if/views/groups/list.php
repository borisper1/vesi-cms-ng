<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-lock"></i> Gruppi e permessi</h1></div>
<button type="button" class="btn btn-success" id="new-group"><i class="fa fa-plus"></i> Nuovo gruppo</button>
<div class="btn-group hidden" id="group-actions">
    <button type="button" class="btn btn-default" id="enable-groups"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-groups"><span class="fa fa-ban"></span> Blocca</button>
    <button type="button" class="btn btn-danger" id="delete-groups"><span class="fa fa-trash"></span> Elimina</button>
</div>
<br>
<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrizione</th>
            <th>Stato</th>
            <th>Permessi</th>
            <th>Utenti a cui si applica</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="label label-danger">super-users</span></td>
            <td>Gruppo per gli utenti con accesso completo al sistema</td>
            <td><i class="fa fa-check"></i> Attivo</td>
            <td>Accesso completo</td>
            <td>
                <?php foreach($super_users as $user): ?>
                    <span class="label label-default"><?=$user ?></span>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php foreach($groups as $group): ?>
            <tr>
                <td><input type="checkbox" class="vcms-select-group" value="<?=$group['name'] ?>"> <a href="<?=base_url('admin/groups/edit/'.$group['name']) ?>"><?=$group['name'] ?></a></td>
                <td><?=$group['description'] ?></td>
                <td><?=$group['active'] ? "<i class=\"fa fa-check\"></i> Attivo" : "<i class=\"fa fa-ban\"></i> Bloccato" ?></td>
                <td><?=$group['permissions'] ?></td>
                <td>
                    <?php foreach($group['users'] as $user): ?>
                        <span class="label label-default"><?=$user ?></span>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
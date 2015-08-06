<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-users"></i> Account utente</h1></div>
<button type="button" class="btn btn-success" id="new-user"><span class="fa fa-plus"></span> Nuovo</button>
<div class="btn-group hidden" id="users-actions">
    <button type="button" class="btn btn-default" id="enable-users"><span class="fa fa-check"></span> Attiva</button>
    <button type="button" class="btn btn-default" id="disable-users"><span class="fa fa-ban"></span> Revoca</button>
    <button type="button" class="btn btn-danger" id="delete-users"><span class="fa fa-remove"></span> Elimina</button>
</div>
<br><br>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Utente</th>
        <th>Stato</th>
        <th>Gruppo</th>
        <th>Nome completo</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($userlist as $user): ?>
            <tr>
                <td><input type="checkbox" class="vcms-select-user" value="<?=$user['username'] ?>"> <a href="<?=base_url('admin/users/edit/'.$user['username']) ?>"><?=$user['username'] ?></a></td>
                <td>
                    <?php if($user['status']===0): ?>
                        <i class="fa fa-ban"></i> Revocato
                    <?php elseif($user['status']===1): ?>
                        <i class="fa fa-check"></i> Attivo
                    <?php else: ?>
                        <i class="fa fa-lock"></i> Bloccato
                    <?php endif; ?>
                </td>
                <td><?=$user['group'] ?></td>
                <td><?=$user['fullname'] ?></td>
                <td><a href="mailto:<?=$user['email'] ?>"><?=$user['email'] ?></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
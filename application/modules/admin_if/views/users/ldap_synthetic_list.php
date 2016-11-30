<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<table class="table">
    <thead>
    <tr><th>Nome utente</th><th>Nome completo</th><th>Email</th><th>Gruppi</th></tr>
    </thead>
    <tbody>
    <?php foreach($users as $user): ?>
        <tr>
            <td><input type="checkbox" class="vcms-select-ldap-user" value="<?= $user['username'] ?>"><?= $user['username'] ?></td>
            <td><?= $user['full_name'] ?></td>
            <td><?= $user['username'] ?></td>
            <td>
                <?php foreach($user['groups'] as $group): ?>
                    <span class="label label-default"><?= $group ?></span>&nbsp;
                <?php endforeach; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-lock"></i> Gruppi e permessi</h1></div>
<div class="btn-group" id="list-actions">
    <button type="button" class="btn btn-success" id="new-group"><i class="fa fa-plus"></i> Nuovo gruppo</button>
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
            <td>super-users</td>
            <td>Gruppo per gli utenti con accesso completo al sistema.</td>
            <td><i class="fa fa-check"></i> Attivo</td>
            <td>Accesso completo</td>
            <td>
                <?php foreach($super_users as $user): ?>
                    <span class="label label-default"><?=$user ?></span>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php foreach($groups as $group): ?>

        <?php endforeach; ?>
    </tbody>
</table>
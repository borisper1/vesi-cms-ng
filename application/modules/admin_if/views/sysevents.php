<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-bell"></i> Avvisi di sistema</h1></div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-default" id="mark-read"><i class="fa fa-bell-slash"></i> Segna tutti come letti</button>
    <button type="button" class="btn btn-default" id="delete-all"><i class="fa fa-trash"></i> Elimina tutti gli eventi</button>
</div>
<table class="table">
    <thead>
        <tr><th>Evento</th><th>Severità</th><th>Origine</th><th>Descrizione</th><th>Data e ora</th></tr>
    </thead>
    <tbody>
        <?php foreach($events as $event): ?>
            <tr class="<?=$event['severity_bclass'] ?>">
                <td><?=$event['new'] ? '<i class="fa fa-asterisk"></i><b>' : '' ?> <?=$event['summary'] ?><?=$event['new'] ? '</b>' : '' ?></td>
                <td><span class="label label-<?=$event['severity_bclass'] ?>"><?=$event['severity'] ?></span></td>
                <td><?=$event['origin'] ?></td>
                <td><?=$event['message'] ?></td>
                <td><?=$event['date'] ?></td>
            <tr>
        <?php endforeach; ?>
    </tbody>
</table>
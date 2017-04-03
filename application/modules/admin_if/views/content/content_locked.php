<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header">
    <h1><i class="fa fa-cubes"></i> Gestione contenuti
        <button type="button" class="btn btn-default pull-right launch-contextual-help tooltipped" title="Aiuto"
                data-help_path="contents::editors::<?= $type ?>"><i class="fa fa-question-circle"></i></button>
    </h1>
</div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-preview"><?= $preview ?></span>
    <small><span class="label label-info"><span id="f-type"><?= $type ?></span> <i class="fa fa-ellipsis-v"></i> <span
                    id="f-id"><?= $id ?></span></span></small>
</h3>
<div class="btn-group pull-right" id="content-actions">
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-waringing"></i> Contenuto <code><?= $id ?></code> bloccato</h3>
    </div>
    <div class="panel-body">
        <p>L'utente <i><?= $editing_user ?></i> sta modificando il contenuto. Il contenuto verrà sbloccato in automatico
            quando l'utente ha terminato le modifiche</p>
    </div>
</div>
<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header">
    <h1><i class="fa fa-file"></i> Pagine
        <button type="button" class="btn btn-default pull-right launch-contextual-help tooltipped" title="Aiuto"
                data-help_path="pages::edit"><i class="fa fa-question-circle"></i></button>
    </h1>
</div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> <span id="f-title"><?= $title ?></span> <i
            class="fa fa-lock tooltipped <?= $restrict_access ? '' : 'hidden' ?>" id="restricted-access-icon"
            title="Accesso ristretto"></i>
    <small>
        <span class="label label-info"><span id="f-container"><?=$container ?></span> <i class="fa fa-ellipsis-v"></i>
        <span id="f-page-name"><?=$page_name ?></span></span> <span class="label label-default" id="f-id"><?=$id ?></span>
    </small>
</h3>
<div class="btn-group pull-right" id="page-actions">
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-waringing"></i> Pagina <code><?= $id ?></code> bloccata</h3>
    </div>
    <div class="panel-body">
        <p>L'utente <i><?= $editing_user ?></i> sta modificando la pagina. La pagina verrà sbloccata in automatico
            quando l'utente ha terminato le modifiche</p>
    </div>
</div>
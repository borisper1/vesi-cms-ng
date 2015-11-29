<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-lock"></i> Gruppi e permessi</h1></div>
<h3 class="pull-left inline"><i class="fa fa-pencil"></i> Modifica gruppo: <span id="group-name"><?=$group_name ?></span></h3>
<div class="btn-group pull-right" id="group-actions">
    <button type="button" class="btn btn-default" id="save-edit"><i class="fa fa-save"></i> Salva</button>
    <button type="button" class="btn btn-default" id="edit-code"><i class="fa fa-code"></i> Modifica JSON</button>
    <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i> Aggiorna</button>
    <button type="button" class="btn btn-default" id="close-edit"><i class="fa fa-remove"></i> Chiudi</button>
</div>
<div class="clearfix"></div>
<br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile modificare il gruppo:</b><br><span id="error-msg"></span></div>
<div class="alert alert-success hidden" id="success-alert"><i class="fa fa-check"></i> Gruppo modificato con successo</div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Modifica del gruppo...</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Permessi delle interfacce amministrativi</h3>
    </div>
    <div class="panel-body">
        <p>Selezionare le interfacce amministrative a cui questo gruppo di utenti potrà accedere (alcune interfacce sono riservate al gruppo <span class="label label-danger">super-users</span>).</p>
        <?php foreach($permission_groups as $permission_group): ?>
            <h3><i class="fa <?=$permission_group['icon'] ?>"></i> <?=$permission_group['label'] ?></h3>
            <p><?=$permission_group['description'] ?></p>
            <?php foreach($permission_group['items'] as $item): ?>
                <?php if($item['name']!=='special::separator'): ?>
                    <div class="permission-block">
                        <i class="fa <?=$item['icon'] ?> fa-lg fa-fw"></i> <input type="checkbox" class="select-permission-items" value="<?=$item['name'] ?>"> <b><?=$item['label'] ?></b> <span class="label label-default"><?=$item['name'] ?></span> <?=$item['description'] ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
        <?php endforeach; ?>
    </div>
</div>

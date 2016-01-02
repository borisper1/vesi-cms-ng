<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-bullhorn"></i> Gestione avvisi</h1></div>
<div class="btn-group" id="list-actions">
    <button type="button" class="btn btn-success" id="new-content"><i class="fa fa-plus"></i> Nuovo avviso</button>
</div>
<br>
<br>
<div class="alert alert-danger alert-dismissible hidden" id="alert-deletion-error">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare l'avviso:</b> errore del server
</div>
<div class="alert alert-success alert-dismissible hidden" id="alert-deletion-success">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Avviso eliminato con successo
</div>
<div class="alert alert-info hidden" id="alert-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione dell'avviso selezionato...</div>

<table class="table table-hover">
    <thead>
    <tr>
        <th>Avviso</th>
        <th>Mostra in (pagine)</th>
        <th>id</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($alerts_list as $alert): ?>
        <tr class="content-row">
            <td>
                <span class="label label-<?=$alert['type'] ?>"><?=$alert['type'] ?></span>
                <?php if($alert['dismissible']): ?>
                    <span class="label label-default tooltipped" data-toggle="tooltip" title="Avviso che può essere chiuso dall'utente">[D]</span>
                <?php endif; ?>
                <a href="<?=base_url('admin/alerts/edit/'.$alert['id']) ?>"><?=$alert['preview'] ?></a>
                <a href="#" class="delete-alert lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i class="fa fa-trash"></i></a>
            </td>
            <td>
                <?php if($alert['rules']=='all'): ?>
                    <span class="label label-info">tutte [all]</span>
                <?php else: ?>
                    <?php $i=0; ?>
                    <?php foreach($alert['rules'] as $rule): ?>
                        <?php if($i >0): ?>
                            <i class="fa fa-plus-square"></i>
                        <?php endif; ?>
                        <span class="label label-success"><?=$rule['container'] ?> <i class="fa fa-ellipsis-v"></i> <?=$rule['name'] ?></span>
                        <?php $i=1 ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
            <td class="f-id"><?=$alert['id'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione avviso</h4>
            </div>
            <div class="modal-body">
                L'eliminazione è una operazione definitiva. Eliminare questo avviso?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina</button>
            </div>
        </div>
    </div>
</div>
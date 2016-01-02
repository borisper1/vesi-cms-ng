<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-cubes"></i> Gestione contenuti</h1></div>
<div class="btn-group" id="list-actions">
    <button type="button" class="btn btn-success" id="new-content"><i class="fa fa-plus"></i> Nuovo contenuto</button>
</div>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default" id="show-all"><i class="fa fa-eye"></i> Mostra tutto</button>
    <button type="button" class="btn btn-default" id="show-orphans"><i class="fa fa-crosshairs"></i> Mostra solo orfani</button>
</div>
<br>
<br>
<div class="alert alert-danger alert-dismissible hidden content-alert" id="content-deletion-error">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare il contenuto:</b> errore del server
</div>
<div class="alert alert-success alert-dismissible hidden content-alert" id="content-deletion-success">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Contenuto eliminato con successo
</div>
<div class="alert alert-info hidden content-alert" id="content-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione del contenuto selezionato...</div>
<?php
    if($cfilter_on){
        $this->load->view('administration/notify_cfilter_on');
    }
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>Contenuto</th>
        <th>Usato da</th>
        <th>id</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($content_list as $content): ?>
        <tr class="content-row">
            <td>
                <span class="label label-default f-type"><?=$content['type'] ?></span>
                <a href="<?=base_url('admin/contents/edit/'.$content['id']) ?>"><?=$content['preview'] ?></a>
                <a href="#" class="delete-content lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i class="fa fa-trash"></i></a>
            </td>
            <td>
                <?php $i=0; ?>
                <?php foreach($content['usages'] as $usage): ?>
                    <?php if($i >0): ?>
                        <i class="fa fa-plus-square"></i>
                    <?php endif; ?>
                    <span class="label label-success"><?=$usage['container'] ?> <i class="fa fa-ellipsis-v"></i> <?=$usage['name'] ?></span>
                    <?php $i=1 ?>
                <?php endforeach; ?>
                <?php if($i < 1): ?>
                    <span class="label label-warning">contenuto orfano</span>
                <?php endif; ?>
            </td>
            <td class="f-id"><?=$content['id'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione contenuto</h4>
            </div>
            <div class="modal-body">
                L'eliminazione è una operazione definitiva. Eliminare questo contenuto?
                <br>Tutte le pagine che integrano questo contenuto visualizzeranno un errore.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i class="fa fa-trash"></i> Elimina</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-modal" tabindex="-1" role="dialog" aria-labelledby="new-modal-label" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="new-modal-label"><i class="fa fa-lg fa-plus"></i> Nuovo contenuto</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label" for="i-page-layout"> Scegliere il tipo di contenuto da creare</label>
                    <select class="selectpicker form-control" id="i-content-type">
                        <?php foreach($components_list as $component): ?>
                            <option data-content="<span class='label label-default'><?=$component['name'] ?></span>  <?=$component['description'] ?>"><?=$component['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla</button>
                <button type="button" class="btn btn-success" id="new-modal-confirm" data-dismiss="modal"><i class="fa fa-bolt"></i> Crea contenuto</button>
            </div>
        </div>
    </div>
</div>
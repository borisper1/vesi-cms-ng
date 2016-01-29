<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-copy"></i> Circolari</h1></div>
<h3 class="pull-left inline"><i class="fa fa-clone"></i> Categoria: <span id="f-category"><?= $category ?></span></h3>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-success" id="new-circolare-flist"><i class="fa fa-plus"></i> Nuova circolare
    </button>
    <button type="button" class="btn btn-default" id="go-back-index"><i class="fa fa-chevron-left"></i> Torna all'elenco
    </button>
</div>
<br>
<br>
<div class="alert alert-danger alert-dismissible hidden" id="circolare-deletion-error">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare la circolare:</b> errore del server
</div>
<div class="alert alert-success alert-dismissible hidden" id="circolare-deletion-success">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Circolare eliminata con successo
</div>
<div class="alert alert-info hidden" id="circolare-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione
    della circolare selezionata...
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Circolare</th>
        <th>Anteprima</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($list as $circolare): ?>
        <tr>
            <td>
                <i class="fa fa-file-o"></i>
                <a href="<?= base_url('admin/circolari_engine/edit/' . $circolare['id']) ?>"><?= $circolare['number'] . $circolare['suffix'] ?> &mdash; <?= $circolare['title'] ?></a>
                <span class="label label-info f-id"><?= $circolare['id'] ?></span>
                <a class="delete-article lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i
                        class="fa fa-trash"></i></a>
            </td>
            <td><?= $circolare['preview'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione circolare
                </h4>
            </div>
            <div class="modal-body">
                Se si eliminano tutte le circolari la categoria verrà eliminata automaticamente.<br>
                L'eliminazione è una operazione definitiva. Eliminare questa circolare?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm" data-dismiss="modal"><i
                        class="fa fa-trash"></i> Elimina
                </button>
            </div>
        </div>
    </div>
</div>
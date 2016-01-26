<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-copy"></i> Circolari</h1></div>
<div class="btn-group spaced">
    <button type="button" class="btn btn-success" id="new-circolare-fcat"><i class="fa fa-plus"></i> Nuova circolare
    </button>
</div>
<br>
<div class="alert alert-danger alert-dismissible hidden" id="circolare-deletion-error">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare la categoria:</b> errore del server
</div>
<div class="alert alert-success alert-dismissible hidden" id="circolare-deletion-success">
    <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
    <i class="fa fa-check"></i> Categoria eliminata con successo
</div>
<div class="alert alert-info hidden" id="circolare-deletion-spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione
    della categoria selezionata...
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Categoria</th>
        <th>Articoli</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td>
                <i class="fa fa-copy"></i> <a class="f-name"
                                              href="<?= base_url('admin/circolari_engine/list_cats/' . $category['name']) ?>"><?= $category['name'] ?></a>
                <a class="delete-category lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i
                        class="fa fa-trash"></i></a>
            </td>
            <td><?= $category['articles'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<datalist id="category-list">
    <?php foreach ($categories as $category): ?>
    <option value="<?= $category['name'] ?>">
        <?php endforeach; ?>
</datalist>

<div class="modal fade" id="delete-cat-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-trash"></i> Eliminazione categoria
                </h4>
            </div>
            <div class="modal-body">
                Verranno eliminate tutte le circolari contenute in questa categoria. Si consiglia di eseguire un backup
                delle circolari prima di continuare.<br>
                L'eliminazione è una operazione definitiva. Eliminare questa categoria?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-danger" id="delete-cat-modal-confirm" data-dismiss="modal"><i
                        class="fa fa-trash"></i> Elimina
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="new-circolare-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="delete-modal-label"><i class="fa fa-lg fa-plus"></i> Nuova
                    circolare/categoria</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="i-category">Scegliere la categoria in cui creare la circolare</label>
                    <input type="text" class="form-control" id="i-category" placeholder="Categoria"
                           list="category-list">
                    <span class="help-block">Per creare una nuova categoria digitare il nome della categoria da creare. Il nome non deve contenere spazi e deve essere composto solo da lettere minuscole e numeri</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i> Annulla
                </button>
                <button type="button" class="btn btn-success" id="new-circolare-modal-confirm" data-dismiss="modal"><i
                        class="fa fa-plus"></i> Crea circolare
                </button>
            </div>
        </div>
    </div>
</div>
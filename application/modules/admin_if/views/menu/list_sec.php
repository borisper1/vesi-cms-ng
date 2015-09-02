<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-list"></i> Menu secondari</h1></div>
<button type="button" class="btn btn-success" id="new-menu"><span class="fa fa-plus"></span> Nuovo</button>
<br><br>
<div class="alert alert-danger hidden" id="error-alert"><i class="fa fa-exclamation-circle"></i> <b>Impossibile eliminare il menu:</b><br><span id="error-msg"></span></div>
<div class="alert alert-info hidden" id="spinner"><i class="fa fa-refresh fa-spin"></i> Eliminazione del menu...</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Menu</th>
        <th>Mostra titolo</th>
        <th>id</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($menulist as $menu): ?>
        <tr>
            <td>
                <a href="<?=base_url('admin/sec_menu/edit/'.$menu['id']) ?>"><?=$menu['title'] ?></a>
                <a class='delete-menu lmb pull-right tooltipped' data-toggle='tooltip' title='Elimina' data-id="<?=$menu['id'] ?>"><i class='fa fa-trash'></i></a>
            </td>
            <td><span class="label label-info"><?=$menu['display_title'] ? 'sì' : 'no' ?></span></td>
            <td><?=$menu['id'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class='modal fade' id='delete-modal' tabindex='-1' role='dialog' aria-labelledby='delete-modal-label' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title' id='delete-modal-label'>Eliminazione menu</h4>
            </div>
            <div class='modal-body'>
                L'eliminazione è una operazione definitiva. Eliminare questo menu?
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Annulla</button>
                <button type='button' class='btn btn-danger' id='delete-modal-confirm' data-dismiss='modal'>Elimina</button>
            </div>
        </div>
    </div>
</div>
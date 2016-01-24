<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-copy"></i> Circolari</h1></div>
<h3 class="pull-left inline"><i class="fa fa-clone"></i> Categoria: <span id="f-category"><?=$category ?></span></h3>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-success" id="new-circolare"><i class="fa fa-plus"></i> Nuova circolare</button>
    <button type="button" class="btn btn-default" id="go-back-index"><i class="fa fa-chevron-left"></i> Torna all'elenco</button>
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
                <a href="<?= base_url('admin/circolari_engine/edit/' . $circolare['id']) ?>"><?= $circolare['number'].$circolare['suffix'] ?> &mdash; <?= $circolare['title'] ?></a>
                <span class="label label-info"><?=$circolare['id'] ?></span>
                <a class="delete-article lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i class="fa fa-trash"></i></a>
            </td>
            <td><?= $circolare['preview'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


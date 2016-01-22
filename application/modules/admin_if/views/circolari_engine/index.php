<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header"><h1><i class="fa fa-copy"></i> Circolari</h1></div>
<div class="btn-group">
    <button type="button" class="btn btn-success" id="new-circolare"><i class="fa fa-plus"></i> Nuova circolare</button>
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
                <i class="fa fa-copy"></i> <a
                    href="<?= base_url('admin/circolari_engine/list_cats/' . $category['name']) ?>"><?= $category['name'] ?></a>
                <a class="delete-category lmbnc pull-right tooltipped" data-toggle="tooltip" title="Elimina"><i
                        class="fa fa-trash"></i></a>
            </td>
            <td><?= $category['articles'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


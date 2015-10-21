<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="page-header"><h1><i class="fa fa-cubes"></i> Gestione contenuti</h1></div>
<div class="btn-group" id="list-actions">
    <button type="button" class="btn btn-success" id="new-content"><i class="fa fa-plus"></i> Nuovo contenuto</button>
</div>
<div class="btn-group pull-right">
    <button type="button" class="btn btn-default" id="show-all"><i class="fa fa-eye"></i> Mostra tutto</button>
    <button type="button" class="btn btn-default" id="show-orphans"><i class="fa fa-crosshairs"></i> Mostra solo orfani</button>
</div>
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
                <a class='delete-content lmbnc pull-right tooltipped' data-toggle='tooltip' title='Elimina'><i class='fa fa-trash'></i></a>
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
            <td><?=$content['id'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
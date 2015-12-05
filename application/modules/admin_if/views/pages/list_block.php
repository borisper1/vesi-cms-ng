<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="panel panel-primary container-block" id="panel-<?=$container ?>" data-container="<?=$container ?>">
    <div class="panel-heading">
        <h3 class="panel-title"><a class="lmb panel-actuator"><i class="fa fa-chevron-right"></i></a> <?=$container ?></h3>
    </div>

    <table class="table hidden">
        <thead>
            <tr><th>Titolo</th><th>Nome sistema</th><th>Layout</th><th>Tags</th></tr>
        </thead>
        <tbody>
            <?php foreach($pages as $page): ?>
                <tr class="page-element" data-redirect="<?=($page['container_redirect']!='') ? 'true' : 'false' ?>" data-id="<?=$page['id'] ?>" data-home="<?=$page['home'] ? 'true' : 'false' ?>">

                    <?php if($page['container_redirect']!=''): ?>
                        <td>
                            <?=$page['home'] ? '<i class="fa fa-home"></i>' : '' ?> <i class="fa fa-exchange"></i> <i><?=$page['title'] ?></i>
                            <a class='remove-redirect lmbnc pull-right tooltipped' title='Elimina'><i class='fa fa-remove'></i></a>
                            <a class='edit-redirect lmbnc pull-right tooltipped' title='Modifica reindirizzamento'><i class='fa fa-edit'></i></a>
                        </td>
                        <td><span class="label label-default tooltipped" title="Id: <?=$page['id'] ?>"><?= $page['name'] ?></span> <i class="fa fa-exchange"></i> <span class="label label-info"><span class="f-target"><?=$page['container_redirect'] ?></span> <i class="fa fa-ellipsis-v"></i> <span class="f-name"><?=$page['name'] ?></span></span></td>
                        <td>Reindirizzamento</td>
                    <?php else: ?>
                        <td>
                            <?=$page['home'] ? '<i class="fa fa-home"></i>' : '<i class="fa fa-file-o"></i>' ?> <a href="<?=base_url('admin/pages/edit/'.$page['id']) ?>"><?=$page['title'] ?></a>
                            <a class='remove-page lmbnc pull-right tooltipped' title='Elimina'><i class='fa fa-remove'></i></a>
                            <?php if(!$page['home'] and !$cfilter_status): ?>
                                <a class='set-home lmbnc pull-right tooltipped' title='Imposta come pagina iniziale'><i class='fa fa-home'></i></a>
                            <?php endif; ?>
                        </td>
                        <td><span class="label label-default tooltipped" title="Id: <?=$page['id'] ?>"><?= $page['name'] ?></span></td>
                        <td><?=$page['layout'] ?></td>
                    <?php endif; ?>
                    <td>
                        <span class="tag-container">
                            <?php foreach(explode(',', $page['tags']) as $tag): ?>
                                <span class="label label-info page-tag"><?=$tag ?></span>
                            <?php endforeach; ?>
                        </span>
                        <a class='edit-tags lmbnc pull-right tooltipped' title='Modifica tags'><i class='fa fa-tags'></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
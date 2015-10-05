<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><li>
    <div class="panel panel-default content-symbol">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-sort"></i> <span class="f-type label label-info"><?=$type ?></span> <span class="f-id label label-default"><?=$id ?></span> <span class="f-preview"><?=$preview ?></span>
                <?php if(!$exists): ?>
                    <i class="fa fa-exclamation-triangle tooltipped" title="Contenuto inesistente"></i>
                <?php endif; ?>
                <a class='remove-content lmb pull-right tooltipped' data-toggle='tooltip' title='Dissocia'><i class='fa fa-unlink'></i></a>
                <a class='edit-content lmb pull-right tooltipped' data-toggle='tooltip' title='Modifica'><i class='fa fa-edit'></i></a>
            </h3>
        </div>
    </div>
</li>
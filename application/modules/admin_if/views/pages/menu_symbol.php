<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><li>
    <div class="panel panel-primary menu-symbol">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-sort"></i> <span class="label label-info">menu secondario</span> <span class="f-id label label-default"><?=$id ?></span> <span class="f-title"><?=$title ?></span>
                <?php if(!$exists): ?>
                    <i class="fa fa-exclamation-triangle tooltipped" title="Menu inesistente"></i>
                <?php endif; ?>
                <a class='remove-menu lmb pull-right tooltipped' data-toggle='tooltip' title='Dissocia'><i class='fa fa-unlink'></i></a>
            </h3>
        </div>
    </div>
</li>
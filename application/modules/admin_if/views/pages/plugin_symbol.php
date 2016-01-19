<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li>
    <div class="panel panel-primary plugin-symbol">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-sort"></i> <span class="label label-info">componente aggiuntivo</span> <span
                    class="f-name label label-default"><?= $name ?></span> <span class="f-title"><?= $title ?></span>
                <span class="f-command label label-info"><?= $command ?></span>
                <?php if (!$exists): ?>
                    <i class="fa fa-exclamation-triangle tooltipped" title="Plugin inesistente"></i>
                <?php endif; ?>
                <a class="remove-plugin lmb pull-right tooltipped" data-toggle="tooltip" title="Dissocia"><i
                        class="fa fa-unlink"></i></a>
                <a class="edit-plugin-command lmb pull-right tooltipped" data-toggle="tooltip" title="Modifica comando"><i
                        class="fa fa-terminal"></i></a>
            </h3>
        </div>
    </div>
</li>
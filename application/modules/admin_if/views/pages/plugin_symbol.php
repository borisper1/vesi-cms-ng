<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li>
    <div class="panel panel-primary plugin-symbol" data-plugindata="<?= $data ?>">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-sort"></i> <span class="label label-info">plugin</span> <span
                    class="f-name label label-default"><?= $name ?></span> <span class="f-title"><?= $title ?></span>
                <?php if (!$exists): ?>
                    <i class="fa fa-exclamation-triangle tooltipped" title="Plugin inesistente"></i>
                <?php endif; ?>
                <a class="remove-plugin lmb pull-right tooltipped" data-toggle="tooltip" title="Dissocia"><i
                        class="fa fa-unlink"></i></a>
                <a class="edit-plugin-data lmb pull-right tooltipped" data-toggle="tooltip" title="Modifica dati"><i
                        class="fa fa-database"></i></a>
            </h3>
        </div>
    </div>
</li>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="structure_tabs-block">

    <ul class="nav nav-tabs" role="tablist">
        <?php $active = true; ?>
        <?php foreach($structure_data as $view_data): ?>
            <li role="presentation" <?= $active ? "class=\"active\"" : ""?>><a href="#<?=$view_data['id']?>" aria-controls="<?=$view_data['id']?>" role="tab" data-toggle="tab"><?=$view_data['title']?></a></li>
            <?php $active = false; ?>
        <?php endforeach ?>
    </ul>

    <div class="tab-content">
        <?php $active = true; ?>
        <?php foreach($structure_data as $view_data): ?>
            <div role="tabpanel" class="tab-pane<?= $active ? " active" : ""?>" id="<?=$view_data['id']?>">
                <?=$view_data['content']?>
            </div>
            <?php $active = false; ?>
        <?php endforeach ?>
    </div>

</div>
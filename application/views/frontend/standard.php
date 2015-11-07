<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="<?=$container_class ?>">
    <?=$alerts ?>

    <?php if($title!=""): ?>
        <div class="page-header">
            <h1><?=$title ?></h1>
        </div>
    <?php endif; ?>

    <?=$content ?>
</div>
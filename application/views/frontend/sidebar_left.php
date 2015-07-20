<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="<?=$container_class ?>">
    <?php if($title!=""): ?>
        <div class="page-header">
            <h1><?=$title ?></h1>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-3">
            <?=$content ?>
        </div>
        <div class="col-md-9">
            <?=$sidebar_content ?>
        </div>
    </div>
</div>
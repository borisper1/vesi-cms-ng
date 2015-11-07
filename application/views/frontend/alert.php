<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="alert alert-<?=$type ?> <?=$dismissible ? 'alert-dismissible' : '' ?>" role="alert" id="<?=$id ?>">
    <?php if($dismissible): ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php endif; ?>
    <?=$content ?>
</div>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!$dismissable):?>
    <button type="button" class="btn popover-trigger <?= $class ?>" data-html="true" data-placement="<?= $placement ?>"
            data-toggle="popover" title="<?= strip_tags($title) ?>"
            data-content="<?= $content ?>"><?= strip_tags($name) ?></button>
<?php else: ?>
    <a tabindex="0" class="btn popover-trigger <?= $class ?>" role="button" data-html="true"
       data-placement="<?= $placement ?>" data-toggle="popover" data-trigger="focus" title="<?= strip_tags($title) ?>"
       data-content="<?= $content ?>"><?= strip_tags($name) ?></a>
<?php endif; ?>

<?php if($linebreak):?>
<br>
<?php endif; ?>
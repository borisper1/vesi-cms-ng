<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!$dismissable):?>
    <button type="button" class="btn <?=$class?>" data-html="<?=$html?>" data-placement="<?=$placement?>" data-toggle="popover" title="<?=$title?>" data-content="<?=$content?>"><?=$name?></button>
<?php else: ?>
    <a tabindex="0" class="btn <?=$class?>" role="button" data-html="<?=$html?>" data-placement="<?=$placement?>" data-toggle="popover" data-trigger="focus" title="<?=$title?>" data-content="<?=$content?>"><?=$name?></a>
<?php endif; ?>

<?php if($linebreak):?>
<br>
<?php endif; ?>
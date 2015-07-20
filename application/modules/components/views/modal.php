<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><button class="btn <?=$trigger_class?>" data-toggle="modal" data-target="#<?=$id?>"><?=$title?></button>
<div class="modal fade" id="<?=$id?>" tabindex="-1" role="dialog" aria-labelledby="<?=$id?>-l" aria-hidden="true">
    <div class="modal-dialog <?=$large ? 'modal-lg' : '' ?>"><div class="modal-content">
            <div class="modal-header">
                <?php if($close): ?>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Chiudi</span></button>
                <?php endif; ?>
                <h4 class="modal-title" id="<?=$id?>-l"><?=$title?></h4>
            </div>
            <div class="modal-body">
                <?=$content?>
            </div>
        </div>
    </div>
</div>
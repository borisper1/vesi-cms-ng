<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="structure_collapse-block">
    <?php $a_id=uniqid(); ?>
    <div class="panel-group" id="<?=$a_id?>" role="tablist" aria-multiselectable="true">

        <?php $in = true;?>
        <?php foreach($structure_data as $view_data): ?>

            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="<?=$view_data['id']?>-l">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#<?=$a_id?>" href="#<?=$view_data['id']?>" aria-expanded="true" aria-controls="<?=$view_data['id']?>">
                            <?=$view_data['title']?>
                        </a>
                    </h4>
                </div>
                <div id="<?=$view_data['id']?>" class="panel-collapse collapse <?= $in ? " in" : ""?>" role="tabpanel" aria-labelledby="<?=$view_data['id']?>-l">
                    <div class="panel-body">
                        <?=$view_data['content']?>
                    </div>
                </div>
            </div>
            <?php $in = false; ?>
        <?php endforeach ?>

    </div>
</div>
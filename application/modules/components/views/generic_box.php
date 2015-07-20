<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="structure_generic-box">

    <?php foreach($structure_data as $view_data): ?>
        <div class='panel <?=$class?>'>
            <div class='panel-heading'>
                <h3 class='panel-title'><?=$view_data['title']?></h3>
            </div>
            <div class='panel-body'>
                <?=$view_data['content']?>
            </div>
        </div>
    <?php endforeach ?>

</div>
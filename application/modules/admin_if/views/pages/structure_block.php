<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><li>
    <div class="panel panel-primary structure-block" data-type="<?=$type ?>">
        <div class="panel-heading">
            <h3 class="panel-title">
                <?php if($type==='tabs-block'): ?>
                    <i class="fa fa-clone"></i> Vista a schede multiple
                <?php elseif($type==='collapse-block'): ?>
                    <i class="fa fa-bars"></i> Vista a pannelli multipli
                <?php endif; ?>
                <a class='new-view lmb pull-right tooltipped' title='Aggiungi scheda/pannello'><i class='fa fa-plus'></i></a>
                <a class='remove-block lmb pull-right tooltipped' title='Elimina'><i class='fa fa-remove'></i></a>
            </h3>
        </div>
        <div class="panel-body">
            <ul class="sortable sortable-views">
                <?=$views_rendered ?>
            </ul>
        </div>
    </div>
</li>
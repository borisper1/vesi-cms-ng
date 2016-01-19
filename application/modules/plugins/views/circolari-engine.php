<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-3" id="main-list">
        <ul class="fa-ul" id="circolari-list">
            <?php foreach ($circolari as $circolare): ?>
                <li><i class="fa-li fa fa-file-o"></i><a href="#<?= $id ?>" class="circolari-link"
                                                         data-id="<?= $id ?>"><?= $number ?> &mdash; <?= $title ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-9" id="main-content">
        <div class="alert alert-info" role="alert"><i class="fa fa-info-circle"></i> Scegliere una circolare per
            visualizzarla
        </div>
    </div>
</div>
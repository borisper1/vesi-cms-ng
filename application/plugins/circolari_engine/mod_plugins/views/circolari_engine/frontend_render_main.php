<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
    .circolari-active {
        pointer-events: none;
        color: #1F1F1B;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-3" id="main-list">
        <ul class="fa-ul" id="circolari-list">
            <?php foreach ($list as $circolare): ?>
                <li><i class="fa-li fa fa-file-o"></i><a href="#<?= $circolare['id'] ?>" class="circolari-link"
                                                         data-id="<?= $circolare['id'] ?>"><?= $circolare['number'] . $circolare['suffix'] ?> &mdash; <?= $circolare['title'] ?></a>
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
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="panel <?= $class ?>">
    <div class="panel-heading">
        <h3 class="panel-title"><?= strip_tags($title) ?></h3>
</div>
    <div class="panel-body">
<ul>
    <?php foreach ($list as $article): ?>
        <li><a href="<?= $article['link_to'] ?>"><?= strip_tags($article['full_title']) ?></a></li>
    <?php endforeach; ?>
</ul>
</div>
</div>
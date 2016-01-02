<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><ol class="breadcrumb path-indicator" id="file-manager-path-indicator">
    <?php foreach($segments as $segment): ?>
        <?php if(!$segment['active']): ?>
            <li><a href="#" data-path="<?=$segment['path'] ?>" class="file-manager-path-indicator-link"><?=$segment['name'] ?></a></li>
        <?php else: ?>
            <li class="active"><?=$segment['name'] ?></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ol>
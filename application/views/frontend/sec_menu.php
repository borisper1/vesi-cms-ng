<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="structure_sec-menu" role="navigation">
    <?php if($display_title): ?>
        <h3><?=$title ?></h3>
    <?php endif; ?>
    <ul class="nav nav-pills nav-stacked">
        <?php foreach($main_menu as $menu): ?>
            <?php if($menu['type']==='dropdown'): ?>
                <li role="presentation" class="dropdown <?=$menu['active'] ? 'active' : '' ?>">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?=$menu['title']?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach($menu['items'] as $item): ?>
                            <li role="presentation" <?=$item['active'] ? 'class=\"active\"' : '' ?>><a role="menuitem" tabindex="-1" href="<?=$item['link']?>"><?=$item['title']?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php else: ?>
                <li role="presentation" class="<?=$menu['active'] ? 'active' : '' ?>"><a href="<?=$menu['link'] ?>"><?=$menu['title'] ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

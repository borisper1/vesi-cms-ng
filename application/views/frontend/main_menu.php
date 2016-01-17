<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><div class="navbar navbar-<?=$class ?> navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url($logo_image_path); ?>"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li <?=$home_active ? 'class=\"active\"' : '' ?>><a href="<?=base_url();?>"><i class="fa fa-home fa-lg"></i></a></li>
                <?php foreach($main_menu as $menu): ?>
                    <?php if($menu['type']==='dropdown'): ?>
                        <li class="dropdown <?=$menu['active'] ? 'active' : '' ?>">
                            <a id="menu_<?=$menu['container']?>" href="#" role="button" class="dropdown-toggle dropdown-hover" data-toggle="dropdown"><?=$menu['title']?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="menu_<?=$menu['container']?>">
                                <?php foreach($menu['items'] as $item): ?>
                                    <li role="presentation" <?=$item['active'] ? 'class=\"active\"' : '' ?>><a role="menuitem" tabindex="-1" href="<?=$item['link']?>"><?=$item['title']?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="<?=$menu['active'] ? 'active' : '' ?>"><a href="<?=$menu['link'] ?>"><?=$menu['title'] ?></a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

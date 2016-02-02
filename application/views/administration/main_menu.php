<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu_collapse" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url('admin')?>">Vesi-CMS 1.2</a>
        </div>

        <div class="collapse navbar-collapse" id="main_menu_collapse">
            <ul class="nav navbar-nav">
                <?php foreach($structure as $instance): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa <?=$instance['icon'] ?>"></i> <?=$instance['label'] ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach($instance['items'] as $voice): ?>
                                <?php if($voice==='separator'): ?>
                                    <li role="separator" class="divider"></li>
                                <?php else: ?>
                                    <li><a href="<?=base_url('admin/'.$voice['name'])?>"><i class="fa fa-fw <?=$voice['icon'] ?>"></i> <?=$voice['label'] ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-user"></i><?=$user_fname ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="vcms-elevator" data-href="admin/users/user_profile"><i class="fa fa-fw fa-wrench"></i> Modifica utente</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?=base_url('admin/logout') ?>" ><i class="fa fa-fw fa-sign-out"></i> Esci</a></li>
                    </ul>
                </li>

            </ul>
        </div>

    </div>
</nav>
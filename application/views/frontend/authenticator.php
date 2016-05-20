<?php defined('BASEPATH') OR exit('No direct script access allowed');
$form="<form id='frontend-authenticator' method='POST'>
            <div class='input-group'>
                <span class='input-group-addon'><span class='fa fa-user'></span></span>
                <input type='text' class='form-control' placeholder='Nome utente' name='username'>
            </div>
            <br>
            <div class='input-group'>
                <span class='input-group-addon'><span class='fa fa-lock'></span></span>
                <input type='password' class='form-control' placeholder='Password' name='password'>
            </div>
            <br>
            <input type='submit' class='btn btn-default' value='Accedi'>
        </form>";
?><ul class="nav navbar-nav navbar-right">
    <?php if($frontend_logged_in): ?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-fw fa-user"></i><?=$user_intials ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="<?=base_url('system/users/edit_profile') ?>"><i class="fa fa-fw fa-wrench"></i> Modifica utente</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?=base_url('admin/logout') ?>" ><i class="fa fa-fw fa-sign-out"></i> Esci</a></li>
            </ul>
        </li>
    <?php else: ?>
        <li><a tabindex="0" class="popover-trigger" role="button" data-placement="bottom" data-toggle="popover" data-html="true" data-content="<?=$form ?>"><i class="fa fa-user fa-lg"></i> Accedi</a></li>
    <?php endif; ?>
</ul>